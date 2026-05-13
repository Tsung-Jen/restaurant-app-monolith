<div class="bg-white rounded-lg shadow p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Reservation Calendar</h3>
            <p class="text-gray-500 mt-1">{{ $this->monthYear }}</p>
        </div>
        <div class="flex gap-2">
            <button 
                wire:click="previousMonth" 
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium transition">
                ← Previous
            </button>
            <button 
                wire:click="goToToday" 
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                Today
            </button>
            <button 
                wire:click="nextMonth" 
                class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium transition">
                Next →
            </button>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="px-4 py-3 text-left text-sm font-semibold">Sun</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Mon</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Tue</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Wed</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Thu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Fri</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold">Sat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->calendarDays as $week)
                    <tr>
                        @foreach ($week as $day)
                            <td class="border border-gray-200 p-2 h-40 align-start bg-gray-50 hover:bg-blue-50 transition">
                                @if ($day['date'])
                                    <div class="h-full flex flex-col">
                                        <div class="text-lg font-bold mb-2">
                                            {{ $day['day'] }}
                                        </div>
                                        <div class="text-xs space-y-1 flex-1">
                                            <!-- Lunch Session -->
                                            <div class="@if ($day['lunchTotal'] >= 55) bg-red-200 text-red-800 font-semibold @else bg-green-100 text-green-800 @endif px-2 py-1 rounded">
                                                Lunch: {{ $day['lunchTotal'] }}/55
                                            </div>
                                            <!-- Dinner Session -->
                                            <div class="@if ($day['dinnerTotal'] >= 55) bg-red-200 text-red-800 font-semibold @else bg-green-100 text-green-800 @endif px-2 py-1 rounded">
                                                Dinner: {{ $day['dinnerTotal'] }}/55
                                            </div>
                                            @if ($day['reservationCount'] > 0)
                                                <div class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                                    {{ $day['reservationCount'] }} reservation(s)
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="text-gray-400 font-bold text-lg">
                                        {{ $day['day'] }}
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
