<?php

class Sandbox {
    private $tempDir;

    public function __construct() {
        $this->tempDir = __DIR__ . '/../storage/temp';
        if (!file_exists($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
    }

    public function run($language, $code, $input) {
        $filename = uniqid();
        $filePath = $this->tempDir . '/' . $filename;
        $inputFile = $filePath . '.in';
        $outputFile = $filePath . '.out';
        $errorFile = $filePath . '.err';

        // Write code and input to files
        $sourceFile = $this->writeSourceFile($filePath, $language, $code);
        file_put_contents($inputFile, $input);

        $compileCommand = $this->getCompileCommand($language, $sourceFile, $filePath);
        $runCommand = $this->getRunCommand($language, $filePath);

        // Compile
        if ($compileCommand) {
            $compileOutput = [];
            $returnVar = 0;
            exec($compileCommand . " 2> " . $errorFile, $compileOutput, $returnVar);
            
            if ($returnVar !== 0) {
                $error = file_get_contents($errorFile);
                $this->cleanup($filePath);
                return ['status' => 'CE', 'output' => $error];
            }
        }

        // Run
        $startTime = microtime(true);
        // Timeout logic should be added here (e.g. using `timeout` command on Linux)
        // For Windows, it's harder to enforce timeout without external tools.
        // We will assume standard execution for now.
        
        $command = "$runCommand < $inputFile > $outputFile 2> $errorFile";
        exec($command, $output, $returnVar);
        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        if ($returnVar !== 0) {
             $error = file_get_contents($errorFile);
             $this->cleanup($filePath);
             return ['status' => 'RE', 'output' => $error];
        }

        $output = file_get_contents($outputFile);
        $this->cleanup($filePath);

        return [
            'status' => 'AC', // This is just execution status, not correctness
            'output' => trim($output),
            'time' => $executionTime
        ];
    }

    private function writeSourceFile($basePath, $language, $code) {
        $ext = '';
        switch ($language) {
            case 'c': $ext = '.c'; break;
            case 'cpp': $ext = '.cpp'; break;
            case 'python': $ext = '.py'; break;
            case 'java': $ext = '.java'; break; // Java needs class name matching filename usually, handling Main class
        }
        
        // For Java, we might need to parse class name or enforce Main
        if ($language == 'java') {
             // Simple hack: replace class name with Main or force user to use Main
             $basePath = $this->tempDir . '/Main'; 
        }

        $path = $basePath . $ext;
        file_put_contents($path, $code);
        return $path;
    }

    private function getCompileCommand($language, $sourceFile, $basePath) {
        switch ($language) {
            case 'c': return "gcc $sourceFile -o $basePath.exe";
            case 'cpp': return "g++ $sourceFile -o $basePath.exe";
            case 'java': return "javac $sourceFile";
            case 'python': return null;
        }
        return null;
    }

    private function getRunCommand($language, $basePath) {
        switch ($language) {
            case 'c': return "$basePath.exe";
            case 'cpp': return "$basePath.exe";
            case 'python': return "python $basePath.py";
            case 'java': 
                // Java runs from the directory
                $dir = dirname($basePath);
                return "cd $dir && java Main"; 
        }
        return null;
    }

    private function cleanup($basePath) {
        // Delete all related files
        array_map('unlink', glob("$basePath*"));
        if (file_exists($this->tempDir . '/Main.java')) unlink($this->tempDir . '/Main.java');
        if (file_exists($this->tempDir . '/Main.class')) unlink($this->tempDir . '/Main.class');
    }
}
