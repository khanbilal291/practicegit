<?php
class TaskModel {
    private $tasks = [];

    public function addTask($task) {
        $this->tasks[] = $task;
    }

    public function getTasks() {
        return $this->tasks;
    }
}
?>