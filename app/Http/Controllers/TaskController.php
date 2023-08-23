<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('priority')->get();
        $projects = Project::orderBy('name')->get();

        return view("tasks.index", compact("tasks", "projects"));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('tasks.create', compact('projects'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'task_name' => 'required|string|max:50',
            'priority' => 'required|in:high,medium,low',
            'project_id' => 'nullable|exists:projects,id', // Validate project_id if provided
        ]);

        // Map priority values based on the selected option
        $priorityMap = [
            'high' => 0,
            'medium' => 1,
            'low' => 2,
        ];

        $task = new Task;
        $task->task_name = $request->input('task_name');
        $task->priority = $priorityMap[$request->input('priority')];
        $task->status = 1; // Assuming 1 means active

        // Set the project_id if provided
        $task->project_id = $request->input('project_id');

        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }


    public function edit($task)
    {
        try {
            $task = Task::find($task);
            if (!$task) {
                throw new \Exception("Task not found");
            }
            $projects = Project::orderBy('name')->get();
            return view('tasks.edit', compact('task', 'projects'));
        } catch (\Exception $e) {
            // Handle the exception, e.g., return an error view or redirect with a message.
            return redirect()->route('tasks.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'priority' => 'required|integer|in:0,1,2',
            'project_id' => 'nullable|exists:projects,id', // Validate project_id if provided
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'task_name' => $request->input('task_name'),
            'priority' => $request->input('priority'),
            'project_id' => $request->input('project_id'), // Update the project_id
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function updateOrder(Request $request)
    {
        $input = $request->all();

        if (isset($input["order"])) {
            $order = explode(",", $input["order"]);
            foreach ($order as $index => $taskId) {
                $task = Task::find($taskId);
                if ($task) {
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

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                "status" => false,
                "message" => "Task not found"
            ], 404);
        }

        $task->delete();

        return response()->json([
            "status" => true,
            "message" => "Task deleted successfully"
        ]);
    }

    public function filter(Request $request)
    {
        $projectId = $request->input('project_id');

        if ($projectId) {
            $tasks = Task::where('project_id', $projectId)->orderBy('priority')->get();
        } else {
            $tasks = Task::orderBy('priority')->get();
        }

        return view('tasks.filtered', compact('tasks'))->render();
    }
}
