<div class="bg-white rounded-md border border-gray-200 mt-6">
    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200 flex flex-wrap items-center gap-2">
        <span class="text-gray-500"> {!! $svgIcons['serverIcon'] !!} </span>
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
                    <td class="px-4 py-2 font-normal align-top">Server Software</td>
                    <td class="px-4 py-2 text-gray-500 text-right">{{ $serverEnv['server_software'] }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-normal align-top">Server OS</td>
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