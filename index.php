<!DOCTYPE html>
<html>

<head>
    <title>MVC Example</title>
</head>

<body>
    <h1>Task List</h1>
    <?php
    require 'controller.php';
    $controller = new TaskController();
    $controller->showTasks();
    ?>

    <form method="post">
        <input type="text" name="task" placeholder="Add a task" required>
        <input type="submit" value="Add">
    </form>
</body>

</html>