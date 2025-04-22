<div class="w-full">
    <div class="w-full">
        <div class="border-l-4 border-red-500 bg-custom-red p-4 rounded-md shadow-sm" x-data="reportComponent()" x-init="init()">
            <p class="mb-4 font-normal">Please share this information for troubleshooting:</p>
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <button id="btn-report" @click="showReport = !showReport" class="bg-gray-700 text-white text-sm px-4 py-2 rounded cursor-pointer hover:bg-red-500">
                    Get System Report
                </button>
                <a href="https://github.com/lubusIN/laravel-decomposer/blob/master/report.md" target="_blank" id="btn-about-report"
                    class="bg-white border-black hover:bg-white text-black text-sm px-4 py-2 rounded border">
                    Understand Report
                </a>
            </div>

            <div id="report-wrapper" x-show="showReport" x-transition.duration.400ms.ease-in-out>
                <textarea name="txt-report" id="txt-report"
                    class="w-full border rounded p-2 text-sm font-mono text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    rows="10" spellcheck="false" x-ref="reportText"
                    @focus="$refs.reportText.select()">
                        ### Laravel Environment

                        - Laravel Version: {{ $laravelEnv['version'] }}
                        - Timezone: {{ $laravelEnv['timezone'] }}
                        - Debug Mode: {!! $laravelEnv['debug_mode'] ? '&#10004;' : '&#10008;' !!}
                        - Storage Dir Writable: {!! $laravelEnv['storage_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - Cache Dir Writable: {!! $laravelEnv['cache_dir_writable'] ? '&#10004;' : '&#10008;' !!}
                        - Decomposer Version: {{ $laravelEnv['decomposer_version'] }}
                        - App Size: {{ $laravelEnv['app_size'] }}
                        @foreach($laravelExtras as $extraStatKey => $extraStatValue)
                        - {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                        @endforeach

                        ### Server Environment

                        - PHP Version: {{ $serverEnv['version'] }}
                        - Server Software: {{ $serverEnv['server_software'] }}
                        - Server OS: {{ $serverEnv['server_os'] }}
                        - Database: {{ $serverEnv['database_connection_name'] }}
                        - SSL Installed: {!! $serverEnv['ssl_installed'] ? '&#10004;' : '&#10008;' !!}
                        - Cache Driver: {{ $serverEnv['cache_driver'] }}
                        - Session Driver: {{ $serverEnv['session_driver'] }}
                        - Openssl Ext: {!! $serverEnv['openssl'] ? '&#10004;' : '&#10008;' !!}
                        - PDO Ext: {!! $serverEnv['pdo'] ? '&#10004;' : '&#10008;' !!}
                        - Mbstring Ext: {!! $serverEnv['mbstring'] ? '&#10004;' : '&#10008;' !!}
                        - Tokenizer Ext: {!! $serverEnv['tokenizer']  ? '&#10004;' : '&#10008;'!!}
                        - XML Ext: {!! $serverEnv['xml'] ? '&#10004;' : '&#10008;' !!}
                        @foreach($serverExtras as $extraStatKey => $extraStatValue)
                        - {{ $extraStatKey }}: {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;') : $extraStatValue }}
                        @endforeach

                        ### Installed Packages &amp; their version numbers

                        @foreach($packages as $package)
                        - {{ $package['name'] }} : {{ $package['version'] }}
                        @endforeach

                        @if(!empty($extraStats))
                        ### Extra Information

                        @foreach($extraStats as $extraStatKey => $extraStatValue)
                        - {{ $extraStatKey }} : {{ is_bool($extraStatValue) ? ($extraStatValue ? '&#10004;' : '&#10008;')
                            
                            : $extraStatValue }}
                        @endforeach
                        @endif
                    </textarea>

                <button id="copy-report" type="button" @click="copyReport" class="mt-4 bg-black hover:bg-red-500 text-white text-sm px-4 py-2 rounded cursor-pointer">
                    Copy Report
                </button>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-col lg:flex-row gap-6 mt-6">

    <!-- Package & Dependency column -->
    <div class="w-full lg:w-2/3">
        <div class="bg-white rounded-md overflow-hidden border border-gray-200">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex flex-wrap items-center gap-2">
                <span class="text-gray-700"> {!! $svgIcons['composer'] !!} </span>
                <h3 class="text-lg text-gray-700 font-normal">Installed Packages</h3>
            </div>
            <div class="p-4 overflow-x-auto">
                <div x-data="dataTable()" x-init="init()" class="overflow-x-auto">
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
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        <span x-text="row.name"></span> :
                                        <span class="inline-block bg-custom-red text-black text-xs px-2 py-1 rounded-md" x-text="row.version"></span>
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
    <!-- / Package & Dependency column -->

    <!-- Server Environment column -->
    <div class="w-full lg:w-1/3 space-y-6">
        <!-- Laravel Environment -->
        <div class="bg-white rounded-md border border-gray-200">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex flex-wrap items-center gap-2">
                <span class="text-gray-700"> {!! $svgIcons['laravelIcon'] !!}</span>
                <h3 class="text-lg text-gray-700 font-normal">
                    Laravel Environment
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-4 py-2 font-normal w-75">Laravel Version</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $laravelEnv['version'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Timezone</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $laravelEnv['timezone'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Debug Mode</td>
                            <td class="px-4 py-2 float-right">
                                @if($laravelEnv['debug_mode'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Storage Dir Writable</td>
                            <td class="px-4 py-2 float-right">
                                @if($laravelEnv['storage_dir_writable'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Cache Dir Writable</td>
                            <td class="px-4 py-2 float-right">
                                @if($laravelEnv['cache_dir_writable'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Decomposer Version</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $laravelEnv['decomposer_version'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">App Size</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $laravelEnv['app_size'] }}</td>
                        </tr>
                        @foreach($laravelExtras as $extraStatKey => $extraStatValue)
                        <tr>
                            <td class="px-4 py-2 font-normal">{{ $extraStatKey }}</td>
                            <td class="px-4 py-2 text-gray-500 text-right float-right">
                                @if(is_bool($extraStatValue))
                                @if($extraStatValue)
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                                @else
                                {{ $extraStatValue }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Server Environment -->
        <div class="bg-white rounded-md border border-gray-200 mt-6">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex flex-wrap items-center gap-2">
                <span class="text-gray-700"> {!! $svgIcons['serverIcon'] !!} </span>
                <h3 class="text-lg text-gray-700 font-normal">
                    Server Environment
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="px-4 py-2 font-normal w-1/3">PHP Version</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $serverEnv['version'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Server Software</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $serverEnv['server_software'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Server OS</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $serverEnv['server_os'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Database</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $serverEnv['database_connection_name'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">SSL Installed</td>
                            <td class="px-4 py-2 float-right">
                                @if($serverEnv['ssl_installed'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Cache Driver</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $serverEnv['cache_driver'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Session Driver</td>
                            <td class="px-4 py-2 text-gray-500 text-right">{{ $serverEnv['session_driver'] }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Openssl Ext</td>
                            <td class="px-4 py-2 float-right">
                                @if($serverEnv['openssl'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">PDO Ext</td>
                            <td class="px-4 py-2 float-right">
                                @if($serverEnv['pdo'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Mbstring Ext</td>
                            <td class="px-4 py-2 float-right">
                                @if($serverEnv['mbstring'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">Tokenizer Ext</td>
                            <td class="px-4 py-2 float-right">
                                @if($serverEnv['tokenizer'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-normal">XML Ext</td>
                            <td class="px-4 py-2 float-right">
                                @if($serverEnv['xml'])
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                            </td>
                        </tr>
                        @foreach($serverExtras as $extraStatKey => $extraStatValue)
                        <tr>
                            <td class="px-4 py-2 font-normal">{{ $extraStatKey }}</td>
                            <td class="px-4 py-2 text-gray-500 text-right float-right">
                                @if(is_bool($extraStatValue))
                                @if($extraStatValue)
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                                @else
                                {{ $extraStatValue }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(!empty($extraStats))
        <!-- Extra Stats -->
        <div class="bg-white shadow-md rounded-md border border-gray-200 mt-6">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold">Extra Stats</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-100">
                        @foreach($extraStats as $extraStatKey => $extraStatValue)
                        <tr>
                            <td class="px-4 py-2 font-normal w-1/3">{{ $extraStatKey }}</td>
                            <td class="px-4 py-2 text-gray-500 text-right float-right">
                                @if(is_bool($extraStatValue))
                                @if($extraStatValue)
                                <span class="text-green-600">
                                    {!! $svgIcons['statusTrue'] !!}
                                </span>
                                @else
                                <span class="text-red-600">
                                    {!! $svgIcons['statusFalse'] !!}
                                </span>
                                @endif
                                @else
                                {{ $extraStatValue }}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div> <!-- / Server Environment column -->

</div>