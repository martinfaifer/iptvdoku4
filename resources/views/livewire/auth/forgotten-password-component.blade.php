<div class="flex items-center justify-center min-h-screen">
    <div
        class="card w-full md:w-2/6 bg-[#131B2F] rounded-xl shadow-xl shadow-gray-850 bg-clip-padding backdrop-filter backdrop-blur-sm">
        <div class="card-body">
            <h2 class="text-3xl font-bold text-center">
                {{-- <x-heroicon-m-tv class="h-8 w-8 absolute lg:ml-20 xl:ml-20 2xl:ml-20 md:h-12 md:w-12 text-red-500" /> --}}
                Zapomenuté heslo
            </h2>
            <x-form wire:submit="sendNewPassword" class="mt-6">
                <x-input label="Email" wire:model.live="email" placeholder="vas_email@"/>
                <div>
                    @error('form.email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <x-button label="Odeslat nové heslo" class="bg-sky-800 hover:bg-sky-700 text-white font-semibold w-full"
                        type="submit" />
                </div>

            </x-form>
        </div>
    </div>
</div>
