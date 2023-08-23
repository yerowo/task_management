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
