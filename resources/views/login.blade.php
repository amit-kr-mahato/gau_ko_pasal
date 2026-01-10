<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold text-center mb-6">Login</h2>

    @if($errors->any())
        <div class="text-red-600 mb-4 text-center">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-4" required>
        <input type="password" name="password" placeholder="Password" class="w-full border p-2 mb-4" required>
        <label class="flex items-center mb-4">
            <input type="checkbox" name="remember" class="mr-2"> Remember Me
        </label>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Login</button>
    </form>

    <p class="text-center mt-4">Don't have an account? <a href="{{ route('register.form') }}" class="text-blue-600">Register</a></p>
</div>

</body>
</html>
