@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="container">
        <h2>Edit Task</h2>
        <form id="edit-task-form" method="POST" action="{{ route('tasks.update', $task->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Task Name</label>
                <input type="text" class="form-control" id="name" name="task_name"
                    value="{{ old('task_name', $task->task_name) }}" required>
            </div>
            <div class="form-group">
                <label for="priority">Priority</label>
                <select class="form-control" id="priority" name="priority">
                    <option value="0" {{ old('priority', $task->priority) === 0 ? 'selected' : '' }}>High</option>
                    <option value="1" {{ old('priority', $task->priority) === 1 ? 'selected' : '' }}>Medium</option>
                    <option value="2" {{ old('priority', $task->priority) === 2 ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            <div class="form-group">
                <label for="project_id">Project</label>
                <select class="form-control" id="project_id" name="project_id">
                    <option value="" selected>Select a Project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Intercept the form submission
            $('#edit-task-form').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                // Perform an AJAX request to update the task
                $.ajax({
                    type: 'POST',
                    url: "{{ route('tasks.update', $task->id) }}",
                    data: $(this).serialize(), // Serialize the form data
                    success: function(data) {
                        window.location.href = "{{ route('tasks.index') }}";
                    },
                    error: function(error) {
                        alert('An error occurred while updating the task');
                    }
                });
            });
        });
    </script>
@endsection
