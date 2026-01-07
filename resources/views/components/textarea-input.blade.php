@props(['disabled' => false, 'value' => ''])

<textarea @disabled($disabled) {{ $attributes->merge(['class' => 'border-2 border-gray-100 bg-gray-50 focus:border-secondary focus:ring-0 focus:bg-white rounded-2xl shadow-sm transition-all duration-300 font-bold text-toys-text']) }}>{{ $value }}</textarea>
