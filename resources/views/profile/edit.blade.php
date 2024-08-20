<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    @vite('resources/css/app.css')
</head>
<body>
    <h1>Edit Profile</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <button type="submit">Update Profile</button>
    </form>

    <h2>Change Password</h2>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <div>
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>

        <div>
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>

        <div>
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>

        <button type="submit">Update Password</button>
    </form>
</body>
</html>
