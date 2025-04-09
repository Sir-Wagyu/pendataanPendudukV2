@props('href', 'icon', 'title', 'active')

<li>
    <a href="{{ $href }}"
        class="{{ $active ? 'bg-warna-200 text-warna-300' : '' }} flex items-center p-2 text-warna-300 hover:bg-warna-200 hover:text-warna-300 group rounded-lg">
        <i class="fa-solid fa-{{ $icon }} text-lg"></i>
        <span class="flex-1 ms-3 whitespace-nowrap">{{ $title }}</span>
    </a>
</li>