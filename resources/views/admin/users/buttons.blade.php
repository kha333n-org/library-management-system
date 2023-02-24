@php use App\Utils\Permissions; @endphp
<div class="btn-group float-left">
    @can(Permissions::$VIEW_USERS)
        <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary">View</a>
        @canany([Permissions::$EDIT_USERS, Permissions::$DELETE_USERS])
            <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                @can(Permissions::$EDIT_USERS)
                    <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">Edit</a>
                @endcan
                @can(Permissions::$ALLOCATE_ROLES)
                    <a class="dropdown-item" href="{{ route('users.roles', $user->id) }}">Roles</a>
                @endcan
                @can(Permissions::$DELETE_USERS)
                    <button type="button" class="dropdown-item" data-id="{{ $user->id }}"
                            onclick="$(this).deleteUser()">Delete
                    </button>
                @endcan
            </div>
        @endcanany
    @endcan
</div>
