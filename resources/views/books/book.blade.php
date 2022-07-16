<x-layout>
    <h1 class="text-xl mt-4 text-center">{{ $book['volumeInfo']['title'] }}</h1>
    <div class="bg-blue-400 text-white px-1 py-0.5 rounded-md inline-block">
        @if(isset($book['volumeInfo']['authors']))
        @foreach ($book['volumeInfo']['authors'] as $author)
            <span class="text-xs">{{ $author }}</span>
        @endforeach
        @else
            <span class="text-xs">Автор не указан.</span>
        @endif

    </div>
    <p class="my-2 text-justify">{{ $book['volumeInfo']['description'] ?? 'Описание недоступно.' }}</p>
</x-layout>
