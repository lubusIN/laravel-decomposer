<div class="min-h-full flex flex-col" x-data="reportComponent()" x-init="$nextTick(() => init())">
    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-30 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-zinc-200/80 dark:border-zinc-800/80 shadow-2xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Logo -->
                <div class="flex items-center gap-4">
                    <a href="{{ url()->current() }}" class="flex items-center gap-3 group focus:outline-none" aria-label="Laravel Decomposer">
                        @include('Decomposer::components.logo')
                    </a>
                </div>

                <!-- Action Controls -->
                <div class="flex items-center gap-2">
                    <!-- Copy Report Action -->
                    <button type="button" @click="copyReport"
                        class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-medium rounded-lg shadow-2xs transition-all cursor-pointer bg-brand-500 hover:bg-brand-600 text-white focus:outline-none focus:ring-2 focus:ring-brand-500/40 active:scale-[0.98]">
                        <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        <svg x-show="copied" x-cloak xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span x-text="copied ? 'Copied to Clipboard!' : 'Copy Report'"></span>
                    </button>

                    <!-- View Markdown Toggle -->
                    <button type="button" @click="showReport = !showReport"
                        :class="showReport ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 border-zinc-300 dark:border-zinc-700' : 'bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 border-zinc-200 dark:border-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-800/50'"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg border transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-zinc-400 dark:focus:ring-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-zinc-400 dark:text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span x-text="showReport ? 'Hide Report' : 'Raw Markdown'"></span>
                    </button>

                    <div class="h-4 w-px bg-zinc-200 dark:bg-zinc-800 mx-1 hidden sm:block"></div>

                    <!-- Theme Toggle -->
                    <button type="button" @click="toggleTheme"
                        class="p-1.5 rounded-lg text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none"
                        :title="isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode'">
                        <!-- Sun Icon (shows in dark mode) -->
                        <svg x-show="isDark" x-cloak xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon (shows in light mode) -->
                        <svg x-show="!isDark" xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    <!-- GitHub Repository Link -->
                    <a href="https://github.com/lubusIN/laravel-decomposer" target="_blank" rel="noopener noreferrer"
                        class="p-1.5 text-zinc-400 dark:text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-200 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus:outline-none" title="GitHub Repository">
                        <svg class="size-4 fill-current" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
        <!-- Collapsible System Report Card -->
        @include('Decomposer::components.report_component')

        <!-- Main 2-Column Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left: Packages & Dependencies Table (Col 8) -->
            <div class="lg:col-span-8">
                @include('Decomposer::components.packages_datatable')
            </div>

            <!-- Right: Environment Cards (Col 4) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Laravel Environment Specs -->
                @include('Decomposer::components.laravel_env')

                <!-- Server Environment Specs -->
                @include('Decomposer::components.server_env')

                <!-- Optional Extra Stats -->
                @if(!empty($extraStats))
                    @include('Decomposer::components.extra_stats')
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-zinc-200/80 dark:border-zinc-800/80 bg-white dark:bg-zinc-950 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-500 dark:text-zinc-400">
            <p>
                Crafted by <a href="https://lubus.in/?utm_source=package&utm_medium=footer&utm_campaign=laravel-decomposer" target="_blank" rel="noopener noreferrer" class="font-medium text-zinc-700 dark:text-zinc-300 hover:text-brand-600 dark:hover:text-brand-400 transition-colors">LUBUS</a> for the Laravel Community.
            </p>
            <div class="flex items-center gap-4">
                <a href="https://github.com/lubusIN/laravel-decomposer/blob/master/report.md" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
                    Report Guide
                </a>
                <span>·</span>
                <a href="https://github.com/lubusIN/laravel-decomposer" target="_blank" rel="noopener noreferrer" class="hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
                    GitHub
                </a>
            </div>
        </div>
    </footer>
</div>
