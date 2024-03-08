<div>
    <button class='btn bg-[#082f49] btn-sm border-none' wire:click="openModal()">
        <x-heroicon-o-plus-circle class="w-5 h-5" />
        Přidat šablonu zařízení
    </button>

    <x-drawer wire:model="storeDrawer" right class="lg:w-2/3 !bg-[#0c111b]">
        @if (!$availableTemplates->isEmpty())
            <x-form wire:submit="storePrebuildTemplateToDevice">
                <x-choices label="Dostupné šablony" wire:model="templateId" :options="$availableTemplates" single />
                {{-- action section --}}
                <div class="flex justify-between">
                    <div>
                        {{--  --}}
                    </div>
                    <div>
                        <x-button label="Přidat"
                            class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28" type="submit"
                            spinner="save2" />
                    </div>
                </div>
            </x-form>
        @endif
        @if (!$device->vendor->hasSnmp->isEmpty())
            <div class="grid grid-cols-12 mt-3">
                <div class="col-span-12 mb-4">
                    <x-share.alerts.info
                        title="Zařízení má dostupná OID, informace se ukážou přímo v šabloně"></x-share.alerts.info>
                </div>
            </div>
        @endif
        <div class="grid grid-cols-12 mt-12 bg-[#0F2138] rounded-sm">
            <div class="col-span-12 mb-4">
                <div class="mx-4 mt-4">
                    @if ($numberOfInInterfaces != 0 || $numberOfOutInterfaces != 0 || $numberOfModules != 0)
                        @if ($numberOfInInterfaces != 0)
                            <p class="font-semibold mb-4">
                                Vstupní interfacy
                            </p>
                            <div class="grid grid-cols-12 gap-4 ">

                                @for ($i = 1; $i <= $numberOfInInterfaces; $i++)
                                    <div class="col-span-3 mb-4">
                                        <div
                                            class="bg-[#131B2F] rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm shadow-md shadow-slate-900/50">
                                            <div class="card-body text-gray-200 text-sm">
                                                <div class="grid grid-cols-12 mb-4">
                                                    <div class="col-span-12">
                                                        <p>
                                                            Interface: {{ $inInterfaceName }} {{ $i }}
                                                        </p>
                                                    </div>
                                                    @if (!$device->vendor->hasSnmp->isEmpty())
                                                        <div
                                                            class="col-span-12 border-r-2 border-l-2 border-t-2 border-b-2 border-slate-800 font-thin text-sm italic text-center mt-4">
                                                            <span class="my-2 mx-2">
                                                                SNMP Informace
                                                            </span>
                                                        </div>
                                                    @endIf
                                                    @if ($hasInInterfaceFrequency == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Frekvence: %frequency%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceDvb == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                DVB: %dvb%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceSatelite == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Satelit: %satelite%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfacepolarization == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Polarizace: %polarization%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfacepolarizationVoltage == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Polarizace ( V ): %polarizationVolatage%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceSymbolRate == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Symbol rate: %symbolRate%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceFec == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                FEC: %fec%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceLnb == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                LNB: %lnb%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceLnb22 == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                LNB22Kv: %lnb22%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasIntinterfaceSatCard == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Satelitní karta: %satCard%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceParabolaDiameter == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Průměr paraboly: %diameter%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasInInterfaceSatelit == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Satelit: %satelit%
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor

                            </div>
                        @endif

                        @if ($numberOfOutInterfaces != 0)
                            <p class="font-semibold mb-4">
                                Výstupní interfacy
                            </p>
                            <div class="grid grid-cols-12 gap-4 ">
                                @for ($i = 1; $i <= $numberOfOutInterfaces; $i++)
                                    <div class="col-span-3 mb-4">
                                        <div
                                            class="bg-[#131B2F] rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm shadow-md shadow-slate-900/50">
                                            <div class="card-body text-gray-200 text-sm">
                                                <div class="grid grid-cols-12 mb-4">
                                                    <div class="col-span-12">
                                                        <p>
                                                            Interface: {{ $outInterfaceName }} {{ $i }}
                                                        </p>
                                                    </div>
                                                    @if (!$device->vendor->hasSnmp->isEmpty())
                                                        <div
                                                            class="col-span-12 border-r-2 border-l-2 border-t-2 border-b-2 border-slate-800 font-thin text-sm italic text-center mt-4">
                                                            <span class="my-2 mx-2">
                                                                SNMP Informace
                                                            </span>
                                                        </div>
                                                    @endIf
                                                    @if ($hasOutInterfaceSatCard == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Satelitní karta: %satCard%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasOutInterfaceInInterface == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Vstupní interface: %OutInterfaceInInterface%
                                                            </p>
                                                        </div>
                                                    @endif
                                                    @if ($hasOutInterfaceLnb == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                LNB typ: %lnbType%
                                                            </p>
                                                        </div>
                                                        <div class="col-span-12 mt-4">
                                                            <div class="grid grid-cols-12 gap-4">
                                                                <div class="col-span-12">
                                                                    <p>
                                                                        Vertical low: %vl%
                                                                    </p>
                                                                </div>
                                                                <div class="col-span-12">
                                                                    <p>
                                                                        Vertical high: %vh%
                                                                    </p>
                                                                </div>
                                                                <div class="col-span-12">
                                                                    <p>
                                                                        Horizontal low: %hl%
                                                                    </p>
                                                                </div>
                                                                <div class="col-span-12 ">
                                                                    <p>
                                                                        Horizontal high: %hh%
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($hasOutInterfacefaceSatelit == true)
                                                        <div class="col-span-12 mt-4">
                                                            <p>
                                                                Satelit: %hasOutInterfacefaceSatelit%
                                                            </p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        @endif

                        @if ($numberOfModules != 0)
                            <p class="font-semibold mb-4">
                                Moduly
                            </p>
                            <div class="grid grid-cols-12 gap-4 ">
                                @for ($i = 1; $i <= $numberOfModules; $i++)
                                    <div class="col-span-3 mb-4">
                                        <div
                                            class="bg-[#131B2F] rounded-lg bg-clip-padding backdrop-filter backdrop-blur-sm shadow-md shadow-slate-900/50">
                                            <div class="card-body text-gray-200 text-sm">
                                                <div class="grid grid-cols-12 mb-4">
                                                    <div class="col-span-12">
                                                        <p>
                                                            Interface: {{ $moduleName }} {{ $i }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        @endif
                    @else
                        <p class="italic text-center">
                            zde se vám ukáže šablona
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 mt-6">
            <div class="col-span-12 mb-4">
                <x-form wire:submit="store">
                    <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                        wire:click='closeDialog'>✕</x-button>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-4 mb-4">
                            {{-- inputs --}}
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 mb-4">
                                    <x-input label="Počet vstupních interfaců" wire:model.live="numberOfInInterfaces"
                                        type="number" />
                                    <div>
                                        @error('form.numberOfInInterfaces')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- input name --}}
                                <div class="col-span-12 mb-4">
                                    <x-input label="Název vstupního interfacu" wire:model.live="inInterfaceName" />
                                    <div>
                                        @error('form.inInterfaceName')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- has input frequency --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceFrequency" label="Má frekvency?" />
                                    <div>
                                        @error('form.hasInInterfaceFrequency')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- has input dvb --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceDvb" label="Má DVB?" />
                                    <div>
                                        @error('form.hasInInterfaceDvb')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- has input satelite --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceSatelite" label="Má satelity?" />
                                    <div>
                                        @error('form.hasInInterfaceSatelite')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- has input hasInInterfacepolarization --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfacepolarization" label="Má polatizaci?" />
                                    <div>
                                        @error('form.hasInInterfacepolarization')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfacepolarizationVoltage"
                                        label="Má polatizaci ( voltáž )?" />
                                    <div>
                                        @error('form.hasInInterfacepolarizationVoltage')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- hasInInterfaceSymbolRate --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceSymbolRate" label="Má symbol rate?" />
                                    <div>
                                        @error('form.hasInInterfaceSymbolRate')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- hasInInterfaceFec --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceFec" label="Má fec?" />
                                    <div>
                                        @error('form.hasInInterfaceFec')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- hasInInterfaceLnb --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceLnb" label="Má LNB?" />
                                    <div>
                                        @error('form.hasInInterfaceLnb')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- hasInInterfaceLnb22 --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceLnb22" label="Má LNB22kv?" />
                                    <div>
                                        @error('form.hasInInterfaceLnb22')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- sat card --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasIntinterfaceSatCard"
                                        label="Má satelitní kartu?" />
                                    <div>
                                        @error('form.hasIntinterfaceSatCard')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- has parabola diameter - průměr --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceParabolaDiameter"
                                        label="Průměr paraboly?" />
                                    <div>
                                        @error('form.hasInInterfaceParabolaDiameter')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- has satelit --}}
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasInInterfaceSatelit" label="Vazba na satelit?" />
                                    <div>
                                        @error('form.hasInInterfaceSatelit')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-4 mb-4">
                            {{-- outputs --}}
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 mb-4">
                                    <x-input label="Počet výstupních interfaců"
                                        wire:model.live="numberOfOutInterfaces" type="number" />
                                    <div>
                                        @error('form.numberOfOutInterfaces')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-12 mb-4">
                                    <x-input label="Název výstupního interfacu" wire:model.live="outInterfaceName" />
                                    <div>
                                        @error('form.outInterfaceName')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasOutInterfaceSatCard"
                                        label="Má satelitní kartu?" />
                                    <div>
                                        @error('form.hasOutInterfaceSatCard')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasOutInterfaceInInterface"
                                        label="Má vazbu na vstupní interface?" />
                                    <div>
                                        @error('form.hasOutInterfaceInInterface')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasOutInterfaceLnb" label="Má LNB?" />
                                    <div>
                                        @error('form.hasOutInterfaceLnb')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-6 mb-4">
                                    <x-checkbox wire:model.live="hasOutInterfacefaceSatelit" label="Vazba na satelit?" />
                                    <div>
                                        @error('form.hasOutInterfacefaceSatelit')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-4 mb-4">
                            {{-- modules --}}
                            <div class="grid grid-cols-12 gap-4">
                                <div class="col-span-12 mb-4">
                                    <x-input label="Počet modulů" wire:model.live="numberOfModules" type="number" />
                                    <div>
                                        @error('form.numberOfModules')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-span-12 mb-4">
                                    <x-input label="Název modulu" wire:model.live="moduleName" />
                                    <div>
                                        @error('form.moduleName')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
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
                                class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full sm:w-28"
                                type="submit" spinner="save2" />
                        </div>
                    </div>
                </x-form>
            </div>
        </div>
    </x-drawer>
</div>
