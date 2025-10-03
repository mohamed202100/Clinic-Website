<div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" class="form-control">
</div>

<div class="mb-3">
    <label>Role</label>
    <select name="role" class="form-control">
        @foreach (['doctor', 'receptionist', 'admin'] as $role)
            <option value="{{ $role }}" {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Specialization</label>
    <input type="text" name="specialization" value="{{ old('specialization', $user->specialization ?? '') }}"
        class="form-control">
</div>

<div class="mb-3">
    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control">
</div>

<button type="submit" class="btn btn-success">{{ $buttonText }}</button>
<a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
