<div id="report-wrapper" x-show="showReport" x-cloak x-transition.duration.200ms class="w-full">
    <div class="bg-zinc-950 rounded-xl border border-zinc-800 shadow-xl overflow-hidden">
        <!-- Report Card Header / Toolbar -->
        <div class="px-4 sm:px-5 py-3 bg-zinc-900/80 border-b border-zinc-800 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="text-zinc-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </span>
                <span class="text-xs font-mono font-medium text-zinc-200">
                    decomposer-system-report.md
                </span>
            </div>

            <!-- Report Actions Toolbar -->
            <div class="flex items-center gap-2">
                <button type="button" @click="copyReport"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg transition-all cursor-pointer bg-brand-500 hover:bg-brand-600 text-white focus:outline-none focus:ring-2 focus:ring-brand-400">
                    <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <svg x-show="copied" x-cloak xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span x-text="copied ? 'Copied!' : 'Copy Markdown'"></span>
                </button>

                <button type="button" @click="downloadReport"
                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition-colors cursor-pointer bg-zinc-800/80 hover:bg-zinc-800 text-zinc-300 border border-zinc-700/80 focus:outline-none focus:ring-2 focus:ring-zinc-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Download</span>
                </button>

                <a href="https://github.com/lubusIN/laravel-decomposer/blob/master/report.md" target="_blank" rel="noopener noreferrer"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg text-zinc-400 hover:text-zinc-200 hover:bg-zinc-800/60 transition-colors">
                    <span>Help Guide</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <button type="button" @click="showReport = false" class="text-zinc-400 hover:text-zinc-200 p-1.5 rounded-lg hover:bg-zinc-800 transition-colors" title="Close report">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Monospace Markdown Viewer -->
        <div class="p-4 bg-zinc-950 font-mono text-xs leading-relaxed">
            <textarea name="txt-report" id="txt-report" readonly
                class="w-full h-80 bg-transparent text-zinc-300 font-mono text-xs leading-relaxed border-0 focus:ring-0 resize-y p-2 outline-none selection:bg-brand-500/30 selection:text-white"
                spellcheck="false" x-ref="reportText" @click="$refs.reportText.select()">### Laravel Environment

- Laravel Version: {{ $laravelEnv['version'] }}
- Timezone: {{ $laravelEnv['timezone'] }}
- Debug Mode: {{ $laravelEnv['debug_mode'] ? 'true' : 'false' }}
- Storage Dir Writable: {{ $laravelEnv['storage_dir_writable'] ? 'true' : 'false' }}
- Cache Dir Writable: {{ $laravelEnv['cache_dir_writable'] ? 'true' : 'false' }}
- Decomposer Version: {{ $laravelEnv['decomposer_version'] }}
- App Size: {{ $laravelEnv['app_size'] }}
@foreach($laravelExtras as $extraStatKey => $extraStatValue)
- {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? 'true' : 'false') : $extraStatValue }}
@endforeach

### Server Environment

- PHP Version: {{ $serverEnv['version'] }}
- Server Software: {{ $serverEnv['server_software'] ?: 'CLI / Embedded' }}
- Server OS: {{ $serverEnv['server_os'] }}
- Database: {{ $serverEnv['database_connection_name'] }}
- SSL Installed: {{ $serverEnv['ssl_installed'] ? 'true' : 'false' }}
- Cache Driver: {{ $serverEnv['cache_driver'] }}
- Session Driver: {{ $serverEnv['session_driver'] }}
- Openssl Ext: {{ $serverEnv['openssl'] ? 'true' : 'false' }}
- PDO Ext: {{ $serverEnv['pdo'] ? 'true' : 'false' }}
- Mbstring Ext: {{ $serverEnv['mbstring'] ? 'true' : 'false' }}
- Tokenizer Ext: {{ $serverEnv['tokenizer'] ? 'true' : 'false' }}
- XML Ext: {{ $serverEnv['xml'] ? 'true' : 'false' }}
@foreach($serverExtras as $extraStatKey => $extraStatValue)
- {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? 'true' : 'false') : $extraStatValue }}
@endforeach

### Installed Packages &amp; Version Numbers

@foreach($packages as $package)
- {{ $package['name'] }} : {{ $package['version'] }}
@endforeach
@if(!empty($extraStats))

### Extra Information

@foreach($extraStats as $extraStatKey => $extraStatValue)
- {{ $extraStatKey }} : {{ is_bool($extraStatValue) ? ($extraStatValue ? 'true' : 'false') : $extraStatValue }}
@endforeach
@endif</textarea>
        </div>
    </div>
</div>
