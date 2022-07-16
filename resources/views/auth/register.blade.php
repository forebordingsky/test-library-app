<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Library App</title>
    @vite('resources/css/app.css')
</head>
<body>
    <main class="bg-neutral-400/60 text-gray-700">
        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col px-10 py-12 bg-white shadow-xl modal">
            <h1 class="text-center text-2xl mb-6">Регистрация</h1>
            <form method="POST" action="{{ route('auth.register') }}" class="flex flex-col gap-3">
                @csrf
                @error('name')
                    <label class="text-red-500 text-sm">{{ $message }}</label>
                @enderror
                <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" class="min-w-[100%] border-b outline-none"/>
                @error('email')
                    <label class="text-red-500 text-sm">{{ $message }}</label>
                @enderror
                <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" class="min-w-[100%] border-b outline-none"/>
                @error('password')
                    <label class="text-red-500 text-sm">{{ $message }}</label>
                @enderror
                <input type="password" name="password" placeholder="Password" class="min-w-[100%] border-b outline-none"/>
                <input type="password" name="password_confirmation" placeholder="Repeat password" class="min-w-[100%] border-b outline-none"/>
                <button type="submit" class="mt-6 py-1 px-2 text-white bg-blue-400 hover:bg-blue-600">Зарегистрироваться</button>
            </form>
            <span class="text-sm text-center mt-4">или <a href="{{ route('auth.login.page') }}" class="hover:text-blue-600">Войти</a></span>
        </div>
    </main>
</body>
</html>
