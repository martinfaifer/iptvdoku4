<div>
    <div class="bg-[#F6F7F9] dark:bg-[#0f172a]/50 border-[2px] border-slate-200/80 dark:border-none backdrop-blur-xl shadow-sm dark:shadow-md dark:shadow-[#0D243C]/50 rounded-lg">
        <div class="pt-2">
            <p class="text-center text-sm font-semibold">
                {{ $title }}
            </p>
        </div>
        <div class="card-body dark:text-gray-200 text-sm">
            {{ $slot }}
        </div>
    </div>
</div>
