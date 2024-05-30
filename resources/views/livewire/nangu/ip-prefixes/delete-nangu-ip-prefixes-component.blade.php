<div>
    <button class="btn btn-circle btn-sm mt-7 ml-3 bg-transparent border-none" wire:click="destroy({{ $prefix->id }})"
        wire:confirm="Opravdu odebrat prefix?">
        <x-icon name="s-trash" class="w-4 h-4 text-red-500" />
    </button>
</div>
