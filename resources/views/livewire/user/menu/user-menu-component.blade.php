<div>
    <ul class="menu w-60">
        <li @class([
            'ml-1',
            'rounded-lg',
            'bg-sky-950' => request()->is('profile'),
        ]) href="/profile" wire:navigate><a>
                <x-heroicon-o-square-3-stack-3d class="size-4" />
                Přehled
            </a></li>


        <li @class([
            'ml-1',
            'rounded-lg',
            'bg-sky-950' => request()->is('profile/notifications'),
        ]) href="/profile/notifications" wire:navigate><a>
                <x-heroicon-o-bell class="w-4 h-4" />
                Upozornění
            </a></li>

        <li @class([
            'ml-1',
            'rounded-lg',
            'bg-sky-950' => request()->is('profile/actions'),
        ]) href="/profile/actions" wire:navigate><a>
                <x-heroicon-o-star class="w-4 h-4" />
                Vaše akce
            </a>
        </li>
    </ul>
</div>
