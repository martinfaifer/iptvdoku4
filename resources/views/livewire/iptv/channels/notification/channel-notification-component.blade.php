<div>
    <div class="mt-4">
        <div class="grid grid-cols-12">
            <div class="col-span-12 flex">
                <h1 class="text-lg dark:text-white/80 font-semibold mt-6 ">
                    Nastavení upozornění u {{ $ip }}
                </h1>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4 mt-4">
        <div class="col-span-12 mt-4">
            <x-form wire:submit="chnage_if_can_be_notify">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 md:col-span-10">
                        <x-checkbox label="Povolit upozornění?" wire:model="can_notify" />
                    </div>
                    <div class="col-span-12 md:col-span-2 md:-mt-2">
                        <x-button label="Upravit"
                            class="btn btn-doku-primary w-full md:w-36 btn-sm"
                            type="chnage_if_can_be_notify" />
                    </div>
                </div>
            </x-form>
        </div>
        <div class="col-span-12 md:col-span-6 mt-8">
            <x-share.cards.base-card title="Emaily kam se mohou poslat upozornění">
                <div class="grid grid-cols-12 gap-4">
                    <div>
                        <button
                            class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-green-500"
                            @click='$wire.openEmailNotificationModal()'>
                            <x-heroicon-o-plus-circle class="size-4" />
                        </button>
                    </div>
                    <div class="col-span-12">
                        <x-table :headers="$email_headers" :rows="$emails" with-pagination>
                            @scope('cell_actions', $email)
                                <div class="flex mx-auto gap-4">
                                    <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                                        wire:click="destroy_email({{ $email->id }})"
                                        wire:confirm="Opravdu odebrat zaznam?">
                                        <x-heroicon-o-trash class="size-4 text-red-500" />
                                    </button>
                                </div>
                            @endscope
                        </x-table>
                    </div>
                </div>
            </x-share.cards.base-card>
        </div>
        <div class="col-span-12 md:col-span-6 mt-8">
            <x-share.cards.base-card title="Slack kanály">
                <div class="grid grid-cols-12 gap-4">
                    <div>
                        <button
                            class="btn btn-circle btn-outline btn-sm border-none bg-transparent fixed top-1 right-1 text-green-500"
                            @click='$wire.openSlacklNotificationModal()'>
                            <x-heroicon-o-plus-circle class="size-4" />
                        </button>
                    </div>
                    <div class="col-span-12">
                        <x-table :headers="$slack_headers" :rows="$slack_channels" with-pagination>
                            @scope('cell_actions', $slack)
                                <div class="flex mx-auto gap-4">
                                    <button class="btn btn-sm btn-circle bg-opacity-0 border-transparent"
                                        wire:click="destroy_slack({{ $slack->id }})"
                                        wire:confirm="Opravdu odebrat zaznam?">
                                        <x-heroicon-o-trash class="size-4 text-red-500" />
                                    </button>
                                </div>
                            @endscope
                        </x-table>
                    </div>
                </div>
            </x-share.cards.base-card>
        </div>
        <div class="col-span-12 ">
            <p class="mt-2 ml-2 text-sm italic font-semibold text-sky-500">Pokud není vyplněn slack channel aplikuje se
                globální
                pravidlo pro odesílání!</p>
            <p class="mt-2 ml-2 text-sm italic font-semibold text-sky-500">U streamu se bude kontrolovat maximální
                velikost datového toku, pokud se jedá o unicast</p>
        </div>
    </div>

    <x-modal wire:model="emailNotificationModal" persistent class="modal-bottom xl:modal-middle fixed"
        box-class="overflow-visible">
        <x-form wire:submit="add_email">

            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-12 mb-4">
                    <x-input label="Email" wire:model="emailForm.email" />
                </div>
            </div>
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="add_email" />
                </div>
            </div>
        </x-form>
    </x-modal>

    <x-modal wire:model="slackChannelNotificationModal" persistent class="modal-bottom xl:modal-middle fixed"
        box-class="overflow-visible">
        <x-form wire:submit="add_slack">

            <x-button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                wire:click='closeDialog'>✕</x-button>
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-12 md:col-span-12 mb-4">
                    <x-input label="Slack kanál" wire:model="slackForm.slack_channel" />
                </div>
            </div>
            <div class="flex justify-between">
                <div>
                    <x-button label="Zavřít" class="btn btn-doku-close w-full sm:w-28 mb-4"
                        wire:click='closeDialog' />
                </div>
                <div>
                    <x-button label="Přidat"
                        class="btn btn-doku-primary w-full sm:w-28"
                        type="submit" spinner="add_slack" />
                </div>
            </div>
        </x-form>
    </x-modal>
</div>
