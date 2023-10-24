<?php
require 'model.php';
require 'view.php';

class TaskController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new TaskModel();
        $this->view = new TaskView();
    }

    public function addTask($task) {
        $this->model->addTask($task);
    }

    public function showTasks() {
        $tasks = $this->model->getTasks();
        $this->view->showTasks($tasks);
    }
}

$controller = new TaskController();

if (isset($_POST['task'])) {
    $task = $_POST['task'];
    $controller->addTask($task);
}

$controller->showTasks();
?>  
