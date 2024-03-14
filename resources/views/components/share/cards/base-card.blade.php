<div>
    {{-- bg-gradient-to-t from-transparent to-[#091723]/50 border border-slate-800/20 rounded-lg bg-clip-padding backdrop-blur-lg --}}
    {{-- bg-[#111827] --}}
    {{-- bg-gradient-to-r from-[#162131]/80 to-[#0e151f]/80 --}}
    {{-- bg-gradient-to-b from-[#111827]/50 to-transparent --}}

    <div class="bg-gradient-to-b from-slate-950/80 to-black/40 backdrop-blur-xl border-[1px] border-solid border-[#64748b] border-opacity-10 rounded-lg">
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
