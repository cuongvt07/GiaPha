<div>
    {{-- Modal Overlay --}}
    @if($showModal)
    <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            
            {{-- Backdrop with Blur --}}
            <div class="fixed inset-0 bg-gray-800/60 backdrop-blur-sm transition-opacity" aria-hidden="true" wire:click="close"></div>

            {{-- Removed span spacer --}}

            <div class="relative inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                
                {{-- Header --}}
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                    <div class="sm:flex sm:items-start justify-between">
                         <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                📅 Các ngày quan trọng
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                Quản lý ngày giỗ, ngày lễ của dòng họ.
                            </div>
                        </div>
                        <button wire:click="close" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Body: List of Dates --}}
                <div class="bg-gray-50 px-4 py-4 sm:p-6 max-h-80 overflow-y-auto">
                    @if(count($dates) > 0)
                        <ul class="space-y-3">
                            @foreach($dates as $date)
                                <li class="p-3 rounded-lg shadow-sm border flex flex-col transition-colors {{ $date->days_remaining < 30 ? 'bg-amber-50 border-amber-200' : 'bg-white border-gray-100' }}">
                                    <div class="flex justify-between items-center w-full">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="font-bold text-gray-800 truncate">{{ $date->title }}</p>
                                                @if($date->days_remaining < 30)
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700">Sắp đến</span>
                                                @endif
                                            </div>
                                            
                                            <div class="text-sm text-gray-600 flex items-center flex-wrap gap-x-3 gap-y-1">
                                                <span class="text-indigo-600 font-medium whitespace-nowrap">Âm: {{ $date->display_lunar }}</span>
                                                <span class="text-gray-400 text-xs italic">({{ $date->can_chi_day }} {{ $date->can_chi_month }})</span>
                                                <span class="text-gray-300 hidden sm:inline">|</span>
                                                <span class="text-green-600 whitespace-nowrap">Dương: {{ $date->display_solar }}</span>
                                                <span class="text-gray-400 text-xs whitespace-nowrap">
                                                    (Còn <span class="{{ $date->days_remaining < 30 ? 'text-amber-600 font-bold' : '' }}">{{ $date->next_occurrence ? $date->days_remaining : '?' }}</span> ngày)
                                                </span>
                                            </div>
                                        </div>
                                        <button wire:click="deleteDate({{ $date->id }})" class="text-red-400 hover:text-red-600 p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- 5-Year Forecast & Lucky Hours --}}
                                    <details class="mt-2 text-xs group">
                                        <summary class="cursor-pointer text-indigo-500 hover:text-indigo-700 font-medium select-none list-none flex items-center gap-1">
                                            <span>Xem chi tiết & Dự báo</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </summary>
                                        <div class="mt-2 pl-2 border-l-2 border-indigo-100 space-y-3">
                                            {{-- Next Day Details --}}
                                            @if($date->occurrences && count($date->occurrences) > 0)
                                                <div class="bg-indigo-50/50 p-2 rounded">
                                                    <p class="font-bold text-indigo-700 mb-1">Giờ Hoàng Đạo (Ngày {{ $date->next_occurrence?->format('d/m') }}):</p>
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach(collect($date->occurrences)->firstWhere('is_past', false)['lucky_hours'] ?? [] as $hour)
                                                            <span class="px-1.5 py-0.5 bg-white border border-indigo-200 rounded text-indigo-600 font-medium">{{ $hour }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="space-y-1">
                                                    <p class="font-bold text-gray-700 mb-1">Dự báo 5 năm tới:</p>
                                                    @foreach($date->occurrences as $occurrence)
                                                        <div class="flex justify-between items-center {{ $occurrence['is_past'] ? 'opacity-50 line-through' : '' }}">
                                                            <span class="text-gray-600">Năm {{ $occurrence['year'] }} ({{ $occurrence['can_chi'] }}):</span>
                                                            <span class="font-medium {{ $occurrence['is_past'] ? 'text-gray-500' : 'text-green-600' }}">
                                                                {{ $occurrence['lunar_display'] }} <span class="text-gray-400 text-[10px]">=></span> {{ $occurrence['formatted'] }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </details>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-gray-500 py-4">Chưa có sự kiện nào.</p>
                    @endif
                </div>

                {{-- Footer: Add Form --}}
                <div class="bg-white px-4 py-4 sm:px-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-700 mb-3">Thêm sự kiện mới</h4>
                    <div class="grid grid-cols-1 gap-3 mb-3">
                        <div>
                            <input wire:model="newTitle" type="text" placeholder="Tên sự kiện (VD: Giỗ Tổ)" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-3">
                            @error('newTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Calendar Type Selection --}}
                        <div class="flex gap-4 items-center">
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model.live="newCalendar" value="lunar" class="form-radio text-indigo-600">
                                <span class="ml-2 text-sm text-gray-700">Âm lịch</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model.live="newCalendar" value="solar" class="form-radio text-indigo-600">
                                <span class="ml-2 text-sm text-gray-700">Dương lịch</span>
                            </label>
                        </div>
                        
                        {{-- Generic Date Input --}}
                         <div>
                            <label class="block text-xs text-gray-500 mb-1">
                                @if($newCalendar == 'solar')
                                    Ngày Dương (Ngày - Tháng - Năm)
                                @else
                                    Ngày Âm (Ngày - Tháng - Năm)
                                @endif
                            </label>
                            <div class="flex gap-2">
                                <input wire:model="newDay" type="number" min="1" max="31" placeholder="Ngày" class="w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-3">
                                <input wire:model="newMonth" type="number" min="1" max="12" placeholder="Tháng" class="w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-3">
                                <input wire:model="newYear" type="number" min="1900" max="2100" placeholder="Năm (tùy chọn)" class="w-1/3 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-3">
                            </div>
                            @error('newDay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @error('newMonth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <p class="text-xs text-gray-400 italic">
                             @if($newCalendar == 'lunar')
                                Hệ thống sẽ tính ra ngày Dương lịch tương ứng hàng năm.
                             @else
                                Hệ thống sẽ nhắc nhở vào đúng ngày này hàng năm.
                             @endif
                        </p>

                    </div>
                    <button wire:click="saveDate" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:text-sm">
                        Thêm Sự Kiện
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    {{-- Integration of Nghia's Lunar Library (CDN) --}}
    <script src="https://cdn.jsdelivr.net/gh/NghiaCaNgao/LunarDate@tree/latest/dist/index.umd.js"></script>
</div>
