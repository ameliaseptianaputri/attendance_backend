<div class="form-group">
    <label for="name">Name</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}">
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="form-group">
    <label for="role">Role</label>
    <select name="role" id="role" class="form-control">
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="user" {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>User</option>
    </select>
</div>

<!-- Add other fields based on your $fillable attributes -->
<div class="form-group">
    <label for="telp">Telephone</label>
    <input type="text" name="telp" class="form-control" value="{{ old('telp', $user->telp ?? '') }}">
</div>

<div class="form-group">
    <label for="alamat">Address</label>
    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $user->alamat ?? '') }}">
</div>

<!-- Add the rest of the fields here based on your $fillable array -->
