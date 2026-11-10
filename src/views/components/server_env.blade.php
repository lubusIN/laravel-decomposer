<div class="bg-white dark:bg-zinc-900/60 rounded-xl border border-zinc-200/80 dark:border-zinc-800 shadow-2xs overflow-hidden">
    <!-- Card Header -->
    <div class="px-5 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center gap-2.5">
        <span class="text-zinc-500 dark:text-zinc-400">{!! $svgIcons['serverIcon'] !!}</span>
        <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">Server &amp; PHP Environment</h3>
    </div>

    <!-- Specs List -->
    <div class="divide-y divide-zinc-100 dark:divide-zinc-800/70 text-xs">
        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">PHP Version</span>
            <span class="font-mono font-semibold text-zinc-900 dark:text-zinc-100">{{ $serverEnv['version'] }}</span>
        </div>

        <div class="px-5 py-3 flex items-start justify-between gap-4">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium whitespace-nowrap">Server Software</span>
            <span class="font-mono text-zinc-700 dark:text-zinc-300 text-right truncate max-w-[220px]" title="{{ $serverEnv['server_software'] }}">
                {{ $serverEnv['server_software'] ?: 'CLI / Embedded' }}
            </span>
        </div>

        <div class="px-5 py-3 flex items-start justify-between gap-4">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium whitespace-nowrap">Server OS</span>
            <span class="font-mono text-zinc-700 dark:text-zinc-300 text-right truncate max-w-[220px]" title="{{ $serverEnv['server_os'] }}">
                {{ $serverEnv['server_os'] }}
            </span>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Database Connection</span>
            <span class="font-mono font-semibold text-zinc-900 dark:text-zinc-100 capitalize">{{ $serverEnv['database_connection_name'] ?: 'None' }}</span>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">SSL Status</span>
            <div>
                @if($serverEnv['ssl_installed'])
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                        <span class="size-1.5 rounded-full bg-emerald-500"></span>
                        Secured
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200/60 dark:border-zinc-700/60">
                        <span class="size-1.5 rounded-full bg-zinc-400 dark:bg-zinc-500"></span>
                        Not Detected
                    </span>
                @endif
            </div>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Cache Driver</span>
            <span class="font-mono text-zinc-700 dark:text-zinc-300 font-medium">{{ $serverEnv['cache_driver'] ?: 'None' }}</span>
        </div>

        <div class="px-5 py-3 flex items-center justify-between">
            <span class="text-zinc-500 dark:text-zinc-400 font-medium">Session Driver</span>
            <span class="font-mono text-zinc-700 dark:text-zinc-300 font-medium">{{ $serverEnv['session_driver'] ?: 'None' }}</span>
        </div>

        <!-- PHP Core Extensions Grid -->
        <div class="px-5 py-3.5 bg-zinc-50/50 dark:bg-zinc-900/40">
            <div class="text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-2.5">PHP Core Extensions</div>
            <div class="grid grid-cols-2 gap-2 text-[11px]">
                <!-- OpenSSL -->
                <div class="flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800">
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">OpenSSL</span>
                    @if($serverEnv['openssl'])
                        <span class="inline-flex items-center text-emerald-600 dark:text-emerald-400" title="Enabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <span class="inline-flex items-center text-rose-500 dark:text-rose-400" title="Disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>

                <!-- PDO -->
                <div class="flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800">
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">PDO</span>
                    @if($serverEnv['pdo'])
                        <span class="inline-flex items-center text-emerald-600 dark:text-emerald-400" title="Enabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <span class="inline-flex items-center text-rose-500 dark:text-rose-400" title="Disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>

                <!-- Mbstring -->
                <div class="flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800">
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Mbstring</span>
                    @if($serverEnv['mbstring'])
                        <span class="inline-flex items-center text-emerald-600 dark:text-emerald-400" title="Enabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <span class="inline-flex items-center text-rose-500 dark:text-rose-400" title="Disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>

                <!-- Tokenizer -->
                <div class="flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800">
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">Tokenizer</span>
                    @if($serverEnv['tokenizer'])
                        <span class="inline-flex items-center text-emerald-600 dark:text-emerald-400" title="Enabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <span class="inline-flex items-center text-rose-500 dark:text-rose-400" title="Disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>

                <!-- XML -->
                <div class="flex items-center justify-between px-2.5 py-1.5 rounded-lg bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 col-span-2">
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">XML</span>
                    @if($serverEnv['xml'])
                        <span class="inline-flex items-center text-emerald-600 dark:text-emerald-400" title="Enabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <span class="inline-flex items-center text-rose-500 dark:text-rose-400" title="Disabled">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @foreach($serverExtras as $extraStatKey => $extraStatValue)
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
