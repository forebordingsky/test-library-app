<x-layout active="library" title="Библиотека">
    @if ($message = Session::get('message'))
        <x-partials.flash-message>{{ $message }}</x-partials.flash-message>
    @endif
    @if(count($books))
        <table class="table-auto my-4 min-w-full">
            <tbody>
                @foreach ($books as $key => $book)
                    <tr class="border-b border-blue-400">
                        <td class="p-2">{{ ++$key }}</td>
                        <td class="p-2">{{ $book['volumeInfo']['title'] }}</td>
                        <td class="p-1 flex gap-2 justify-end">
                            <a class="py-1 px-2 text-white hover:bg-green-600 bg-green-500" href="{{ route('books.book',$book['id']) }}">I</a>
                            <x-partials.modal
                                title="Вы желаете добавить книгу в избранное?"
                                :message="$book['volumeInfo']['title']"
                                :action="route('books.favorite.add')"
                                :input="$book['id']">
                                F
                            </x-partials.modal>
                            <x-partials.modal class="py-1 px-2 text-white bg-red-400 hover:bg-red-600"
                                title="Вы желаете убрать книгу из вашей библиотеки?"
                                :message="$book['volumeInfo']['title']"
                                :action="route('books.remove')"
                                :input="$book['id']">
                                D
                            </x-partials.modal>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Пока ничего</p>
    @endif
</x-layout>
