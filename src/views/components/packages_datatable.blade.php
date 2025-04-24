<div class="w-full lg:w-2/3">
    <div class="bg-white rounded-md overflow-hidden border border-gray-200">
        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex flex-wrap items-center gap-2">
            <span class="text-gray-500"> {!! $svgIcons['composer'] !!} </span>
            <h3 class="text-lg text-gray-700 font-normal">Installed Packages</h3>
        </div>
        <div class="p-4 overflow-x-auto">
            <div x-data="dataTable(window.formattedPackages)" x-init="$nextTick(() => init())" class="overflow-x-auto">
                <div class="flex justify-between items-center mb-4">
                    <input type="text" x-model="search" placeholder="Search…" class="border border-gray-300 rounded px-3 py-2 focus:outline-none" />
                    <span class="text-sm text-gray-600" x-text="'Showing ' + filteredData.length + ' results'"></span>
                </div>

                <table class="min-w-full divide-y divide-gray-300 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-700 font-medium">
                        <tr>
                            <th class="px-4 py-2">Package Name : Version</th>
                            <th class="px-4 py-2">Dependency Name : Version</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <template x-for="row in paginatedData()" :key="row.name">
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap align-top">
                                    <span x-text="row.name"></span> :
                                    <span class="inline-block bg-red-100 text-black text-xs px-2 py-1 rounded-md" x-text="row.version"></span>
                                </td>
                                <td class="px-4 py-2">
                                    <ul class="list-disc ml-4 h-36 overflow-y-auto pr-2">
                                        <template x-for="dep in row.dependencies" :key="dep.name">
                                            <li>
                                                <span class="text-gray-500" x-text="dep.name"></span> :
                                                <span class="inline-block bg-gray-200 my-1 text-gray-800 text-xs px-2 py-1 rounded-md" x-text="dep.version"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-4">
                    <button
                        class="px-3 py-1 border rounded"
                        x-show="page > 1"
                        @click="page--">
                        Previous
                    </button>

                    <div class="text-sm">
                        Page <span x-text="page"></span> of <span x-text="totalPages()"></span>
                    </div>

                    <button
                        class="px-3 py-1 border rounded"
                        x-show="page < totalPages()"
                        @click="page++">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>