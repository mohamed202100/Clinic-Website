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
    <label>Phone</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" class="form-control">
</div>

<button type="submit" class="btn btn-success">{{ $buttonText }}</button>
<a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
