@props(['active' => ''])
<header class="bg-blue-400 shadow-md">
    <div class="layout-center">
        <nav class="flex justify-between">
            <div class="flex">

                <a class="text-white hover:bg-white hover:text-blue-500 p-2 {{ $active == 'search' ? 'bg-white text-blue-500': ''}}" href="{{ route('books.index') }}">Поиск</a>
                <a class="text-white hover:bg-white hover:text-blue-500 p-2 {{ $active == 'library' ? 'bg-white text-blue-500': ''}}" href="{{ route('books.user') }}">Библиотека</a>
                <a class="text-white hover:bg-white hover:text-blue-500 p-2 {{ $active == 'favorite' ? 'bg-white text-blue-500': ''}}" href="{{ route('books.user.favorite') }}">Избранное</a>
            </div>
            <div>
                <form method="POST" action="{{ route('auth.logout') }}">
                    @csrf
                    <button class="text-white hover:underline p-2" type="submit">Выйти</button>
                </form>
            </div>
        </nav>
    </div>
</header>
