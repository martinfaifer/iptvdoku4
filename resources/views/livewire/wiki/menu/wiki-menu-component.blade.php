<div>
    <ul class="menu w-60">
        @foreach ($categoriesWithTopicsNames as $category)
            <li wire:key=='category_{{ $category->id }}'>
                <details open>
                    <summary class="font-semibold">
                        {{ $category->name }}
                    </summary>
                    <ul>
                        @foreach ($category->topics as $topic)
                            <li id="topic_{{ $topic->id }}" wire:key='topic_{{ $topic->id }}'
                                @class([
                                    'ml-1',
                                    'rounded-lg',
                                    'bg-sky-950' =>
                                        request()->is('wiki/' . $topic->id) ||
                                        request()->is('wiki/' . $topic->id . '/*'),
                                ]) href="/wiki/{{ $topic->id }}" wire:navigate><a>

                                    <div class="grid grid-cols-12 gap-1">
                                        <div class="col-span-12">
                                            {{ $topic->title }}
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </details>
            </li>
        @endforeach
    </ul>
    @script
        <script>
            let url = window.location.href;
            let parsedUrl = url.split("/");
            try {
                document
                    .getElementById('topic_' + parsedUrl.slice(-1))
                    .scrollIntoView({});
            } catch (error) {

            }
        </script>
    @endscript
</div>
