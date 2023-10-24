<?php
class TaskView {
    public function showTasks($tasks) {
        echo "<ul>";
        foreach ($tasks as $task) {
            echo "<li>$task</li>";
        }
        echo "</ul>";
    }
}
?>