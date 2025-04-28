<div class="w-full">
    <div class="w-full">
        <div class="border-l-4 border-red-500 bg-red-100 p-4 rounded-md shadow-sm" x-data="reportComponent()" x-init="$nextTick(() => init())">
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
                    class="w-full border rounded p-2 text-sm font-mono bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 my-8"
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
                <span x-show="copied" x-transition class="ml-2 text-gray-500 font-medium">
                    Copied!
                </span>
            </div>
        </div>
    </div>
</div>