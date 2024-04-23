<div>
    <div class="grid grid-cols-12 gap-4">
        @foreach ($filesInFolder as $banner)
            <div class="col-span-3">
                <img class="hover:shadow-xl object-contain w-34 h-36" src="{{ $banner }}" alt="{{ $banner }}" />
            </div>
        @endforeach
    </div>
</div>
