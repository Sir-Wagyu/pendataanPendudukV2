
@props([
    'name' => '',
    'label' => '',
    'type' => 'text',
    'wireModel' => null,
    'error' => null,
    'id' => null,
    'class' => '',
    'options' => [],
    'size' => 'w-full',
    'rows' => 3,
])
@if($type === 'textarea')
    <div class="relative {{ $size ?? 'w-full' }}">
        <textarea
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm peer {{ $class }}"
            placeholder=" "
            wire:model="{{ $wireModel ?? $name }}"
            {{ $attributes }}
            rows="{{ $rows }}"
        ></textarea>
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
        >
            {{ $label }}
        </label>
    </div>
@elseif($type === 'select')
    <div class="relative {{ $size }}">
        <select
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  {{ $class }}"
            {{ $attributes }}
        >
            <option  value="" disabled>Pilih {{ $label }}</option>
            @foreach($options ?? [] as $optionValue => $optionLabel)
                <option class="py-3" value="{{ $optionValue }}">{{ $optionLabel }}</option>
            @endforeach
        </select>
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 left-3"
        >
            {{ $label }}
        </label>    
    </div>
@elseif($type === 'date')
    <div class="relative {{ $size ?? 'w-full' }}">
        <input
            type="date"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer {{ $class }}"
            wire:model="{{ $wireModel ?? $name }}"
            {{ $attributes }}
        />
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
        >
            {{ $label }}
        </label>
    </div>
@else
    <div class="relative {{ $size ?? 'w-full' }}">
        <input
            type="{{ $type }}"
            id="{{ $id ?? $name }}"
            name="{{ $name }}"
            class="block w-full px-3 py-2 md:py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-warna-400 focus:border-warna-400 sm:text-sm  peer {{ $class }}"
            placeholder=" "
            wire:model="{{ $wireModel ?? $name }}"
            {{ $attributes }}
        />
        <label
            for="{{ $id ?? $name }}"
            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-warna-400 peer-focus:dark:text-indigo-400 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 left-3"
        >
            {{ $label }}
        </label>
    </div>
@endif
@if($error)
    <span class="text-red-500 text-xs">{{ $error }}</span>
@endif
