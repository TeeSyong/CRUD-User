@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User List</h2>

    <div class=" mb-4 d-flex justify-content-between ">
        <div>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
            <a href="{{ route('users.exportExcel') }}" class="btn btn-success">Export to Excel</a>
        </div>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="mb-3">
        <div class="d-flex align-items-center gap-2">
            <label for="status" class="mb-0">Filter by Status:</label>
            <select name="status" id="status" class="form-control w-auto" onchange="this.form.submit()">
                <option value="">-- All --</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </form>
    
    <form method="POST" action="{{ route('users.bulkDelete') }}">
        @csrf
        <button type="submit" class="btn btn-danger mb-2" onclick="return confirm('Delete selected users?')">Delete Selected</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td><input type="checkbox" name="ids[]" value="{{ $user->id }}"></td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info">Edit</a>
                        <button 
                          class="btn btn-sm btn-danger" 
                          onclick="submitDelete({{ $user->id }})"
                          type="button"
                        >
                          Delete
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">No users found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </form>
        {{ $users->links() }}

    <form method="POST" id="deleteForm" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>

<script>
    document.getElementById('select-all').onclick = function () {
        const checkboxes = document.querySelectorAll('input[name="ids[]"]');
        checkboxes.forEach(cbox => cbox.checked = this.checked);
    };

    function submitDelete(userId) {
        if (!confirm("Delete this user?")) return;

        const form = document.getElementById('deleteForm');
        form.action = `/admin/users/${userId}`;
        form.submit();
    }
</script>
@endsection