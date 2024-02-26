<div class="flex items-center justify-center min-h-screen">
    <div
        class="card w-full md:w-2/6 bg-[#131B2F] rounded-xl shadow-xl shadow-gray-850 bg-clip-padding backdrop-filter backdrop-blur-sm">
        <div class="card-body">
            <h2 class="text-3xl font-bold text-center">
                {{-- <x-heroicon-m-tv class="h-8 w-8 absolute lg:ml-20 xl:ml-20 2xl:ml-20 md:h-12 md:w-12 text-red-500" /> --}}
                IPTV Dokumentace
            </h2>
            <x-form wire:submit="login" class="mt-6">
                <x-input label="Email" wire:model="email" />
                <div>
                    @error('form.email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <x-input label="Heslo" wire:model="password" type="password" />
                <div>
                    @error('form.password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <x-slot:actions>
                    <x-button label="Přihlásit se" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full md:w-28"
                        type="submit" />
                </x-slot:actions>
            </x-form>
        </div>
    </div>
</div>
