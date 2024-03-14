@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-md text-charcoal']) }}>
    {{ $value ?? $slot }}
</label>
