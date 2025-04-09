@props(['label', 'name', 'width'=> 'col-span-2', 'type' => 'text', 'placeholder' => '', 'value' => '', 'options' => [], 'select' => []] )

@if ($type == 'text' || $type == 'number' || $type == 'email' || $type == 'date')
    
<div class="relative z-0 {{ $width }} mb-3.5 group">
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $label }}"
    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
    placeholder=" " required />
    <label for="{{ $label }}"
        class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
        {{ $placeholder }}
    </label>
</div>
@elseif ($type == 'select')
<div class="col-span-2">
    <label for="{{ $label }}"
        class="block mb-2 text-sm font-medium text-gray-500">{{ $placeholder }}</label>
    <select id="{{ $label }}" name="{{ $name }}"
        class="peer bg-gray-50 border-0 border-b-2 border-gray-300 text-gray-500 text-sm focus:ring-0 focus:border-blue-600 block w-full p-2.5">
        <option value="">Select an option</option>
        @foreach ($select as $option)
            <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
        @endforeach
    </select>
</div>
@elseif ($type == 'radio')
<div class="col-span-2 mb-3.5">
    <label class="block text-sm font-medium text-gray-500">{{ $placeholder }}</label>
    <div class="flex items-center gap-7 mt-2">
        @foreach ($options as $option)
            <label class="flex items-center space-x-2">
                <input type="radio" name="{{ $name }}" value="{{ $option['value'] }}" class="text-blue-600 focus:ring-blue-500">
                <span class="text-gray-700 text-sm">{{ $option['text'] }}</span>
            </label>
        @endforeach
    </div>
</div>
@endif

