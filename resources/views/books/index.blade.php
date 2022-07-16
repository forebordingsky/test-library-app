<x-layout active="search" title="Поиск">
    @if ($message = Session::get('message'))
        <x-partials.flash-message>{{ $message }}</x-partials.flash-message>
    @endif
    <form method="GET" class="my-4 flex gap-2 justify-center text-gray-500">
        <input type="search" name="search" value="{{ request('search') }}" class="min-w-[60%] border-b outline-none" placeholder="Поиск"/>
        <button type="submit" class="py-1 px-2 text-white bg-blue-400 hover:bg-blue-600">
            Поиск
        </button>
    </form>
    @if(count($books))
        <p class="bg-blue-400 text-white px-1 py-0.5 rounded-md inline-block text-xs">Всего найдено по запросу - {{ request('search') }}: {{ $total }}</p>
        {{-- TODO: Пагинация --}}
        <a href="#"><<</a> | <a href="{{ route('books.index',['search' => request('search'),'page' => request('page') + 10]) }}">>></a>
        <table class="table-auto my-4 min-w-full">
            <tbody>
                @foreach ($books as $key => $book)
                    <tr class="border-b border-blue-400">
                        <td class="p-2">{{ ++$key }}</td>
                        <td class="p-2">{{ $book['volumeInfo']['title'] }}</td>
                        <td class="p-1 flex gap-2 justify-end">
                            <x-partials.modal
                                title="Вы желаете добавить книгу в библиотеку?"
                                :message="$book['volumeInfo']['title']"
                                :action="route('books.add')"
                                :input="$book['id']">
                                Добавить
                            </x-partials.modal>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Пока ничего.</p>
    @endif
</x-layout>
