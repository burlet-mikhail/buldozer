@props(['value'])

<label {{ $attributes->merge(['class' => 'labelbox']) }}>
    {{ $value ?? $slot }}
</label>
