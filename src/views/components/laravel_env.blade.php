<div class="bg-white dark:bg-zinc-900/60 rounded-xl border border-zinc-200/80 dark:border-zinc-800 shadow-2xs overflow-hidden">
    <!-- Card Header -->
    <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center gap-2.5">
        <span class="text-zinc-500 dark:text-zinc-400">{!! $svgIcons['laravelIcon'] !!}</span>
        <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">Laravel Environment</h3>
    </div>

    <!-- Specs List -->
    <div class="divide-y divide-zinc-100 dark:divide-zinc-800/70 text-xs">
        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Laravel Version</span>
            <span class="font-mono font-semibold text-zinc-900 dark:text-zinc-100">{{ $laravelEnv['version'] }}</span>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Timezone</span>
            <span class="font-mono text-zinc-700 dark:text-zinc-300">{{ $laravelEnv['timezone'] }}</span>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Debug Mode</span>
            <div>
                @if($laravelEnv['debug_mode'])
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-500/20">
                        <span class="size-1.5 rounded-full bg-amber-500"></span>
                        Enabled
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200/60 dark:border-zinc-700/60">
                        <span class="size-1.5 rounded-full bg-zinc-400 dark:bg-zinc-500"></span>
                        Disabled
                    </span>
                @endif
            </div>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Storage Directory</span>
            <div>
                @if($laravelEnv['storage_dir_writable'])
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                        <span class="size-1.5 rounded-full bg-emerald-500"></span>
                        Writable
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-500/20">
                        <span class="size-1.5 rounded-full bg-rose-500"></span>
                        Not Writable
                    </span>
                @endif
            </div>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Bootstrap Cache Directory</span>
            <div>
                @if($laravelEnv['cache_dir_writable'])
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                        <span class="size-1.5 rounded-full bg-emerald-500"></span>
                        Writable
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-500/20">
                        <span class="size-1.5 rounded-full bg-rose-500"></span>
                        Not Writable
                    </span>
                @endif
            </div>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Decomposer Version</span>
            <span class="font-mono text-zinc-700 dark:text-zinc-300 font-medium">{{ $laravelEnv['decomposer_version'] }}</span>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Application Size</span>
            <span class="font-mono font-semibold text-zinc-900 dark:text-zinc-100">{{ $laravelEnv['app_size'] }}</span>
        </div>

        @foreach($laravelExtras as $extraStatKey => $extraStatValue)
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
