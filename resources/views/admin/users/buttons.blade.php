<div class="btn-group float-right">
    <a href="{{ route('users.view', $user->id) }}" class="btn btn-primary">View</a>
    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">Edit</a>
        <button type="button" class="dropdown-item" data-id="{{ $user->id }}"
                onclick="$(this).deleteUser()">Delete
        </button>
    </div>
</div>
