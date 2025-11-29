<?php

class Sandbox {
    private $tempDir;
    private $mode;

    public function __construct() {
        $this->tempDir = __DIR__ . '/../storage/temp';
        if (!file_exists($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
        $this->mode = defined('SANDBOX_MODE') ? SANDBOX_MODE : 'local';
    }

    public function run($language, $code, $input) {
        switch ($this->mode) {
            case 'docker':
                return $this->runDocker($language, $code, $input);
            case 'judge0':
                return $this->runJudge0($language, $code, $input);
            default:
                return $this->runLocal($language, $code, $input);
        }
    }

    private function runDocker($language, $code, $input) {
        $file = $this->writeSourceFile($language, $code);
        $inputFile = $file['base'] . '.in';
        file_put_contents($inputFile, $input);

        $image = $this->dockerImageFor($language);
        if (!$image) {
            return ['status' => 'CE', 'output' => 'Desteklenmeyen dil'];
        }

        $compileCmd = $this->dockerCompileCmd($language, $file['container']);
        $runCmd = $this->dockerRunCmd($language, $file['container']);

        $volume = escapeshellarg($this->tempDir . ':/sandbox');
        $baseCommand = "docker run --rm --net=none -m 256m --cpus=1 --pids-limit 128 -v {$volume} -w /sandbox {$image}";

        if ($compileCmd) {
            $compile = "{$baseCommand} /bin/sh -c " . escapeshellarg($compileCmd);
            exec($compile, $out, $codeCompile);
            if ($codeCompile !== 0) {
                $this->cleanup($file['base']);
                return ['status' => 'CE', 'output' => implode("\n", $out)];
            }
        }

        $command = "{$baseCommand} /bin/sh -c " . escapeshellarg("timeout 5s {$runCmd} < {$file['container']}.in");
        $start = microtime(true);
        exec($command, $output, $codeRun);
        $execTime = microtime(true) - $start;

        $this->cleanup($file['base']);

        if ($codeRun !== 0) {
            return ['status' => 'RE', 'output' => implode("\n", $output)];
        }

        return [
            'status' => 'AC',
            'output' => trim(implode("\n", $output)),
            'time' => $execTime
        ];
    }

    private function runJudge0($language, $code, $input) {
        $apiKey = JUDGE0_API_KEY; // config.php'den gelecek
        $endpoint = JUDGE0_URL . "/submissions?base64_encoded=false&wait=true";
        
        // Dil ID'leri (Judge0 standart ID'leri)
        $langIds = [
            'c' => 50, // GCC 9.2.0
            'cpp' => 54, // GCC 9.2.0
            'python' => 71, // Python 3.8.1
            'java' => 62, // OpenJDK 13.0.1
        ];

        if (!isset($langIds[$language])) {
            return ['status' => 'CE', 'output' => 'Dil desteklenmiyor.'];
        }

        $postData = [
            'source_code' => $code,
            'language_id' => $langIds[$language],
            'stdin' => $input
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            // Eğer RapidAPI kullanıyorsanız bu başlıkları açın:
            // 'X-RapidAPI-Key: ' . $apiKey,
            // 'X-RapidAPI-Host: judge0-ce.p.rapidapi.com'
        ]);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            return ['status' => 'CE', 'output' => 'Sandbox hatası: ' . curl_error($ch)];
        }
        curl_close($ch);

        $result = json_decode($response, true);

        // Sonucu InnoMIS formatına çevir
        // Judge0 status id: 3 (Accepted), 4 (Wrong Answer), 5 (Time Limit), 6 (Compilation Error) vb.
        $statusId = $result['status']['id'] ?? 0;
        $finalStatus = 'PENDING';
        $output = '';

        if ($statusId == 3) {
            $finalStatus = 'AC';
            $output = $result['stdout'] ?? '';
        } elseif ($statusId == 4) {
            $finalStatus = 'WA';
            $output = "Beklenen çıktı ile uyuşmadı.\nÇıktı:\n" . ($result['stdout'] ?? '');
        } elseif ($statusId == 6) {
            $finalStatus = 'CE';
            $output = $result['compile_output'] ?? '';
        } else {
            $finalStatus = 'RE'; // Diğer hatalar (Runtime Error vb.)
            $output = $result['stderr'] ?? ($result['message'] ?? 'Hata');
        }

        return [
            'status' => $finalStatus,
            'output' => trim($output),
            'time' => $result['time'] ?? 0
        ];
    }

    private function runLocal($language, $code, $input) {
        // SECURITY WARNING: This method executes code directly on the host machine.
        // It is extremely dangerous and should NOT be used in production.
        // Use 'docker' or 'judge0' mode for secure execution.
        
        $file = $this->writeSourceFile($language, $code);
        $inputFile = $file['base'] . '.in';
        $outputFile = $file['base'] . '.out';
        $errorFile = $file['base'] . '.err';
        file_put_contents($inputFile, $input);

        $compileCommand = $this->getCompileCommand($language, $file['path'], $file['base']);
        $runCommand = $this->getRunCommand($language, $file['base']);

        if ($compileCommand) {
            exec($compileCommand . " 2> " . escapeshellarg($errorFile), $compileOutput, $returnVar);
            if ($returnVar !== 0) {
                $error = file_get_contents($errorFile);
                $this->cleanup($file['dir']);
                return ['status' => 'CE', 'output' => $error];
            }
        }

        $startTime = microtime(true);
        // Added basic timeout for local execution (linux only, for windows use different approach or rely on PHP max_execution_time)
        // Since user is on Windows, 'timeout' command might not exist or work differently. 
        // We will just run the command directly for now, but this is risky.
        
        $cmd = "$runCommand < " . escapeshellarg($inputFile) . " > " . escapeshellarg($outputFile) . " 2> " . escapeshellarg($errorFile);
        
        // On Windows, we might need to handle redirection differently if using cmd.exe, but exec() usually handles it.
        exec($cmd, $output, $returnVar);
        $executionTime = microtime(true) - $startTime;

        if ($returnVar !== 0) {
            $error = file_get_contents($errorFile);
            $this->cleanup($file['dir']);
            return ['status' => 'RE', 'output' => $error];
        }

        $output = file_get_contents($outputFile);
        $this->cleanup($file['dir']);

        return [
            'status' => 'AC',
            'output' => trim($output),
            'time' => $executionTime
        ];
    }

    private function writeSourceFile($language, $code) {
        $uniqueId = uniqid('run_', true);
        $dir = $this->tempDir . '/' . $uniqueId;
        
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $filename = 'solution';
        $ext = '';
        switch ($language) {
            case 'c': $ext = '.c'; break;
            case 'cpp': $ext = '.cpp'; break;
            case 'python': $ext = '.py'; break;
            case 'java': 
                $ext = '.java'; 
                $filename = 'Main'; // Enforce Main class for Java
                break;
        }
        
        $path = $dir . '/' . $filename . $ext;
        file_put_contents($path, $code);
        
        return [
            'dir' => $dir,
            'base' => $dir . '/' . $filename,
            'path' => $path,
            'container' => '/sandbox/' . $uniqueId . '/' . $filename . $ext
        ];
    }

    private function dockerImageFor($language) {
        switch ($language) {
            case 'c':
            case 'cpp':
                return 'gcc:12';
            case 'python':
                return 'python:3.11';
            case 'java':
                return 'openjdk:17';
            default:
                return null;
        }
    }

    private function dockerCompileCmd($language, $containerPath) {
        $base = preg_replace('/\\.[^.]+$/', '', $containerPath);
        switch ($language) {
            case 'c': return "gcc {$containerPath} -O2 -std=c11 -o {$base}.out";
            case 'cpp': return "g++ {$containerPath} -O2 -std=c++17 -o {$base}.out";
            case 'java': return "javac {$containerPath}";
            case 'python': return null;
            default: return null;
        }
    }

    private function dockerRunCmd($language, $containerPath) {
        $base = preg_replace('/\\.[^.]+$/', '', $containerPath);
        switch ($language) {
            case 'c':
            case 'cpp':
                return "{$base}.out";
            case 'python':
                return "python {$containerPath}";
            case 'java':
                $dir = dirname($containerPath);
                return "cd {$dir} && java Main";
            default:
                return '';
        }
    }

    private function getCompileCommand($language, $sourceFile, $basePath) {
        switch ($language) {
            case 'c': return "gcc " . escapeshellarg($sourceFile) . " -o " . escapeshellarg($basePath . '.exe');
            case 'cpp': return "g++ " . escapeshellarg($sourceFile) . " -o " . escapeshellarg($basePath . '.exe');
            case 'java': return "javac " . escapeshellarg($sourceFile);
            case 'python': return null;
        }
        return null;
    }

    private function getRunCommand($language, $basePath) {
        switch ($language) {
            case 'c': return escapeshellarg($basePath . '.exe');
            case 'cpp': return escapeshellarg($basePath . '.exe');
            case 'python': return "python " . escapeshellarg($basePath . '.py');
            case 'java': 
                $dir = dirname($basePath);
                return "cd " . escapeshellarg($dir) . " && java Main";
        }
        return null;
    }

    private function cleanup($dir) {
        if (is_dir($dir)) {
            $files = glob($dir . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($dir);
        }
    }
}
