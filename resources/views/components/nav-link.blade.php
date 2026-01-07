
<a
wire:navigate.hover
    {{ $attributes }}
    @class([
        'font-semibold transition hover:text-blue-700',
        'px-4 py-2 bg-pink-300 text-white rounded-lg' => request()->routeIs($active),
        'text-gray-600' => ! request()->routeIs($active),
    ])

>
    {{ $slot }}
</a>
