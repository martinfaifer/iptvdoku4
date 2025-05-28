<div>
    <x-share.cards.base-card title="Kontakty">
        <div class="h-44">
            <div>
                <button
                    class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-green-500"
                    @click='$wire.openStoreModal()'>
                    <x-heroicon-o-plus-circle class="w-4 h-4" />
                </button>
            </div>
            <div
                class="flex flex-col gap-4 sm:grid sm:grid-cols-12 font-semibold dark:text-[#A3ABB8] max-h-44 overflow-y-scroll">
                @if ($this->getContacts()->isEmpty())
                    <div class="col-span-12">
                        <x-share.alerts.info title="Není nadefinován žádný kontakt"></x-share.alerts.info>
                    </div>
                @else
                    @foreach ($this->getContacts() as $contact)
                        <div class="col-span-12 dark:bg-[#2A323C]/20 border-[1px] border-slate-200 dark:border-none rounded-md">
                            <div class="flex flex-row-reverse">
                                <button
                                    class="btn btn-circle btn-outline btn-xs border-none bg-transparent text-red-500"
                                    wire:click='destroy({{ $contact->id }})' wire:confirm='Opravdu chcete odebrat kontakt?'>
                                    <x-heroicon-s-trash class="w-3 h-3" />
                                </button>
                                <button
                                    class="btn btn-circle btn-outline btn-xs border-none bg-transparent text-blue-500"
                                    wire:click='edit({{ $contact->id }})'>
                                    <x-heroicon-o-pencil class="w-3 h-3" />
                                </button>
                            </div>
                            <div class="grid grid-cols-12 gap-2 my-2 mx-2">
                                <div class="col-span-12">
                                    <div class="inline-flex">
                                        <x-heroicon-o-user class="w-4 h-4" />
                                        <span class="ml-2">
                                            Osoba:
                                        </span>
                                        <span class="ml-4">
                                            {{ $contact['full_name'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="inline-flex">
                                        <x-heroicon-o-envelope class="w-4 h-4" />
                                        <span class="ml-2">
                                            email:
                                        </span>
                                        <span class="ml-4">
                                            <a class="text-blue-500 hover:underline"
                                                href="mailto:{{ $contact['email'] }}">
                                                {{ $contact['email'] }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-span-12">
                                    <div class="inline-flex">
                                        <x-heroicon-o-phone class="w-4 h-4" />
                                        <span class="ml-2">
                                            telefon:
                                        </span>
                                        <span class="ml-4">
                                            <a class="text-blue-500 hover:underline"
                                                href="tel:+420{{ $contact['phone'] }}">
                                                {{ $contact['phone'] }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </x-share.cards.base-card>

    <x-modal wire:model="storeModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Osoba" wire:model="contactForm.full_name" />
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="Email" wire:model="contactForm.email" />
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="Telefon" wire:model="contactForm.phone" />
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat" class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="create" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="updateModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                @click='$wire.closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-input label="Osoba" wire:model="updateForm.full_name" />
                    <div>
                        @error('full_name')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="Email" wire:model="updateForm.email" />
                    <div>
                        @error('email')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 mb-4">
                    <x-input label="Telefon" wire:model="updateForm.phone" />
                    <div>
                        @error('phone')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        @click='$wire.closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit" class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="update" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
