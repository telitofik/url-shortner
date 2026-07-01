<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">URL Shortener</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4">
        @if(session('error'))
            <p>{{ session('error') }}</p>
        @endif

        <form action="{{ route('links.store') }}" method="POST">
            @csrf
            <input type="text" name="url" placeholder="Enter your URL here" style="width:300px">
            <button type="submit">Shorten</button>
        </form>
        @if($errors->any())
            <p style="color:red">Enter valid URL</p>
        @endif

        @forelse ($links as $link)
            @php
                $color = $link->expires_at?->isPast() ? 'red':'green';
            @endphp
            <div style="color:{{$color}}">
                <a href="/{{ $link->code }}">127.0.0.1:8000/{{ $link->code }}</a>
                -- {{ $link->url }}
                -- {{ $link->clicks }} clicks
            </div>
            <form action="{{ route('links.destroy', $link->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        @empty
            <p>There is no links to show</p>
        @endforelse

        {{ $links->links() }}

    </div>
</x-app-layout>