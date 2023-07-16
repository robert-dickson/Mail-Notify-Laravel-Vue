<!DOCTYPE html>
<html>

<head>
    <title>Task Reminder</title>
</head>

<body>
    <h2>Task Reminder</h2>
    <p>
        You have an incomplete task:
        <br>
        Task Title: {{ $task->title }}
        <br>
        Task Description: {{ $task->description }}
    </p>
</body>

</html>
