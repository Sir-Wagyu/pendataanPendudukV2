<div 
    x-data="{ show: false }"
    x-init="setTimeout(() => show = true, 10)"
    x-show="show"
    x-transition:enter="transition transform ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-50"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition transform ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-50"
    {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-lg']) }}
>
    {{ $slot }}
</div>