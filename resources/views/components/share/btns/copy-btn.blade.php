<div class="-mt-1" x-data="{ copiedData: '', copied: false }" x-init="copiedData = '{{ $dataToCopy }}'">
    <x-button class="btn-sm bg-transparent hover:bg-slate-800/30 border-none tooltip shadow-none" data-tip="kopírovat"
        @click="navigator.clipboard.writeText(copiedData); copied = true; setTimeout(() => copied = false, 2000)">
        <x-heroicon-o-check-circle x-show="copied" class="w-4" />
        <x-heroicon-o-square-2-stack x-show="!copied" class="w-4" />
    </x-button>
</div>
