<button {{ $attributes->merge(['type' => 'submit', 'class' => 'button btn__site']) }} type="submit">
    <span>{{ $slot }}</span></button>
