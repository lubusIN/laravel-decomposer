<div class="bg-white dark:bg-zinc-900/60 rounded-xl border border-zinc-200/80 dark:border-zinc-800 shadow-2xs overflow-hidden">
    <!-- Card Header -->
    <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center gap-2.5">
        <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">Extra Application Stats</h3>
    </div>

    <!-- Specs List -->
    <div class="divide-y divide-zinc-100 dark:divide-zinc-800/70 text-xs">
        @foreach($extraStats as $extraStatKey => $extraStatValue)
            <div class="px-5 py-3 flex items-center justify-between">
                <span class="text-zinc-500 dark:text-zinc-400 font-medium">{{ $extraStatKey }}</span>
                <div>
                    @if(is_bool($extraStatValue))
                        @if($extraStatValue)
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                True
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-500/20">
                                <span class="size-1.5 rounded-full bg-rose-500"></span>
                                False
                            </span>
                        @endif
                    @else
                        <span class="font-mono text-zinc-900 dark:text-zinc-100 font-medium">{{ $extraStatValue }}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
