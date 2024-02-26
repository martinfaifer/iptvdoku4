<div>
    <x-share.cards.base-card title="{{ $device->category->name }}">
        <div>
            <button
                class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-8 text-green-500"
                wire:click='openUpdateModal()'>
                <x-heroicon-o-pencil class="w-4 h-4" />
            </button>
            <button class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-red-500"
                wire:click='delete()' wire:confirm='Opravdu odebrat vazbu?'>
                <x-heroicon-o-trash class="w-4 h-4" />
            </button>
        </div>
        <div class="flex flex-col gap-4 sm:grid sm:grid-cols-12 font-semibold">
            <div class="flex justify-between sm:col-span-6">
                <div>
                    <span>
                        Zařízení:
                        <span class="ml-4 font-normal">
                            {{ $device->name }}
                        </span>
                </div>
            </div>
            @if (!is_null($device->ip))
                <div class="flex justify-between sm:col-span-6">
                    <div>
                        <span>
                            IP:
                        </span>
                        <span class="ml-4 font-normal">
                            {{ $device->ip }}
                        </span>
                    </div>
                </div>
            @endif

            <div class="flex justify-between sm:col-span-6">
                <div>
                    <span>
                        Status:
                    </span>
                    <span class="ml-4 font-normal">
                        ???
                    </span>
                </div>
            </div>
            <div class="flex justify-between sm:col-span-12">
                <div>
                    <span>
                        Přístupy do zařízeni:
                    </span>
                    <span class="ml-4 font-normal">
                        {{ $device->username }} {{ $device->password }}
                    </span>
                </div>
            </div>
            @if (!is_null($device->template))
                <div class="flex justify-between sm:col-span-12">
                    <div>
                        <span>
                            Vazba na port(y):
                        </span>
                        <span class="ml-4 font-normal">
                            @foreach ($device->template as $inputType => $template)
                                @foreach ($device->template[$inputType] as $interface)
                                    @if (array_key_exists('Vazba na kanály', $interface))
                                        @if (in_array($searcheableChannelName, $interface['Vazba na kanály']))
                                            {{ $interface['Název'] }}
                                        @endif
                                    @endif
                                @endforeach
                            @endforeach
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </x-share.cards.base-card>

    {{-- update modal --}}
    <x-modal wire:model="updateModal" title="Úprava kanálu na zařízení" persistent
        class="modal-bottom sm:modal-middle ">
        <x-form wire:submit="update">
            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                {{-- šablona zařízení --}}
                <div class="col-span-12 mb-4">
                    @if (!is_null($device->template))
                        <div class="col-span-12 mb-0">
                            @foreach ($device->template as $interfaceType => $interfacesData)
                                @if ($interfaceType == 'inputs')
                                    <p class="font-semibold text-center mb-4">
                                        Vstupy
                                    </p>
                                    <div class="grid grid-cols-12 gap-4">
                                        @foreach ($interfacesData as $interfaceKey => $interface)
                                            {{-- clickable --}}
                                            <div class="col-span-3 mb-4">
                                                <div @class([
                                                    'rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm shadow-md shadow-slate-900/50',
                                                    'bg-[#082F49]' => $selectedInput != $interfaceKey,
                                                    'bg-sky-800' => $selectedInput == $interfaceKey,
                                                ])>
                                                    <div class="card-body text-gray-200 text-sm cursor-pointer"
                                                        wire:click='bindInput("{{ $interfaceKey }}")'>
                                                        <div class="grid grid-cols-12 mb-4">
                                                            @foreach ($interface as $interfaceValueName => $interfaceValue)
                                                                @if (is_string($interfaceValue))
                                                                    @if ($interfaceValueName == 'Název')
                                                                        <div
                                                                            class="col-span-12 my-4 flex justify-between">
                                                                            <div class="font-semibold">
                                                                                {{ $interfaceValueName }} :
                                                                            </div>
                                                                            <div class="font-semibold">
                                                                                {{ $interfaceValue }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                @if ($interfaceType == 'outputs')
                                    <p class="font-semibold text-center mb-4">
                                        Výstupy
                                    </p>
                                    <div class="grid grid-cols-12 gap-4 ">
                                        @foreach ($interfacesData as $interfaceKey => $interface)
                                            <div class="col-span-3 mb-4">
                                                <div @class([
                                                    'rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm shadow-md shadow-slate-900/50',
                                                    'bg-[#082F49]' => $selectedOutput != $interfaceKey,
                                                    'bg-sky-800' => $selectedOutput == $interfaceKey,
                                                ])>
                                                    <div class="card-body text-gray-200 text-sm cursor-pointer"
                                                        wire:click='bindOutput("{{ $interfaceKey }}")'>
                                                        <div class="grid grid-cols-12 mb-4">
                                                            @foreach ($interface as $interfaceValueName => $interfaceValue)
                                                                @if (is_string($interfaceValue))
                                                                    @if ($interfaceValueName == 'Název')
                                                                        <div
                                                                            class="col-span-12 my-4 flex justify-between">
                                                                            <div class="font-semibold">
                                                                                {{ $interfaceValueName }} :
                                                                            </div>
                                                                            <div class="font-semibold">
                                                                                {{ $interfaceValue }}
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
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
                        class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28" type="submit"
                        spinner="save2" />
                </div>
            </div>
        </x-form>
    </x-modal>
    {{-- end of update modal --}}
</div>
