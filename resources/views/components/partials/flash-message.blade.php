<div x-data="{show: true }" x-init="$nextTick(() => { setTimeout(() =>{ show = false },2000) })" x-show="show" x-transition.opacity.duration.500ms
    class="bg-blue-400 py-1 px-2 my-4 shadow-md text-center text-white">
    {{ $slot }}
</div>
