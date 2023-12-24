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
        $task->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['success' => true]);
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
