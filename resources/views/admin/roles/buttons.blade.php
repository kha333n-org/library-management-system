<div class="btn-group float-left">
    <a href="{{ route('roles.show', $role->id) }}" class="btn btn-primary">View</a>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('roles.edit', $role->id) }}">Edit</a>
        <button type="button" class="dropdown-item" data-id="{{ $role->id }}"
                onclick="$(this).deleteRole()">Delete
        </button>
    </div>
</div>
