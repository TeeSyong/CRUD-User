@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>
    <a href="{{ route('users.index') }}" class="btn btn-primary mb-3">
    Back
    </a>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input 
                name="name" 
                value="{{  $user->name }}" 
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter full name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <input 
                name="email" 
                value="{{ $user->email }}" 
                class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter email address"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input 
                name="phone_number" 
                value="{{  $user->phone_number}}" 
                class="form-control @error('phone_number') is-invalid @enderror"
                placeholder="Enter phone number"
            >
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Status</label>
            <select 
                name="status" 
                class="form-control @error('status') is-invalid @enderror"
            >
                <option value="">-- Select Status --</option>
                <option value="active" {{  $user->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{  $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button class="btn btn-success ">Update User</button>
    </form>
</div>
@endsection