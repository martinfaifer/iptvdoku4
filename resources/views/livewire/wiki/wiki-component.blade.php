<div>
    <div class="flex flex-col">
        <div class="relative">
            <div class="absolute left inline-flex gap-4">
                @can('create', App\Models\WikiCategory::class)
                    <livewire:wiki.create-wiki-category-component />
                @endcan
                @can('create', App\Models\WikiTopic::class)
                    <livewire:wiki.create-wiki-topic-component />
                @endcan
            </div>
        </div>
        {{-- show alert about no sat card found --}}
        @if (is_null($topic) || is_null($topic->title))
            <div class="mt-12">
                <x-share.alerts.info title="Zde zjistíte vše co potřebujete ..."></x-share.alerts.info>
            </div>
        @else
            <div class="grid grid-cols-12 mt-8">
                <div class="col-span-12 flex">
                    <h1 class="text-2xl text-white/80 subpixel-antialiased font-bold mt-6 ">
                        {{ $topic->title }}
                    </h1>

                    {{-- actions --}}
                    @can('update', $topic)
                        <livewire:wiki.update-wiki-topic-component :topic="$topic" />
                    @endcan

                    @can('delete', $topic)
                        <livewire:wiki.delete-wiki-topic-component :topic="$topic" />
                    @endcan
                    {{-- end of actions --}}
                </div>
            </div>
            <hr
                class="w-full h-1 mt-2 mx-auto my-1 bg-gradient-to-r from-sky-950 via-blue-850 to-sky-950 border-0 rounded">
            <div class="mt-4">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        {{-- <article> --}}
                            {!! $topic->text !!}
                            {{-- {!! Str::markdown($topic->text) !!} --}}
                        {{-- </article> --}}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
