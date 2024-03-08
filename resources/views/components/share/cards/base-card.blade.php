<div>
    {{-- #1E263B --}}
    {{-- bg-[#111827] --}}
    {{-- bg-gradient-to-r from-[#162131]/80 to-[#0e151f]/80 --}}
    <div class="bg-gradient-to-b from-[#111827]/50 to-transparent rounded-lg bg-clip-padding backdrop-blur-lg">
        <div class="pt-2">
            <p class="text-center text-sm font-semibold">
                {{ $title }}
            </p>
        </div>
        <div class="card-body text-gray-200 text-sm">
            {{ $slot }}
        </div>
    </div>
</div>
