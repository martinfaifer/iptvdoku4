<div>
    <ul class="menu w-60">
        @foreach ($sftpServers as $sftpServer)
            <li wire:key='sftpserver_{{ $sftpServer->id }}' @class([
                'ml-1',
                'rounded-lg',
                'bg-sky-950' => request()->is('sftps/' . $sftpServer->id),
            ])
                href="/sftps/{{ $sftpServer->id }}" wire:navigate>
                <a class="grid grid-cols-12">
                    <div class="col-span-12 font-semibold">
                        {{ $sftpServer->name }}
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
