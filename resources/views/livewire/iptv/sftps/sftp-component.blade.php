<div>
    <div class="flex flex-col">
        <div class="relative">
            <div class="absolute left">
                @can('create', App\Models\SftpServer::class)
                    <livewire:iptv.sftps.create-sftp-server-component />
                @endcan
            </div>
        </div>
        {{-- show alert about no sat card found --}}
        @if (is_null($sftpServer) || is_null($sftpServer->name))
            <div class="mt-12">
                <x-share.alerts.info title="Vyberte server z menu vlevo"></x-share.alerts.info>
            </div>
        @else
            <div class="grid grid-cols-12 mt-8">
                @if (empty($sftpServerContent))
                    <div class="col-span-12 mt-4">
                        <x-alert title="Nepodařilo se připojit k serveru" icon="o-exclamation-triangle"
                            class="bg-amber-600 !text-white/80 mb-4" />
                    </div>
                @endif
                <div class="col-span-12 flex">
                    <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                        {{ $sftpServer->name }}
                    </h1>
                    {{-- actions --}}
                    @can('update', $sftpServer)
                        <livewire:iptv.sftps.update-sftp-server-component :sftpServer="$sftpServer" />
                    @endcan

                    @can('delete', $sftpServer)
                        <livewire:iptv.sftps.delete-sftp-server-component :sftpServer="$sftpServer" />
                    @endcan
                    {{-- end of actions --}}
                </div>
            </div>
            <hr
                class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
            <div class="mt-4">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <x-share.cards.base-card title="Informace o serveru">
                            <div class="flex flex-col gap-4 md:grid md:grid-cols-12 font-semibold text-[#A3ABB8]">
                                <div class="flex justify-between md:col-span-4 md:inline-flex">
                                    <p>
                                        <span class="font-normal">
                                            Url:
                                        </span>
                                        <span class="ml-3">
                                            {{ $sftpServer->url }}
                                        </span>
                                    </p>
                                </div>
                                <div class="flex justify-between md:col-span-4 md:inline-flex">
                                    <p>
                                        <span class="font-normal">
                                            Přístup:
                                        </span>
                                        <span class="ml-3">
                                            {{ $sftpServer->username }} / {{ $sftpServer->password }}
                                        </span>
                                    </p>
                                </div>

                                <div class="flex justify-between md:col-span-4 md:inline-flex">
                                    <p>
                                        <span class="font-normal">
                                            Cílová složka:
                                        </span>
                                        <span class="ml-3">
                                            {{ $sftpServer->path_to_folder }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </x-share.cards.base-card>
                    </div>
                    @if (!empty($sftpServerContent))
                        <div class="col-span-12">
                            <x-share.cards.base-card title="Obsah">
                                <div>
                                    @can('upload', App\Models\SftpServer::class)
                                        <button
                                            class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-green-500"
                                            @click='$wire.openUploadDialog()'>
                                            <x-heroicon-o-arrow-up-tray class="size-4" />
                                        </button>
                                    @endcan
                                </div>
                                <div class=" h-96 overflow-auto">
                                    <div class="grid grid-cols-12 font-semibold text-[#A3ABB8]">
                                        <div class="col-span-12">
                                            <div class="overflow-x-auto">
                                                <table class="table">
                                                    <!-- head -->
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Soubor</th>
                                                            <th>Velikost</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($sftpServerContent as $item)
                                                            <tr>
                                                                <th>
                                                                    <img class="object-contain size-10"
                                                                        src="http://{{ $sftpServer->url }}/{{ $item['filename'] }}"
                                                                        alt="{{ $item['filename'] }}" />
                                                                </th>
                                                                <td>{{ $item['filename'] }}</td>
                                                                <td>{{ $item['size'] }}</td>
                                                                <td>
                                                                    @if ($item['filename'] != '..' && $item['filename'] != '.')
                                                                        <button wire:key='{{ $item['filename'] }}'
                                                                            wire:click="download_file({{ json_encode($item) }})"
                                                                            wire:loading.attr="disabled"
                                                                            class="btn btn-sm btn-circle bg-transparent border-none">
                                                                            <x-heroicon-o-arrow-down-tray
                                                                                class="size-4 text-blue-500" />
                                                                            <div wire:loading
                                                                                wire:target="download_file({{ json_encode($item) }})">
                                                                                <span
                                                                                    class="loading loading-spinner loading-md size-2 text-blue-500"></span>
                                                                            </div>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </x-share.cards.base-card>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-12 gap-4 mt-4">
                    {{-- logs --}}
                    {{-- <div class="col-span-12 md:col-span-4 mb-4">
                        <livewire:log-component columnValue="satelit_card:{{ $satelitCard->id }}" column="item" />
                    </div> --}}
                </div>
            </div>

            <x-modal wire:model.live="uploadDialog" title="Nahrát soubor" persistent
                class="modal-bottom sm:modal-middle fixed">
                <x-form wire:submit="upload_file">
                    <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                        @click='$wire.closeDialog'>✕</x-button>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 mb-4">
                            <input type="file" wire:model.live="uploadForm.file">
                            <div>
                                @error('file')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- action section --}}
                    <div class="flex justify-between">
                        <div>
                            <x-button label="Zavřít" class="bg-[#334155] font-semibold w-full sm:w-28 mb-4"
                                @click='$wire.closeDialog' />
                        </div>
                        <div>
                            <x-button label="Nahrát"
                                class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                                type="submit">
                            </x-button>
                        </div>
                    </div>
                </x-form>
            </x-modal>
        @endif
    </div>
</div>
