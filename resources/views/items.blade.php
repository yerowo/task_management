<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Task Manager</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.5.0/css/bootstrap.min.css">
    <style>
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
</head>

<body>
    <div class="container">
        <h2 class="header">Laravel Task Manager</h2>

        <ul class="task-list" id="sortable">
            @if (count($items) > 0)
                @foreach ($items as $row)
                    <li class="task-item ui-state-default" id="{{ $row->id }}">
                        <span class="task-name">{{ $row->item_name }}</span>
                        <div class="action-buttons">
                            <button class="edit-item btn btn-primary btn-sm" data-id="{{ $row->id }}">Edit</button>
                            <button class="delete-item btn btn-danger btn-sm"
                                data-id="{{ $row->id }}">Delete</button>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>

        <div class="add-task-button">
            <button id="create-item" class="btn btn-success">Add Task</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script>
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

            $("#create-item").click(function() {
                // Handle the creation of a new item here, e.g., open a modal or redirect to a create page.
                alert("Implement the task creation logic here.");
            });

            // Edit button click handler
            $(".edit-item").click(function() {
                var itemId = $(this).data("id");
                // Implement logic to edit the task with ID itemId
                alert("Implement the task editing logic for task ID: " + itemId);
            });

            // Delete button click handler
            $(".delete-item").click(function() {
                var itemId = $(this).data("id");
                // Implement logic to delete the task with ID itemId
                alert("Implement the task deletion logic for task ID: " + itemId);
            });
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
    </script>
</body>

</html>
