<div class=" overflow-hidden">
    <div class="flex flex-col">
        {{-- create new channel --}}
        <div class="relative">
            <div class="absolute left">
                <livewire:iptv.devices.store-device-component>
            </div>
        </div>
        {{-- show alert about no channel found --}}
        @if (is_null($device) || is_null($device->name))
            <div class="mt-12">
                <x-share.alerts.info title="Vyberte zařízení z menu vlevo" />
            </div>
        @else
            {{-- tags --}}
            <div>
                <livewire:tag-component type="device" itemId="{{ $device->id }}" lazy />
            </div>
            <div class="grid grid-cols-12 mt-8">
                <div class="col-span-12 flex">
                    <h1 class="text-2xl dark:text-white/80 subpixel-antialiased font-bold mt-6 ">
                        {{ $device->name }}
                    </h1>

                    @if (isset($nmsCahedData[0]['nms_device_status_id']['nms_device_status_type_id']) &&
                            $nmsCahedData[0]['nms_device_status_id']['nms_device_status_type_id'] == 1)
                        <div class="bg-[#1EB15B] text-white text-sm font-semibold my-auto ml-6 mt-8 rounded-md">
                            <span class="mx-3">
                                Online
                            </span>
                        </div>
                    @endif
                    @if (isset($nmsCahedData[0]['nms_device_status_id']['nms_device_status_type_id']) &&
                            $nmsCahedData[0]['nms_device_status_id']['nms_device_status_type_id'] == 3)
                        <div class="bg-red-500 text-white text-sm font-semibold my-auto ml-6 mt-8 rounded-md">
                            <span class="mx-3">
                                Offline
                            </span>
                        </div>
                    @endif

                    {{-- actions --}}
                    <livewire:iptv.devices.update-device-component :device="$device" lazy />
                    <livewire:iptv.devices.delete-device-component :device="$device" lazy />
                    {{-- end of actions --}}
                </div>
            </div>
            <hr
                class="w-full h-[1px] dark:h-1 mt-2 mx-auto my-1 bg-slate-800/5 dark:bg-gradient-to-r dark:from-sky-950 dark:via-blue-850 dark:to-sky-950 border-0 rounded">
            <div class="mt-4">
                <div class="grid grid-cols-12 gap-4">
                    @if (!is_null($device->template))
                        <div class="col-span-12 mb-4">
                            <livewire:iptv.devices.device-template-component :device="$device" :template="$device->template" lazy />
                        </div>
                    @else
                        {{-- device has not template but if has oids can we show dialog for create one --}}
                        <div class="col-span-12 mb-4">
                            <div class="navbar bg-transparent">
                                <div class="flex-1">
                                    <livewire:iptv.devices.create-device-template-component class="my-4"
                                        :device="$device" lazy />
                                </div>
                                <div class="flex-none">
                                </div>
                            </div>
                        </div>
                    @endif
                    <div @class([
                        'col-span-12 mb-4',
                        'xl:col-span-12' => blank($nmsCahedData),
                        'xl:col-span-8' => !blank($nmsCahedData),
                    ])>
                        <x-share.cards.base-card title="Informace o zařízení">
                            {{-- ip and login block --}}
                            <div class="grid grid-cols-12 font-semibold dark:text-[#A3ABB8]">
                                @if (!blank($device->ip))
                                    <div class="col-span-12 xl:col-span-4 flex">
                                        <p>
                                            <span class="font-normal">
                                                IP:
                                            </span>
                                            <span class="ml-3">
                                                <a href="{{ str_contains($device->ip, 'http') ? $device->ip : 'http://' . $device->ip }}"
                                                    target="_blank" class="text-blue-500 hover:underline">
                                                    {{ $device->ip }}
                                                </a>
                                            </span>
                                        </p>
                                        <x-share.btns.copy-btn dataToCopy="{{ $device->ip }}" />
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                                @if (!blank($device->ipmi_ip) && !blank($device->ipmi_ip))
                                    <div class="col-span-12 xl:col-span-4 flex">
                                        <p>
                                            <span class="font-normal">
                                                IPMI:
                                            </span>
                                            <span class="ml-3">
                                                <a href="{{ str_contains($device->ipmi_ip, 'http') ? $device->ipmi_ip : 'http://' . $device->ipmi_ip }} "
                                                    target="_blank" class="text-blue-500 hover:underline">
                                                    {{ $device->ipmi_ip }}
                                                </a>
                                            </span>
                                        </p>
                                        <x-share.btns.copy-btn dataToCopy="{{ $device->ipmi_ip }}" />
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                                @if (!blank($device->controller_ip))
                                    <div class="col-span-12 xl:col-span-4 flex">
                                        <p>
                                            <span class="font-normal">
                                                URL kontroleru:
                                            </span>
                                            <span class="ml-3">
                                                <a href="{{ str_contains($device->controller_ip, 'http') ? $device->controller_ip : 'http://' . $device->controller_ip }}"
                                                    target="_blank" class="text-blue-500 hover:underline">
                                                    {{ $device->controller_ip }}
                                                </a>
                                            </span>
                                        </p>
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                                @if (!blank($device->username) || !blank($device->password))
                                    <div class="col-span-12 xl:col-span-4 flex">
                                        <p>
                                            <span class="font-normal">
                                                Přístupy:
                                            </span>
                                            <span class="ml-3">
                                                {{ $device->username }} / {{ $device->password }}
                                            </span>
                                        </p>
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                            </div>

                            {{-- informations about device --}}
                            <div class="grid md:grid-cols-12 font-semibold dark:text-[#A3ABB8] mt-1">
                                <div class="col-span-12 xl:col-span-4">
                                    <p>
                                        <span class="font-normal">
                                            Kategorie:
                                        </span>
                                        <span class="ml-3">
                                            {{ $device->category->name }}
                                        </span>
                                    </p>
                                    <hr
                                        class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                </div>
                                <div class="col-span-12 xl:col-span-4 ">
                                    <p>
                                        <span class="font-normal">
                                            Výrobce:
                                        </span>
                                        <span class="ml-3">
                                            {{ $device->vendor->name }}
                                        </span>
                                    </p>
                                    <hr
                                        class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                </div>
                            </div>
                            {{-- snmp block --}}
                            <div class="grid md:grid-cols-12 font-semibold dark:text-[#A3ABB8] mt-1">
                                @if ($device->is_snmp == true)
                                    <div class="col-span-12 xl:col-span-12">
                                    </div>
                                    <div class="col-span-12 xl:col-span-3">
                                        <p>
                                            <span class="font-normal">
                                                SNMP:
                                            </span>
                                            <span class="ml-3">
                                                @if ($device->is_snmp == true)
                                                    <x-icon name="o-check" class="text-green-500 w-4 h-4" />
                                                @else
                                                    <x-icon name="o-x-mark" class="text-red-500 w-4 h-4" />
                                                @endif
                                            </span>
                                        </p>
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                                @if (!blank($device->snmp_version))
                                    <div class="col-span-12 xl:col-span-4">
                                        <p>
                                            <span class="font-normal">
                                                SNMP verze:
                                            </span>
                                            <span class="ml-3">
                                                {{ $device->snmp_version }}
                                            </span>
                                        </p>
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                                @if (!blank($device->snmp_private_comunity))
                                    <div class="col-span-12 xl:col-span-4">
                                        <p>
                                            <span class="font-normal">
                                                SNMP private komunita:
                                            </span>
                                            <span class="ml-3">
                                                {{ $device->snmp_private_comunity }}
                                            </span>
                                        </p>
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                                @if (!blank($device->snmp_public_comunity))
                                    <div class="col-span-12 xl:col-span-4">
                                        <p>
                                            <span class="font-normal">
                                                SNMP public komunita:
                                            </span>
                                            <span class="ml-3">
                                                {{ $device->snmp_public_comunity }}
                                            </span>
                                        </p>
                                        <hr
                                            class="xl:hidden w-full h-[1px] mt-2 mb-2 mx-auto bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
                                    </div>
                                @endif
                            </div>
                        </x-share.cards.base-card>
                    </div>
                    @if (!blank($nmsCahedData) && !blank($nmsCahedData))
                        <div class="col-span-12 xl:col-span-4 mb-4">
                            <x-share.cards.base-card title="Informace o zařízení z NMS">
                                <div class="grid grid-cols-12 gap-4 font-semibold dark:text-[#A3ABB8]">
                                    <div class="col-span-12">
                                        <span class="font-normal">
                                            Název v NMS:
                                        </span>
                                        <span class="ml-3">
                                            <a href="https://nms.grapesc.cz/nms/dashboard/?type=device&typeId={{ $nmsCahedData[0]['id'] }}"
                                                target="_blank" class="text-blue-500 hover:underline">
                                                {{ $nmsCahedData[0]['identificator'] }}
                                            </a>
                                        </span>
                                    </div>
                                    <div class="col-span-12">
                                        <span class="font-normal">
                                            SN:
                                        </span>
                                        <span class="ml-3">
                                            {{ $nmsCahedData[0]['m_deviceregister_device_id']['serial_number'] }}
                                        </span>
                                    </div>
                                    <div class="col-span-12">
                                        <span class="font-normal">
                                            POP:
                                        </span>
                                        <span class="ml-3">
                                            {{ $nmsCahedData[0]['m_deviceregister_device_id']['owner_name'] }}
                                        </span>
                                    </div>
                                </div>
                            </x-share.cards.base-card>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-12 gap-4">
                    {{-- device ssh --}}
                    <div class="col-span-12 xl:col-span-4 mb-4">
                        <livewire:iptv.devices.device-ssh-component :device="$device" lazy />
                    </div>

                    {{-- device alerts component --}}
                    <div class="col-span-12 xl:col-span-4 mb-4">
                        <livewire:iptv.devices.device-alert-component :device="$device" lazy />
                    </div>

                    @if ($device->category->name == 'Satelity')
                        <div class="col-span-12  xl:col-span-4 mb-4">
                            <livewire:iptv.devices.setelit-has-devices-component :device="$device" lazy />
                        </div>
                    @endif
                </div>

                {{-- nimble api cached result --}}
                @if (!blank($nimbleCachedData))
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 xl:col-span-12 mb-4">
                            <livewire:iptv.devices.nimble-api-component :device="$device" lazy />
                        </div>
                    </div>
                @endif

                @if (!blank($grapeTranscoderData))
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 xl:col-span-12 mb-4">
                            <livewire:iptv.devices.grape-transcoders-api-component :device="$device" lazy />
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-12 gap-4">
                    {{-- logs --}}
                    <div class="col-span-12 xl:col-span-4 mb-4">
                        <livewire:log-component columnValue="device:{{ $device->id }}" column="item" lazy />
                    </div>
                    {{-- contacts --}}
                    <div class="col-span-12 xl:col-span-4">
                        <livewire:contact-component type="device" :item_id="$device->id" lazy />
                    </div>
                    {{-- poznámky --}}
                    <div class="col-span-12 xl:col-span-4 mb-4">
                        <livewire:notes.note-component column="device_id" :id="$device->id" lazy />
                    </div>

                    {{-- vazba na kanály --}}
                    <div class="col-span-12 xl:col-span-12 mb-4 ">
                        <livewire:iptv.devices.device-channels-component :device="$device" lazy>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @script
        <script>
            document.addEventListener('livewire:navigated', () => {
                globalThis.scrollTo({
                    top: 0,
                    left: 0,
                    behavior: "smooth"
                });

            });
        </script>
    @endscript
</div>
