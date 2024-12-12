<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Show tasks with pagination
    public function index()
    {
        $tasks = Task::paginate(20); // Pagination for 20 tasks per page
        return view('tasks.index', compact('tasks'));
    }

    // Show the task creation form
    public function create()
    {
        return view('tasks.create');
    }

    // Store the new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = Auth::id(); // Assign task to the logged-in user
        $task->save();

        return redirect()->route('tasks.index')->with('status', 'Task created successfully!');
    }

    // Show the task edit form
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to edit this task.');
        }
        return view('tasks.edit', compact('task'));
    }

    // Update the task
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();

        return redirect()->route('tasks.index')->with('status', 'Task updated successfully!');
    }

    // Delete the task
    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->with('error', 'You are not authorized to delete this task.');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('status', 'Task deleted successfully!');
    }
}
