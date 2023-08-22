<!-- resources/views/tasks/index.blade.php -->

@extends('layouts.app')

@section('title', 'Task List')

@section('styles')
    <style>
        /* CSS specific to this page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .task-list {
            list-style: none;
            padding: 0;
        }

        .task-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .task-item:hover {
            background-color: #f0f0f0;
        }

        .task-item .task-name {
            flex-grow: 1;
            font-size: 18px;
        }

        .task-item .action-buttons button {
            margin-left: 10px;
            padding: 5px 10px;
            font-size: 14px;
        }

        .add-task-button {
            text-align: center;
            margin-top: 20px;
        }

        .add-task-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <h2 class="header">Laravel Task Manager</h2>

    <ul class="task-list" id="sortable">
        @if (count($tasks) > 0)
            @foreach ($tasks as $row)
                <li class="task-item ui-state-default" id="{{ $row->id }}">
                    <span class="task-name">{{ $row->task_name }}</span>
                    <div class="action-buttons">
                        <button class="edit-item btn btn-primary btn-sm" data-id="{{ $row->id }}">Edit</button>
                        <button class="delete-item btn btn-danger btn-sm" data-id="{{ $row->id }}">Delete</button>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>

    <div class="add-task-button">
        <button id="create-item" class="btn btn-success">Add Task</button>
    </div>
@endsection

@section('scripts')
    <script>
        // JavaScript code specific to this page
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#sortable").sortable({
                update: function(event, ui) {
                    updateOrder();
                }
            });

            $(function() {
                $("#create-item").click(function() {
                    window.location.href = "{{ route('tasks.create') }}";
                });
            });


            // Edit button click handler
            $(".edit-item").click(function() {
                var itemId = $(this).data("id");
                window.location.href = "{{ route('tasks.edit', '') }}/" + itemId;
            });


            // Delete button click handler
            $(".delete-item").click(function() {
                var itemId = $(this).data("id");

                // Confirm deletion
                if (confirm("Are you sure you want to delete this task?")) {
                    // Perform an AJAX request to delete the task
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ route('tasks.destroy', '') }}/" + itemId,
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            // Remove the deleted task from the UI
                            $("#" + itemId).remove();
                            alert('Task deleted successfully');
                        },
                        error: function(error) {
                            alert('An error occurred while deleting the task');
                        }
                    });
                }
            });


            function updateOrder() {
                var taskOrder = [];
                $('#sortable li').each(function() {
                    taskOrder.push($(this).attr("id"));
                });
                var orderString = 'order=' + taskOrder;
                $.ajax({
                    type: "POST",
                    url: "{{ route('update-order') }}",
                    data: orderString,
                    cache: false,
                    success: function(data) {}
                });
            }
        });
    </script>
@endsection
