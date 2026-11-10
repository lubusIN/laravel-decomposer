<div class="bg-white dark:bg-zinc-900/60 rounded-xl border border-zinc-200/80 dark:border-zinc-800 shadow-2xs overflow-hidden"
    x-data="dataTable(window.formattedPackages)" x-init="$nextTick(() => init())">

    <!-- Card Header & Toolbar -->
    <div class="p-4 sm:p-5 border-b border-zinc-100 dark:border-zinc-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <span class="text-zinc-500 dark:text-zinc-400">{!! $svgIcons['composer'] !!}</span>
                <h2 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">Installed Packages</h2>
            </div>
            <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Direct application dependencies and installed lock versions</p>
        </div>

        <!-- Filter Pills & Per-Page -->
        <div class="flex items-center gap-2">
            <div class="inline-flex p-0.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-xs font-medium text-zinc-600 dark:text-zinc-400">
                <button type="button" @click="setFilter('all')"
                    :class="filter === 'all' ? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-2xs font-semibold' : 'hover:text-zinc-900 dark:hover:text-zinc-200'"
                    class="px-2.5 py-1 rounded-md transition-all cursor-pointer">
                    All (<span x-text="data.length"></span>)
                </button>
                <button type="button" @click="setFilter('has-deps')"
                    :class="filter === 'has-deps' ? 'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100 shadow-2xs font-semibold' : 'hover:text-zinc-900 dark:hover:text-zinc-200'"
                    class="px-2.5 py-1 rounded-md transition-all cursor-pointer">
                    With Deps (<span x-text="hasDepsCount"></span>)
                </button>
            </div>

            <select x-model.number="perPage" @change="page = 1"
                class="text-xs bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg px-2.5 py-1 text-zinc-700 dark:text-zinc-300 focus:outline-none focus:ring-1 focus:ring-brand-500 cursor-pointer">
                <option :value="10">10 items</option>
                <option :value="15">15 items</option>
                <option :value="25">25 items</option>
                <option :value="50">50 items</option>
            </select>
        </div>
    </div>

    <!-- Live Search Bar -->
    <div class="px-4 py-3 bg-zinc-50/50 dark:bg-zinc-900/30 border-b border-zinc-100 dark:border-zinc-800/80 flex items-center justify-between gap-3">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-zinc-400 dark:text-zinc-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" id="package-search-input" x-model="search" @input="page = 1"
                placeholder="Search packages or dependencies..."
                class="w-full pl-9 pr-20 py-1.5 text-xs bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg text-zinc-900 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500 transition-shadow">
            
            <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center gap-1.5">
                <button x-show="search.length > 0" x-cloak @click="clearSearch" type="button"
                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300" title="Clear search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </button>
                <kbd class="hidden sm:inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-mono bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-500 border border-zinc-200 dark:border-zinc-700/60 pointer-events-none">/</kbd>
            </div>
        </div>
        <span class="text-xs text-zinc-500 dark:text-zinc-400 font-mono hidden sm:inline" x-text="'Showing ' + paginatedData().length + ' of ' + filteredData.length"></span>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-200/80 dark:divide-zinc-800 text-left text-xs">
            <thead class="bg-zinc-50/75 dark:bg-zinc-900/90 text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-wider text-[11px]">
                <tr>
                    <th scope="col" class="py-3 pl-4 pr-3 sm:pl-6">Package</th>
                    <th scope="col" class="px-3 py-3">Required</th>
                    <th scope="col" class="px-3 py-3">Installed</th>
                    <th scope="col" class="py-3 pl-3 pr-4 sm:pr-6 text-right">Dependencies</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/70 bg-white dark:bg-zinc-900/30">
                <template x-for="row in paginatedData()" :key="row.name">
                    <tr class="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/40 transition-colors group">
                        <!-- Package Name -->
                        <td class="py-3.5 pl-4 pr-3 sm:pl-6 align-top">
                            <div class="flex items-center gap-1.5">
                                <a :href="'https://packagist.org/packages/' + row.name" target="_blank" rel="noopener noreferrer"
                                    class="font-mono text-xs inline-flex items-center gap-1.5 group-hover:underline focus:outline-none"
                                    :title="'View ' + row.name + ' on Packagist'">
                                    <span class="text-zinc-400 dark:text-zinc-500" x-text="vendorName(row.name)"></span><span class="font-semibold text-zinc-900 dark:text-zinc-100" x-text="packageName(row.name)"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3 text-zinc-400 dark:text-zinc-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                            </div>

                            <!-- Expandable dependencies drawer -->
                            <div x-show="isExpanded(row.name)" x-cloak x-transition.duration.80ms class="mt-3 pt-3 border-t border-zinc-100 dark:border-zinc-800">
                                <div class="text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider mb-2">Package Dependencies</div>
                                <div class="flex flex-wrap gap-1.5">
                                    <template x-for="dep in row.dependencies" :key="dep.name">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md font-mono text-[11px] bg-zinc-100 dark:bg-zinc-800/80 text-zinc-700 dark:text-zinc-300 border border-zinc-200/60 dark:border-zinc-700/60">
                                            <span class="text-zinc-900 dark:text-zinc-100 font-medium" x-text="dep.name"></span>
                                            <span class="text-zinc-400 dark:text-zinc-500">:</span>
                                            <span class="text-brand-600 dark:text-brand-400 font-semibold" x-text="dep.version"></span>
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </td>

                        <!-- Required Version -->
                        <td class="px-3 py-3.5 align-top whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md font-mono text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 border border-zinc-200/60 dark:border-zinc-700/60"
                                x-text="row.version"></span>
                        </td>

                        <!-- Installed Version -->
                        <td class="px-3 py-3.5 align-top whitespace-nowrap">
                            <template x-if="row.installed">
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md font-mono text-[11px] font-medium bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-500/20">
                                    <span class="size-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                    <span x-text="row.installed"></span>
                                </span>
                            </template>
                            <template x-if="!row.installed">
                                <span class="text-zinc-400 dark:text-zinc-600 font-mono text-xs italic">—</span>
                            </template>
                        </td>

                        <!-- Dependencies Count & Toggle -->
                        <td class="py-3.5 pl-3 pr-4 sm:pr-6 align-top text-right whitespace-nowrap">
                            <template x-if="hasValidDependencies(row)">
                                <button type="button" @click="toggleRow(row.name)"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium transition-colors cursor-pointer"
                                    :class="isExpanded(row.name) ? 'bg-brand-500/10 text-brand-700 dark:text-brand-400 border border-brand-500/30' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700/80 border border-transparent'">
                                    <span x-text="depCount(row) + (depCount(row) === 1 ? ' dep' : ' deps')"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3 transition-transform duration-200"
                                        :class="isExpanded(row.name) ? 'rotate-180' : ''"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </template>
                            <template x-if="!hasValidDependencies(row)">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] text-zinc-400 dark:text-zinc-500 font-medium">None</span>
                            </template>
                        </td>
                    </tr>
                </template>

                <template x-if="filteredData.length === 0">
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-zinc-300 dark:text-zinc-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">No matching packages found</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-0.5">Try searching for a different package or constraint name</p>
                                <button type="button" @click="clearSearch" class="mt-3 text-xs font-semibold text-brand-600 dark:text-brand-400 hover:underline cursor-pointer">
                                    Clear Search
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="px-4 py-3 bg-zinc-50/70 dark:bg-zinc-900/40 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
        <div class="text-xs text-zinc-500 dark:text-zinc-400">
            Page <span class="font-semibold text-zinc-800 dark:text-zinc-200" x-text="page"></span> of <span class="font-semibold text-zinc-800 dark:text-zinc-200" x-text="totalPages()"></span>
        </div>

        <div class="flex items-center gap-1.5">
            <button type="button" @click="page--" :disabled="page <= 1"
                class="px-3 py-1 text-xs font-medium rounded-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800/80 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                Previous
            </button>
            <button type="button" @click="page++" :disabled="page >= totalPages()"
                class="px-3 py-1 text-xs font-medium rounded-lg border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800/80 disabled:opacity-40 disabled:cursor-not-allowed transition-colors">
                Next
            </button>
        </div>
    </div>
</div>
