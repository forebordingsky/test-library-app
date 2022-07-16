@props(['title','message','action','input','class' => 'py-1 px-2 text-white bg-blue-400 hover:bg-blue-600'])

<div x-data="{ open: false }">
    <button type="button" @click="open = !open" class="{{ $class }}">{{ $slot }}</button>
    <div class="absolute left-0 top-0 w-full h-full bg-neutral-400/60 z-10 " x-show="open">
        <form method="POST" action="{{ $action }}"
            class="bg-white min-w-[50%] min-h-[40%] flex flex-col gap-2 justify-center absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2"
            @click.outside="open = false">
            @csrf
            <p class="text-center text-lg">{{ $title }}</p>
            <p class="text-center">{{ $message }}</p>
            <input type="hidden" name="book_id" value="{{ $input}}"/>
            <div class="flex justify-center mt-4 gap-3">
                <button class="bg-blue-400 px-2 py-1 rounded-md text-white hover:bg-red-500" type="submit">Да</button>
                <button class="bg-blue-400 px-2 py-1 rounded-md text-white hover:bg-red-500" type="button" @click="open = false">Нет</button>
            </div>
        </form>
    </div>
</div>
