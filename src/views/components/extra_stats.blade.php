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