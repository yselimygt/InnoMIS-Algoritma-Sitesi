<?php

class Controller {
    public function view($view, $data = []) {
        extract($data);
        
        $viewFile = __DIR__ . "/../app/Views/$view.php";
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $view not found!");
        }
    }

    public function redirect($url) {
        header("Location: " . APP_URL . $url);
        exit;
    }
}
