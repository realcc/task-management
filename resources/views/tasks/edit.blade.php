@extends('tasks/layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Task</h1>
        <div class="row">

            <form method="POST" action="{{ route('tasks.update', ['task' => $task->id]) }}">
                @csrf
                @method('PUT')

                <!-- Task form fields -->
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Task Name:</label>
                        <input type="text" class="form-control" name="name" value="{{ $task->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">Priority:</label>
                        <input type="number" class="form-control" name="priority" value="{{ $task->priority }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="project" class="form-label">Project:</label>
                        <select name="project_id" class="form-control">
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ $project->id == $task->project_id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Add more fields as needed -->

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Task</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
