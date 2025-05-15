<div class="flex items-center justify-center min-h-screen">
    <div
        class="card w-full md:w-2/6 dark:bg-[#131B2F] rounded-xl shadow-xl shadow-gray-850 bg-clip-padding backdrop-filter backdrop-blur-sm">
        <div class="card-body">
            <h2 class="text-3xl font-bold text-center">
                {{-- <x-heroicon-m-tv class="h-8 w-8 absolute lg:ml-20 xl:ml-20 2xl:ml-20 md:h-12 md:w-12 text-red-500" /> --}}
                IPTV Dokumentace
            </h2>
            <x-form wire:submit="login" class="mt-6">
                <x-input label="Email" wire:model="form.email" class="input-primary" />
                <x-input label="Heslo" wire:model="form.password" type="password" />
                <div>
                    <x-button label="Přihlásit se" class="btn btn-doku-primary w-full"
                        type="submit" spinner="login"/>
                </div>

            </x-form>
            <div>
                <a class="text-sm text-blue-500 hover:text-blue-700 hover:underline" href="/forgotten-password" wire:navigate>Zapomněli jste heslo?</a>
            </div>
        </div>
    </div>
</div>
