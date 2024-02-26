<div>
    <div class="navbar top-0 right-0 w-10/12 fixed bg-transparent mb-11 z-30" wire:poll.20s>
        <div class="flex-1">
            {{--  --}}
        </div>
        <div class="flex-none gap-2">
            <div class="form-control">
                <input @click.stop="$dispatch('mary-search-open')" type="text" placeholder="Vyhledejte ...           ⌘G"
                    class="input input-bordered input-sm bg-opacity-20 text-white w-24 md:w-auto" />
            </div>
            <div>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img alt="e_avatar"
                                src="https://ui-avatars.com/api/?background=132231&color=fff&name={{ Auth::user()->name }}" />
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-gray-400 bg-clip-padding  backdrop-filter
                    backdrop-blur-sm
                    bg-opacity-10 rounded-box w-52">
                        <li>
                            <a class="justify-between" href="/profile" wire:navigate>
                                Profil
                            </a>
                        </li>
                        <li><a href="/settings/dashboard" wire:navigate>Nastavení</a></li>
                        <li wire:click='logout()'><a>Odhlásit se</a></li>
                    </ul>
                </div>
            </div>
            <div>
                <label for="alert-drawer" class="btn btn-sm bg-transparent border-none">
                    <x-heroicon-c-bell @class([
                        'h-6 w-6',
                        'text-red-500' => !empty($iptv_dohled_alerts),
                        'text-gray-500' => empty($iptv_dohled_alerts),
                    ]) />
                    @if (!empty($iptv_dohled_alerts))
                        <div class="text-white text-sm bg-red-500 rounded-full fixed w-5 h-5 ml-4 mt-3">
                            {{ count($iptv_dohled_alerts) }}
                        </div>
                    @endif
                </label>
            </div>
        </div>
    </div>

    <x-drawer id="alert-drawer" right class="lg:w-1/4 !bg-[#0A0F19]">
        {{-- alerts --}}
        @if (!empty($iptv_dohled_alerts))
            @foreach ($iptv_dohled_alerts as $iptv_dohled_alert)
                <div role="alert" class="alert alert-error mb-3 text-gray-100 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $iptv_dohled_alert['nazev'] }}</span>
                </div>
            @endforeach
        @endif
    </x-drawer>
</div>
