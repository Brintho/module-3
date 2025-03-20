<?php
define('TASKS_FILE', 'tasks.json');

function saveTasks(array $tasks): void
{
    file_put_contents(TASKS_FILE, json_encode($tasks, JSON_PRETTY_PRINT));
}

function loadTasks(): array
{
    if (file_exists(TASKS_FILE)) {
        $data = file_get_contents(TASKS_FILE);
        return json_decode($data, true) ?? [];
    }
    return [];
}

$tasks = loadTasks();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task']) && ! empty(trim($_POST['task']))) {
        $tasks[] = [
            'task'      => htmlspecialchars(trim($_POST['task'])),
            'completed' => false,
        ];
        saveTasks($tasks);
        header('Location: task.php');
        exit();
    }

    // Toggle Task
    if (isset($_POST['toggle'])) {
        $index = (int) $_POST['toggle'];
        if (isset($tasks[$index])) {
            $tasks[$index]['completed'] = ! $tasks[$index]['completed'];
            saveTasks($tasks);
        }
        header('Location: task.php');
        exit();
    }

    // Delete Task
    if (isset($_POST['delete'])) {
        $index = (int) $_POST['delete'];
        if (isset($tasks[$index])) {
            array_splice($tasks, $index, 1);
            saveTasks($tasks);
        }
        header('Location: task.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Simple To-Do App</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
    </head>

    <body>
        <div class="container">
            <div class="task-card">
                <h1>📝 To-Do App</h1>

                <!-- Add Task Form -->
                <form method="POST">
                    <div class="row">
                        <div class="column column-75">
                            <input type="text" name="task" placeholder="Enter a new task" required>
                        </div>
                        <div class="column column-25">
                            <button type="submit" class="button-primary">Add Task</button>
                        </div>
                    </div>
                </form>

                <!-- Task List Include -->
                <?php include 'task_list.php'; ?>

            </div>
        </div>
    </body>

</html>
