<?php

require_once __DIR__ . '/../Models/LearningPathModel.php';

class LearningPathController extends Controller {
    public function index() {
        $model = new LearningPathModel();
        $paths = $model->getAll();
        $this->view('paths/index', ['paths' => $paths]);
    }

    public function show($id) {
        $model = new LearningPathModel();
        $path = $model->getById($id);
        $steps = $model->getSteps($id);
        
        $this->view('paths/show', ['path' => $path, 'steps' => $steps]);
    }
}
