<div>
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                Nastavení upozornění
            </h1>
        </div>
    </div>
    <hr class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-none rounded">
    <x-form wire:submit="update" class="mt-6">
        <div class="grid grid-cols-12 gap-4 mt-6">
            <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Při změněně kanálu" wire:model="form.notify_if_channel_change" />
            </div>
            <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Nový článek ve wiki" wire:model="form.notify_if_added_new_wiki_content" />
            </div>
            <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Problém s počasím" wire:model="form.notify_if_weather_problem" />
            </div>
            <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Příliš mnoho nefunkčních kanálů" wire:model="form.notify_if_too_many_channels_down" />
            </div>
            <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Expirace satelitních karet" wire:model="form.notify_if_satelit_card_has_expiration" />
            </div>
            <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Nová událost v kalendáři" wire:model="form.notify_if_added_new_event" />
            </div>
            {{-- <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Nahrán nový banner" wire:model="form.notify_if_upload_new_banner" />
            </div>
            <div class="col-span-12 xl:col-span-3">
                <x-checkbox label="Kanál přidán do promo" wire:model="form.notify_if_channel_was_added_to_promo" />
            </div> --}}
        </div>
        <div class="xl:flex xl:flex-row-reverse">
            <div>
                <x-button label="Upravit"
                    class="bg-sky-800 hover:bg-sky-700 hover:shadow-cyan-700/50 border-none  text-white font-semibold w-full xl:w-28"
                    type="submit" spinner="save2" />
            </div>
        </div>
    </x-form>
</div>
