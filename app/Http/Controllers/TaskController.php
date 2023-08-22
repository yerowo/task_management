<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('priority')->get();

        return view("tasks.index", compact("tasks"));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'task_name' => 'required|string|max:50',
            'priority' => 'required|in:high,medium,low',
        ]);

        // Map priority values based on selected option
        $priorityMap = [
            'high' => 0,
            'medium' => 1,
            'low' => 2,
        ];

        $task = new Task;
        $task->task_name = $request->input('task_name');
        $task->priority = $priorityMap[$request->input('priority')];
        $task->status = 1; // Assuming 1 means active

        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    public function edit($task)
    {
        $task = Task::find($task);
        if (!$task) {
            abort(404);
        }

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'priority' => 'required|integer|in:0,1,2', // Check for integer values 0, 1, or 2
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'task_name' => $request->input('task_name'),
            'priority' => $request->input('priority'), // Update the priority
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function updateOrder(Request $request)
    {
        $input = $request->all();

        if (isset($input["order"])) {
            $order = explode(",", $input["order"]);

            // Use a loop to update the priority of each task
            foreach ($order as $index => $taskId) {
                // Find the task by its ID
                $task = Task::find($taskId);

                // Check if the task exists
                if ($task) {
                    // Update the priority based on the loop index
                    $task->update(['priority' => $index]);
                }
            }

            return json_encode([
                "status" => true,
                "message" => "Order updated"
            ]);
        }

        return json_encode([
            "status" => false,
            "message" => "No order data provided"
        ]);
    }
}
