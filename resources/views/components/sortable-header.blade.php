@props(['field', 'label'])

@php
    $currentSort = request('sort', 'created_at');
    $currentDirection = request('direction', 'desc');
    $isSorted = $currentSort === $field;
    $newDirection = $isSorted && $currentDirection === 'asc' ? 'desc' : 'asc';
    $url = request()->fullUrlWithQuery(['sort' => $field, 'direction' => $newDirection]);
@endphp

<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider p-0">
    <a href="{{ $url }}" class="flex items-center space-x-1 hover:bg-gray-100 dark:bg-gray-800 px-6 py-3 transition-colors group">
        <span class="{{ $isSorted ? 'text-indigo-600 font-bold' : '' }}">{{ $label }}</span>
        <span class="flex-shrink-0">
            @if($isSorted)
                @if($currentDirection === 'asc')
                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>
                @else
                    <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                @endif
            @else
                <svg class="w-4 h-4 text-gray-300 opacity-20 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" /></svg>
            @endif
        </span>
    </a>
</th>