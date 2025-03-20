<ul style="list-style: none; padding: 0; margin-top: 20px;">
    <?php if (empty($tasks)): ?>
    <li>No tasks yet. Add one above!</li>
    <?php else: ?>
    <?php foreach ($tasks as $index => $task): ?>
    <li class="task-item">
        <form method="POST" style="flex-grow: 1; display: flex;">
            <input type="hidden" name="toggle" value="<?php echo $index; ?>">
            <button type="submit" style="border: none; background: none; cursor: pointer; text-align: left; width: 100%;">
                <span class="<?php echo $task['completed'] ? 'task-done' : 'task'; ?>">
                    <?php echo htmlspecialchars($task['task']); ?>
                </span>
            </button>
        </form>
        <form method="POST" style="margin-left: 10px;">
            <input type="hidden" name="delete" value="<?php echo $index; ?>">
            <button type="submit" style="border: none; background: none; color: red;">❌</button>
        </form>
    </li>
    <?php endforeach; ?>
    <?php endif; ?>
</ul>
