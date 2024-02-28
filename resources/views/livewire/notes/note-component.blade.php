<div>
    <x-share.cards.base-card title="Poznámky">
        <div class="h-44">
            <div>
                <button
                    class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-green-500"
                    wire:click='openModal()'>
                    <x-heroicon-o-plus-circle class="w-4 h-4" />
                </button>
            </div>
            @if ($notes->isEmpty())
                <div>
                    <x-share.alerts.info title="Neexistuje žádná poznámka"></x-share.alerts.info>
                </div>
            @else
                <div class="grid grid-cols-12">
                    <div class="col-span-12">
                        <div class="overflow-y-auto h-36">
                            @foreach ($notes as $note)
                                <div class="chat chat-start">
                                    <div class="chat-image avatar">
                                        <div class="w-10 rounded-full">
                                            <div class="avatar placeholder">
                                                <div class="bg-neutral text-neutral-content rounded-full w-10">
                                                    <span class="text-1xl">
                                                        {{ substr(Auth::user()->first_name, 0, 1) }}
                                                        {{ substr(Auth::user()->last_name, 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-header text-xs opacity-50">
                                        {{ $note->user }}
                                        <button wire:click='destroy({{ $note->id }})'
                                            wire:confirm="Opravdu chcete odebrat?"
                                            class="btn btn-circle btn-outline btn-xs border-none bg-transparent text-red-500 -mt-1">
                                            <x-heroicon-c-trash class="w-3 h-3" />
                                        </button>
                                    </div>
                                    <div class="chat-bubble w-full">{{ $note->note }}</div>
                                    <div class="chat-footer opacity-50">
                                        <time class="text-xs opacity-50">{{ $note->created_at }}</time>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-share.cards.base-card>
    <x-modal wire:model="storeModal" title="Nová poznámka" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="store">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-textarea wire:model="storeNoteForm.note" rows="5" inline />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
