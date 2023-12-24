<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('priority')->get();
        $projects = Project::all();

        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function store(Request $request)
    {
        $task = Task::create($request->all());

        return redirect()->route('tasks.index');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'priority' => 'required|integer',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['success' => true]);
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function updatePriority(Request $request)
    {
        $draggedTaskId = $request->input('draggedTaskId');
        $targetTaskId = $request->input('targetTaskId');

        $draggedTask = Task::findOrFail($draggedTaskId);
        $targetTask = Task::findOrFail($targetTaskId);

        // Swap the priorities
        $tempPriority = $draggedTask->priority;
        $draggedTask->priority = $targetTask->priority;
        $targetTask->priority = $tempPriority;

        $draggedTask->save();
        $targetTask->save();

        return response()->json(['success' => true]);
    }
}
