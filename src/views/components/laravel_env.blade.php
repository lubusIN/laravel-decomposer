<div class="bg-white rounded-md border border-gray-200">
    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex flex-wrap items-center gap-2">
        <span class="text-gray-500"> {!! $svgIcons['laravelIcon'] !!}</span>
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