@php
    $version = \Composer\InstalledVersions::getVersion("swisnl/filament-backgrounds");
@endphp
@once
    @push('styles')
        <link href='{{ asset("css/swisnl/filament-backgrounds/filament-backgrounds-styles.css?v=$version") }}' rel='stylesheet' data-navigate-track>
        <style>
            :root {
                --filament-backgrounds-image: url('{{ asset('images/swisnl/filament-backgrounds/curated-by-swis/26.jpg') }}');
            }
        </style>
    @endpush
@endonce
<x-filament-panels::page.simple>
    {{ $this->table }}
</x-filament-panels::page.simple>
