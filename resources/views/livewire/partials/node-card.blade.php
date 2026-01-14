@props(['person', 'generationLevel' => null])

@php
    // Calculate generation level if not provided
    if ($generationLevel === null) {
        $generationLevel = 1;
        $current = $person;
        while ($current->father_id || $current->mother_id) {
            $generationLevel++;
            $current = $current->father ?? $current->mother;
            if ($generationLevel > 10) {
                break;
            } // Safety limit
        }
    }

    // HIERARCHICAL STYLING BASED ON GENERATION
    // Generation 1 (Thủy Tổ): Most Sacred - Traditional Vietnamese Style
    if ($generationLevel == 1) {
        $cardWidth = 'w-72';
        $cardPadding = 'p-6';
        $avatarSize = 'w-28 h-28';
        $avatarIcon = 'h-16 w-16';
        $nameSize = 'text-2xl';
        $borderWidth = 'border-[6px]';
        $borderColor = 'border-red-700';
        $shadowClass = 'shadow-2xl shadow-red-900/50';
        $bgOverride = 'bg-gradient-to-b from-amber-50 via-yellow-100 to-amber-200';
        $topBorderColor = 'border-t-[8px] border-t-red-700';
        $ringClass = 'ring-[6px] ring-yellow-400 ring-offset-4 ring-offset-red-800';
        $decorativeClass = 'ancestor-card';
        $nameClass = 'font-serif text-red-900 tracking-wide drop-shadow-lg';
        $glowClass = ''; // Disabled pulse animation
    }
    // Generation 2 (Con Tổ): High Prestige - Gold accent
    elseif ($generationLevel == 2) {
        $cardWidth = 'w-64';
        $cardPadding = 'p-5';
        $avatarSize = 'w-24 h-24';
        $avatarIcon = 'h-14 w-14';
        $nameSize = 'text-xl';
        $borderWidth = 'border-4';
        $borderColor = 'border-yellow-600';
        $shadowClass = 'shadow-xl shadow-yellow-700/40';
        $bgOverride = 'bg-gradient-to-br from-yellow-50 via-amber-100 to-yellow-100';
        $topBorderColor = 'border-t-[6px] border-t-yellow-600';
        $ringClass = 'ring-4 ring-yellow-300';
        $decorativeClass = '';
        $nameClass = 'font-serif text-yellow-900 tracking-wide';
        $glowClass = '';
    }
    // Generation 3 (Cháu Tổ): Respected Elders - Amber/Gold
    elseif ($generationLevel == 3) {
        $cardWidth = 'w-60';
        $cardPadding = 'p-4';
        $avatarSize = 'w-22 h-22';
        $avatarIcon = 'h-13 w-13';
        $nameSize = 'text-lg';
        $borderWidth = 'border-[3px]';
        $borderColor = 'border-amber-500';
        $shadowClass = 'shadow-lg shadow-amber-600/30';
        $bgOverride = 'bg-gradient-to-br from-amber-50 to-yellow-100';
        $topBorderColor = 'border-t-4 border-t-amber-500';
        $ringClass = 'ring-2 ring-amber-200';
        $decorativeClass = '';
        $nameClass = 'font-serif text-amber-900';
        $glowClass = '';
    }
    // Generation 4+: Regular descendants - Standard colors
    else {
        $cardWidth = 'w-52';
        $cardPadding = 'p-3';
        $avatarSize = 'w-18 h-18';
        $avatarIcon = 'h-11 w-11';
        $nameSize = 'text-base';
        $borderWidth = 'border-2';
        $borderColor = $person->gender === 'male' ? 'border-blue-300' : 'border-pink-300';
        $shadowClass = 'shadow-md hover:shadow-lg';
        $bgOverride =
            $person->gender === 'male'
                ? 'bg-gradient-to-br from-blue-50 to-blue-100'
                : 'bg-gradient-to-br from-pink-50 to-pink-100';
        $topBorderColor = $person->is_alive ? 'border-t-green-500' : 'border-t-gray-400';
        $ringClass = '';
        $decorativeClass = '';
        $nameClass = 'font-serif text-gray-800';
        $glowClass = '';
    }

    // Visibility Logic
    $isVisible = true;
    if (isset($filters)) {
        if (!$filters['showMale'] && $person->gender === 'male') {
            $isVisible = false;
        }
        if (!$filters['showFemale'] && $person->gender === 'female') {
            $isVisible = false;
        }
        if (!$filters['showAlive'] && $person->is_alive) {
            $isVisible = false;
        }
        if (!$filters['showDeceased'] && !$person->is_alive) {
            $isVisible = false;
        }
    }

    $statusClass = $person->is_alive ? '' : 'grayscale-[30%] opacity-90';
    if (!$isVisible) {
        $statusClass .= ' opacity-20 filter grayscale';
    }
@endphp

<div class="group relative flex flex-col items-center cursor-pointer transition-all duration-300 hover:scale-110 hover:-translate-y-1 z-10 focus:outline-none focus:ring-4 focus:ring-primary-400 rounded-2xl"
    tabindex="0" @keydown.enter.prevent="$dispatch('person-selected', { id: {{ $person->id }} })"
    @keydown.space.prevent="$dispatch('person-selected', { id: {{ $person->id }} })"
    wire:click="$dispatch('person-selected', { id: {{ $person->id }} })">

    <!-- Connector Point Top -->
    <div
        class="w-3 h-3 bg-white border-2 border-gray-400 rounded-full absolute -top-1.5 z-20 group-hover:border-primary-500 group-hover:scale-125 transition-all">
    </div>

    <!-- Combined Card Container (Husband + Spouses) -->
    <div
        class="flex items-center rounded-2xl {{ $shadowClass }} {{ $borderWidth }} {{ $borderColor }} {{ $ringClass }} {{ $decorativeClass }} {{ $glowClass }} overflow-hidden transition-all duration-300 ease-out group-hover:border-primary-400 relative
        @if (isset($filters['focusedPersonId']) && $filters['focusedPersonId'] == $person->id) !border-purple-500 !border-[4px] !ring-4 !ring-purple-300 !ring-offset-2 animate-pulse-glow @endif">

        @if ($generationLevel == 1)
            <!-- Decorative Corner Ornaments for Ancestor -->
            <div class="absolute -top-2 -left-2 w-8 h-8 border-t-4 border-l-4 border-yellow-500 rounded-tl-lg"></div>
            <div class="absolute -top-2 -right-2 w-8 h-8 border-t-4 border-r-4 border-yellow-500 rounded-tr-lg"></div>
            <div class="absolute -bottom-2 -left-2 w-8 h-8 border-b-4 border-l-4 border-yellow-500 rounded-bl-lg"></div>
            <div class="absolute -bottom-2 -right-2 w-8 h-8 border-b-4 border-r-4 border-yellow-500 rounded-br-lg">
            </div>
        @endif

        <!-- Primary Person (Husband/Root) -->
        <div
            class="{{ $cardWidth }} flex flex-col items-center {{ $cardPadding }} relative {{ $bgOverride }} border-t-4 {{ $topBorderColor }} {{ $statusClass }}">

            <!-- Top Badges Row -->
            <div class="absolute top-2 left-2 right-2 flex items-start justify-between z-10">
                <!-- Generation Badge (Left) -->
                @if ($person->generation_id)
                    <span
                        class="px-2 py-0.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-[10px] font-bold rounded-full shadow-md">
                        Đời {{ $person->generation_id }}
                    </span>
                @endif

                <!-- Status Badges (Right) -->
                <div class="flex gap-1">
                    @if ($person->is_alive)
                        <span
                            class="px-2 py-0.5 bg-green-500 text-white text-[9px] font-bold rounded-full shadow-md flex items-center gap-0.5">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                            Còn sống
                        </span>
                    @else
                        <span class="px-2 py-0.5 bg-gray-500 text-white text-[9px] font-bold rounded-full shadow-md">
                            Đã mất
                        </span>
                    @endif

                    @if ($person->spouses->count() > 0)
                        <span
                            class="px-1.5 py-0.5 bg-amber-400 text-amber-900 text-[9px] font-bold rounded-full shadow-md"
                            title="Đã kết hôn">
                            💍
                        </span>
                    @endif
                </div>
            </div>

            <!-- Avatar (Larger) -->
            <div
                class="w-24 h-24 rounded-full border-4 border-white shadow-xl overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 mb-3 group-hover:scale-110 group-hover:shadow-2xl transition-all duration-300 ring-2 ring-white mt-6">
                @if ($person->avatar_url)
                    <img src="{{ $person->avatar_url }}" alt="{{ $person->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $avatarIcon }}" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Info -->
            <div class="text-center w-full space-y-1">
                <h3 class="font-bold {{ $nameClass }} text-lg truncate px-1 leading-tight">
                    {{ $person->name }}
                </h3>

                @if ($filters['showDates'] ?? true)
                    <p class="text-sm text-gray-600 font-semibold">
                        {{ $person->birth_year ?? '?' }} -
                        {{ $person->death_year ?? ($person->is_alive ? 'nay' : '?') }}
                    </p>
                @endif

                <!-- Quick Info Icons -->
                <div class="flex flex-wrap items-center justify-center gap-2 mt-2 text-[11px] text-gray-600">
                    @if ($person->hometown)
                        <span class="flex items-center gap-1" title="Quê quán">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="truncate max-w-[80px]">{{ $person->hometown }}</span>
                        </span>
                    @endif

                    @if ($person->occupation)
                        <span class="flex items-center gap-1" title="Nghề nghiệp">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="truncate max-w-[80px]">{{ $person->occupation }}</span>
                        </span>
                    @endif
                </div>

                <!-- Branch Tag -->
                @if ($person->familyBranch)
                    <div class="mt-2">
                        <span
                            class="inline-block px-2.5 py-1 bg-gradient-to-r from-amber-50 to-orange-50 text-amber-800 text-[10px] font-bold rounded-full border border-amber-200 shadow-sm">
                            {{ $person->familyBranch->branch_name }}
                        </span>
                    </div>
                @endif

                @if (($filters['showTitles'] ?? true) && $person->title)
                    <div class="mt-1">
                        <span
                            class="inline-flex items-center gap-1 px-2.5 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 text-[10px] font-bold rounded-full border border-blue-200 shadow-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                            </svg>
                            {{ $person->title }}
                        </span>
                    </div>
                @endif
            </div>
            <!-- Action Buttons (Hover) -->
            <div class="absolute -bottom-3 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity z-30">
                <!-- Focus on Branch Button -->
                <button
                    class="bg-indigo-500 text-white rounded-full p-1 shadow-md hover:bg-indigo-600 hover:scale-110 transition-all"
                    title="Tập trung vào nhánh này"
                    wire:click.stop="$dispatch('focus-on-branch', { personId: {{ $person->id }} })">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd"
                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- Add Button -->
                <button
                    class="bg-primary-500 text-white rounded-full p-1 shadow-md hover:bg-primary-600 hover:scale-110 transition-all"
                    title="Thêm" x-on:click.stop="$dispatch('open-add-modal', { parentId: {{ $person->id }} })">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Spouses List -->
        @if ($filters['showSpouses'] ?? true)
            @foreach ($person->spouses as $spouse)
                @php
                    $spouseGenderBg =
                        $spouse->gender === 'male'
                            ? 'bg-gradient-to-br from-blue-50 to-blue-100'
                            : 'bg-gradient-to-br from-pink-50 to-pink-100';
                    $spouseStatusBorder = $spouse->is_alive ? 'border-t-green-500' : 'border-t-gray-400';
                @endphp
                <div class="w-52 flex flex-col items-center p-4 border-l-2 border-gray-300 relative {{ $spouseGenderBg }} {{ $spouseStatusBorder }} border-t-4 {{ !$spouse->is_alive ? 'grayscale-[30%] opacity-90' : '' }} hover:bg-opacity-80 transition-all focus:outline-none focus:ring-2 focus:ring-secondary-400"
                    tabindex="0" @keydown.enter.prevent="$dispatch('person-selected', { id: {{ $spouse->id }} })"
                    @keydown.space.prevent="$dispatch('person-selected', { id: {{ $spouse->id }} })"
                    wire:click.stop="$dispatch('person-selected', { id: {{ $spouse->id }} })">

                    <!-- Status Indicator -->
                    @if (!$spouse->is_alive)
                        <div class="absolute top-2 right-2 w-2 h-2 bg-gray-400 rounded-full" title="Đã mất"></div>
                    @endif

                    <!-- Avatar -->
                    <div
                        class="w-16 h-16 rounded-full border-2 border-white shadow-md overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 mb-2 ring-1 ring-white">
                        @if ($spouse->avatar_url)
                            <img src="{{ $spouse->avatar_url }}" alt="{{ $spouse->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="text-center w-full">
                        <h3 class="font-bold text-gray-800 text-sm truncate px-1 font-serif">{{ $spouse->name }}</h3>
                        <p class="text-xs text-gray-600 font-medium mt-0.5">
                            {{ $spouse->birth_year ?? '?' }} -
                            {{ $spouse->death_year ?? ($spouse->is_alive ? 'nay' : '?') }}
                        </p>
                        <span
                            class="inline-block mt-1.5 px-2.5 py-0.5 bg-gradient-to-r from-secondary-100 to-secondary-200 text-secondary-800 text-[10px] rounded-full truncate max-w-full font-serif border border-secondary-300 shadow-sm">
                            Vợ/Chồng
                        </span>
                    </div>
                </div>
            @endforeach
        @endif

    </div>

    <!-- Connector Point Bottom -->
    <div class="w-3 h-3 bg-gray-900 rounded-full absolute -bottom-1.5 z-20"></div>
</div>
