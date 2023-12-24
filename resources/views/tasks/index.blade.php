<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <title>Task Management</title>
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Task Management</h1>

    <div class="row">
        <div class="col-md-8">
            <div id="tasks-list" class="mb-4">
                @foreach($tasks as $task)
                    <div class="card mb-3 task" data-id="{{ $task->id }}" draggable="true">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title">{{ $task->name }}</h5>
                            <p class="card-text">
                                Priority: {{ $task->priority }} |
                                Project: {{ $task->project->name }}
                            </p>
                            <button type="button" class="btn btn-danger delete-task">&times;</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <form method="POST" action="{{ route('tasks.store') }}" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label for="taskName" class="form-label">Task Name</label>
                    <input type="text" class="form-control" id="taskName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="taskPriority" class="form-label">Priority</label>
                    <input type="number" class="form-control" id="taskPriority" name="priority" required>
                </div>
                <div class="mb-3">
                    <label for="taskProject" class="form-label">Project</label>
                    <select class="form-select" id="taskProject" name="project_id">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Task</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    const tasks = document.querySelectorAll('.task');

    tasks.forEach(task => {
        task.addEventListener('dragstart', handleDragStart);
        task.addEventListener('dragover', handleDragOver);
        task.addEventListener('drop', handleDrop);

        // Add event listener for the delete button/icon
        const deleteButton = task.querySelector('.delete-task');
        deleteButton.addEventListener('click', handleDeleteTask);
    });

    function handleDragStart(e) {
        e.dataTransfer.setData('text/plain', e.target.dataset.id);
    }

    function handleDragOver(e) {
        e.preventDefault();
    }

    function handleDrop(e) {
        e.preventDefault();

        const draggedTaskId = e.dataTransfer.getData('text/plain');
        const targetTask = findTaskElement(e.target);

        if (draggedTaskId && targetTask) {
            const targetTaskId = targetTask.dataset.id;

            // Send an AJAX request to update priorities
            const formData = new FormData();
            formData.append('draggedTaskId', draggedTaskId);
            formData.append('targetTaskId', targetTaskId);

            fetch('{{ route('tasks.updatePriority') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page or update the UI as needed
                        location.reload();
                    } else {
                        console.error('Failed to update priorities.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function handleDeleteTask(e) {
        const taskId = e.target.closest('.task').dataset.id;

        // Send an AJAX request to delete the task
        fetch('{{ route('tasks.destroy', ['task' => '0']) }}'.replace('0', taskId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page or update the UI as needed
                    location.reload();
                } else {
                    console.error('Failed to delete the task.');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function findTaskElement(element) {
        // Traverse the DOM to find the closest parent with the 'task' class
        while (element && !element.classList.contains('task')) {
            element = element.parentElement;
        }

        return element;
    }
</script>

</body>
</html>
