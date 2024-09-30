@php
    $channelPackages = [];

    if ($this->createForm->nangu_isp_id != '') {
        $nanguIsp = App\Models\NanguIsp::find($this->createForm->nangu_isp_id);

        // getting channel packages belongs to isp from wsl nangu
        $nanguResponse = (new App\Services\Api\NanguTv\ChannelPackagesService())->get_channel_packages(
            $nanguIsp->nangu_isp_id
        );
        if (array_key_exists('channelPackageCodes', $nanguResponse)) {
            foreach ($nanguResponse['channelPackageCodes'] as $package) {
                $channelPackages[] = [
                    'id' => $package,
                    'name' => $package,
                ];
            }
        }
    }

    if ($this->updateForm->nangu_isp_id != '') {
        $nanguIsp = App\Models\NanguIsp::find($this->updateForm->nangu_isp_id);

        // getting channel packages belongs to isp from wsl nangu
        $nanguResponse = (new App\Services\Api\NanguTv\ChannelPackagesService())->get_channel_packages(
            $nanguIsp->nangu_isp_id,
        );
        foreach ($nanguResponse['channelPackageCodes'] as $package) {
            $channelPackages[] = [
                'id' => $package,
                'name' => $package,
            ];
        }
    }
@endphp
<div>
    <x-share.cards.base-card title="">
        <div class="flex justify-between">
            <div class="w-96">
                {{-- <x-input placeholder="Vyhledejte ..." wire:model.live="query"
                    class="!bg-[#0F151F] input-md placeholder:text-gray-600" icon="o-magnifying-glass" autofocus /> --}}
            </div>
            <div class="w-64">
                <x-button
                    class="bg-cyan-700 shadow-md border-none hover:bg-cyan-500 hover:shadow-cyan-500/50 text-white/80 btn-sm"
                    wire:click="openCreateModal">
                    + Nová vazba na štítek
                </x-button>
            </div>
        </div>
        <div>
            <x-table :headers="$headers" :rows="$nanguIspTagToChannelPackages" with-pagination>
                @scope('cell_tag.name', $nanguIspTagToChannelPackage)
                    <div
                        class="text-xs inline-flex items-center font-semibold leading-sm px-3 py-1 {{ $nanguIspTagToChannelPackage->tag->color }} text-neutral-200 rounded-md w-18 h-6">
                        <div class="inline-flex">
                            <div>
                                {{ $nanguIspTagToChannelPackage->tag->name }}
                            </div>
                        </div>
                    </div>
                @endscope
                @scope('cell_actions', $nanguIspTagToChannelPackage)
                    <div class="flex mx-auto gap-4">
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="edit({{ $nanguIspTagToChannelPackage->id }})">
                            <x-heroicon-o-pencil class="w-4 h-4 text-green-500" />
                        </button>
                        <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                            wire:click="destroy({{ $nanguIspTagToChannelPackage->id }})"
                            wire:confirm="Opravdu odebrat vazbu?">
                            <x-heroicon-o-trash class="w-4 h-4 text-red-500" />
                        </button>
                    </div>
                @endscope
            </x-table>
        </div>
    </x-share.cards.base-card>

    {{-- create modal --}}
    <x-modal wire:model="createModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="create">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Poskytovatel" wire:model="createForm.nangu_isp_id" :options="$nanguIsps"
                        single searchable />
                    <div>
                        @error('nangu_isp_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Štítek" wire:model="createForm.tag_id" :options="$tags" single
                        searchable />
                    <div>
                        @error('tag_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Programový balíček" wire:model="createForm.channelPackageName"
                        :options="$channelPackages" single searchable />
                    <div>
                        @error('channelPackageName')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="editModal" persistent class="modal-bottom sm:modal-middle fixed">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Poskytovatel" wire:model="updateForm.nangu_isp_id" :options="$nanguIsps"
                        single searchable />
                    <div>
                        @error('nangu_isp_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Štítek" wire:model="updateForm.tag_id" :options="$tags" single
                        searchable />
                    <div>
                        @error('tag_id')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 mb-4">
                    <x-choices-offline label="Programový balíček" wire:model="updateForm.channelPackageName"
                        :options="$channelPackages" single searchable />
                    <div>
                        @error('channelPackageName')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- action section --}}
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Upravit"
                        class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full sm:w-28"
                        type="submit" spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
