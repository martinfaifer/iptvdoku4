<div class="flex justify-center">
    <div class="fixed z-50 mt-3">
        @if ($showAlerts == true)
            <div wire:click='changeStack' @class(['cursor-pointer font-semibold', 'stack' => $isStacked])>
                @php
                    $counter = 1;
                @endphp
                @foreach ($alerts as $alert)
                    <div wire:key='{{ $alert->id }}' role="alert" @class([
                        'alert bg-orange-900',
                        'shadow-md' => $counter == 1,
                        'shadow' => $counter == 2,
                        'shadow-sm' => $counter == 3,
                    ])>
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ $alert->message }}</span>
                    </div>
                    @php
                        $counter++;
                    @endphp
                @endforeach
            </div>
        @endif

        @if ($showAlert == true)
            @foreach ($alerts as $alert)
                <div role="alert" class="alert shadow-md bg-orange-900 font-semibold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ $alert->message }}</span>
                </div>
            @endforeach
        @endif
    </div>
</div>
