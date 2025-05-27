@props(['items' => []])

<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-secondary mt-3">
        @foreach ($items as $item)
            @if ($loop->last)
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $item['label'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}" class="text-white">{{ $item['label'] }}
                        &#11162;</a></li>
            @endif
        @endforeach
    </ol>
</nav>
