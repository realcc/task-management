@extends('tasks/layout')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Task</h1>
        <div class="row">

            <form method="POST" action="{{ route('tasks.update', ['task' => $task->id]) }}">
                @csrf
                @method('PUT')

                <!-- Task form fields -->
                <label for="name">Task Name:</label>
                <input type="text" name="name" value="{{ $task->name }}" required>

                <label for="priority">Priority:</label>
                <input type="number" name="priority" value="{{ $task->priority }}" required>

                <!-- Add more fields as needed -->

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
