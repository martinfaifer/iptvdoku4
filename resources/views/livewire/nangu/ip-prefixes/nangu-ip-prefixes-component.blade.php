<div class=" overflow-hidden">
    <div class="flex flex-col">
        <div class="relative">
            <div class="absolute left">
                <livewire:nangu.ip-prefixes.store-nangu-ip-prefixes-component>
            </div>
        </div>
        {{-- show alert about no channel found --}}
        @if (is_null($prefix) || is_null($prefix->ip_address))
            <div class="mt-12">
                <x-share.alerts.info title="Vyberte prefix z menu vlevo"></x-share.alerts.info>
            </div>
        @else
        <div>
            <livewire:tag-component type="ip" itemId="{{ $prefix->id }}"></livewire:tag-component>
        </div>
            <div class="grid grid-cols-12 mt-8">
                <div class="col-span-12 flex">
                    <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                        {{ $prefix->ip_address }}/{{ $prefix->cidr }}
                    </h1>

                    {{-- actions --}}
                    {{-- <livewire:iptv.devices.update-device-component
                    :device="$prefix"></livewire:iptv.devices.update-device-component> --}}
                <livewire:nangu.ip-prefixes.delete-nangu-ip-prefixes-component
                    :prefix="$prefix"></livewire:nangu.ip-prefixes.delete-nangu-ip-prefixes-component>
                    {{-- end of actions --}}
                </div>
            </div>
            <hr
                class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">

            <div class="mt-4">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <livewire:notes.note-component cardWeight="h-96" chatBubleWeight="h-96" column="ip_id" :id="$prefix->id" lazy />
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
