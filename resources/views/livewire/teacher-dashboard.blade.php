<div>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard Overview</h1>
    <p class="mt-1 text-sm text-gray-500">Track attendance and monitor classroom activity.</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-2 gap-3 sm:gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6 sm:mb-8">
    <!-- Present -->
    <div class="relative overflow-hidden rounded-xl sm:rounded-2xl bg-white p-3 sm:p-5 shadow-sm ring-1 ring-gray-200 group hover:shadow-md transition-shadow">
        <div class="absolute -right-2 -top-2 sm:-right-3 sm:-top-3 h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-emerald-50 opacity-60 group-hover:scale-125 transition-transform duration-300"></div>
        <div class="relative">
            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-lg sm:rounded-xl bg-emerald-100 mb-2 sm:mb-3">
                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['present'] }}</p>
            <p class="text-[10px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider mt-0.5">Present</p>
        </div>
    </div>

    <!-- Absent -->
    <div class="relative overflow-hidden rounded-xl sm:rounded-2xl bg-white p-3 sm:p-5 shadow-sm ring-1 ring-gray-200 group hover:shadow-md transition-shadow">
        <div class="absolute -right-2 -top-2 sm:-right-3 sm:-top-3 h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-red-50 opacity-60 group-hover:scale-125 transition-transform duration-300"></div>
        <div class="relative">
            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-lg sm:rounded-xl bg-red-100 mb-2 sm:mb-3">
                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['absent'] }}</p>
            <p class="text-[10px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider mt-0.5">Absent</p>
        </div>
    </div>

    <!-- Late -->
    <div class="relative overflow-hidden rounded-xl sm:rounded-2xl bg-white p-3 sm:p-5 shadow-sm ring-1 ring-gray-200 group hover:shadow-md transition-shadow">
        <div class="absolute -right-2 -top-2 sm:-right-3 sm:-top-3 h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-amber-50 opacity-60 group-hover:scale-125 transition-transform duration-300"></div>
        <div class="relative">
            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-lg sm:rounded-xl bg-amber-100 mb-2 sm:mb-3">
                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['late'] }}</p>
            <p class="text-[10px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider mt-0.5">Late</p>
        </div>
    </div>

    <!-- Excused -->
    <div class="relative overflow-hidden rounded-xl sm:rounded-2xl bg-white p-3 sm:p-5 shadow-sm ring-1 ring-gray-200 group hover:shadow-md transition-shadow">
        <div class="absolute -right-2 -top-2 sm:-right-3 sm:-top-3 h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-sky-50 opacity-60 group-hover:scale-125 transition-transform duration-300"></div>
        <div class="relative">
            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-lg sm:rounded-xl bg-sky-100 mb-2 sm:mb-3">
                <svg class="h-4 w-4 sm:h-5 sm:w-5 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $stats['excused'] }}</p>
            <p class="text-[10px] sm:text-xs font-semibold text-gray-500 uppercase tracking-wider mt-0.5">Excused</p>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 gap-4 lg:gap-6 lg:grid-cols-3">

    <!-- Attendance Form -->
    <div class="lg:col-span-2 rounded-xl sm:rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden">
        <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50/80 px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex items-center gap-2.5">
                <div class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-indigo-100">
                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-800">Mark Attendance</h3>
            </div>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 gap-3 px-4 sm:px-6 pt-4 sm:pt-5 pb-3 sm:pb-4 sm:grid-cols-3">
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Class</label>
                <select wire:model.live="selectedClass"
                        class="w-full rounded-lg sm:rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 sm:py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                    <option value="">Select a class…</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->students_count }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Date</label>
                <input type="date" wire:model.live="selectedDate"
                       class="w-full rounded-lg sm:rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 sm:py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Search</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" wire:model.live="search" placeholder="Name or ID…"
                           class="w-full rounded-lg sm:rounded-xl border border-gray-200 bg-gray-50 pl-9 pr-3 py-2 sm:py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                </div>
            </div>
        </div>

        <!-- Students -->
        <div class="px-4 sm:px-6 pb-4 sm:pb-6">
            @if($selectedClass && $students->count() > 0)

                <!-- Mobile -->
                <div class="lg:hidden space-y-3">
                    @foreach($students as $student)
                    <div class="bg-white rounded-lg border border-gray-200 p-3 shadow-sm">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-sm font-bold text-indigo-700">
                                {{ substr($student->full_name, 0, 1) }}{{ substr(strstr($student->full_name, ' '), 1, 1) ?: '' }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-800 text-sm">{{ $student->full_name }}</p>
                                <p class="text-[11px] text-gray-400">#{{ $student->id }}</p>
                            </div>
                        </div>
                        <div class="flex justify-center gap-2">
                            @foreach(['present' => ['P','emerald'], 'absent' => ['A','red'], 'late' => ['L','amber'], 'excused' => ['E','sky']] as $val => [$label, $color])
                            <label class="cursor-pointer">
                                <input type="radio" wire:model.live="attendanceData.{{ $student->id }}.status" value="{{ $val }}" class="sr-only peer">
                                <div class="w-7 h-7 rounded-lg border-2 peer-checked:bg-{{ $color }}-500 peer-checked:border-{{ $color }}-600 peer-checked:text-white bg-{{ $color }}-50 text-{{ $color }}-700 border-{{ $color }}-300 flex items-center justify-center text-xs font-bold transition-all">{{ $label }}</div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Desktop -->
                <div class="hidden lg:block rounded-xl overflow-hidden border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($students as $student)
                            <tr class="hover:bg-indigo-50/30 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2.5">
                                        <div class="h-8 w-8 shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700">
                                            {{ substr($student->full_name, 0, 1) }}{{ substr(strstr($student->full_name, ' '), 1, 1) ?: '' }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $student->full_name }}</p>
                                            <p class="text-[11px] text-gray-400">#{{ $student->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-3">
                                        <label class="cursor-pointer">
                                            <input type="radio" wire:model.live="attendanceData.{{ $student->id }}.status" value="present" class="sr-only peer">
                                            <div class="w-8 h-8 rounded-lg border-2 peer-checked:bg-emerald-500 peer-checked:border-emerald-600 peer-checked:text-white bg-emerald-50 text-emerald-700 border-emerald-300 flex items-center justify-center text-xs font-bold transition-all">P</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" wire:model.live="attendanceData.{{ $student->id }}.status" value="absent" class="sr-only peer">
                                            <div class="w-8 h-8 rounded-lg border-2 peer-checked:bg-red-500 peer-checked:border-red-600 peer-checked:text-white bg-red-50 text-red-700 border-red-300 flex items-center justify-center text-xs font-bold transition-all">A</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" wire:model.live="attendanceData.{{ $student->id }}.status" value="late" class="sr-only peer">
                                            <div class="w-8 h-8 rounded-lg border-2 peer-checked:bg-amber-500 peer-checked:border-amber-600 peer-checked:text-white bg-amber-50 text-amber-700 border-amber-300 flex items-center justify-center text-xs font-bold transition-all">L</div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" wire:model.live="attendanceData.{{ $student->id }}.status" value="excused" class="sr-only peer">
                                            <div class="w-8 h-8 rounded-lg border-2 peer-checked:bg-sky-500 peer-checked:border-sky-600 peer-checked:text-white bg-sky-50 text-sky-700 border-sky-300 flex items-center justify-center text-xs font-bold transition-all">E</div>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 sm:mt-4 flex flex-col sm:flex-row justify-end gap-2">
                    <button wire:click="exportReport" type="button"
                            class="inline-flex items-center justify-center gap-2 rounded-lg sm:rounded-xl bg-green-600 px-4 py-2 sm:px-5 sm:py-2.5 text-sm font-bold text-white shadow-md shadow-green-600/30 hover:bg-green-700 hover:-translate-y-0.5 transition-all">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span class="hidden sm:inline">Export Report</span>
                        <span class="sm:hidden">Export</span>
                    </button>
                    <button wire:click="markAttendance" type="button"
                            class="inline-flex items-center justify-center gap-2 rounded-lg sm:rounded-xl bg-indigo-600 px-4 py-2 sm:px-5 sm:py-2.5 text-sm font-bold text-white shadow-md shadow-indigo-600/30 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="hidden sm:inline">Save Attendance</span>
                        <span class="sm:hidden">Save</span>
                    </button>
                </div>

            @elseif($selectedClass)
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="h-14 w-14 rounded-2xl bg-gray-100 flex items-center justify-center mb-3">
                        <svg class="h-7 w-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-gray-700">No students found</p>
                    <p class="text-xs text-gray-400 mt-1">No active students match your filters.</p>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center mb-3">
                        <svg class="h-7 w-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <p class="text-sm font-bold text-gray-700">Select a class to begin</p>
                    <p class="text-xs text-gray-400 mt-1">Choose a class from the dropdown above.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="rounded-xl sm:rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden">
        <div class="flex items-center justify-between border-b border-gray-100 bg-gray-50/80 px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex items-center gap-2.5">
                <div class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-emerald-100">
                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-sm font-bold text-gray-800">Recent Activity</h3>
            </div>
        </div>
        <div class="max-h-96 overflow-y-auto">
            @if($recentAttendance->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($recentAttendance as $record)
                    @php
                        $colors = match($record->status) {
                            'present' => ['bg-emerald-100 text-emerald-700', 'bg-emerald-50 text-emerald-600 border-emerald-100'],
                            'absent'  => ['bg-red-100 text-red-700',         'bg-red-50 text-red-600 border-red-100'],
                            'late'    => ['bg-amber-100 text-amber-700',     'bg-amber-50 text-amber-600 border-amber-100'],
                            default   => ['bg-sky-100 text-sky-700',         'bg-sky-50 text-sky-600 border-sky-100'],
                        };
                    @endphp
                    <li class="flex items-center justify-between gap-3 px-4 sm:px-5 py-3 sm:py-3.5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-8 w-8 sm:h-9 sm:w-9 shrink-0 rounded-full border flex items-center justify-center text-xs font-bold {{ $colors[1] }}">
                                {{ strtoupper(substr($record->status, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $record->student->full_name }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">
                                    {{ $record->attendance_date->format('M d') }}
                                    @if($record->check_in_time)· {{ date('H:i', strtotime($record->check_in_time)) }}@endif
                                </p>
                            </div>
                        </div>
                        <span class="shrink-0 inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide {{ $colors[0] }}">
                            {{ $record->status }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="flex flex-col items-center justify-center py-12 sm:py-16 text-center">
                    <svg class="h-8 w-8 sm:h-10 sm:w-10 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-sm text-gray-400">No records yet</p>
                </div>
            @endif
        </div>
        <div class="shrink-0 border-t border-gray-100 px-4 sm:px-6 py-3">
            <a href="{{ route('teacher.reports') }}"
               class="flex items-center justify-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition-colors">
                <span class="hidden sm:inline">View All Reports</span>
                <span class="sm:hidden">All Reports</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
    </div>

</div>