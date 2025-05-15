<div class="flex items-center justify-center min-h-screen">
    <div
        class="card w-full md:w-2/6 dark:bg-[#131B2F] rounded-xl shadow-xl shadow-gray-850 bg-clip-padding backdrop-filter backdrop-blur-sm">
        <div class="card-body">
            <h2 class="text-3xl font-bold text-center">
                Zapomenuté heslo
            </h2>
            <x-form wire:submit="sendPassword" class="mt-6">
                <x-input label="Email" wire:model="form.email" placeholder="vas_email@" />
                <div>
                    <x-button label="Odeslat nové heslo" class="btn btn-doku-primary w-full" type="submit" spinner="sendPassword"/>
                </div>
            </x-form>
        </div>
    </div>
</div>
