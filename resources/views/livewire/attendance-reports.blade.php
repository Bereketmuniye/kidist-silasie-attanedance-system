@section('title', 'Attendance Reports')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Attendance Reports</h1>
            <p class="text-gray-600">Generate and analyze attendance data</p>
        </div>
        <button wire:click="exportReport" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Export Report
        </button>
    </div>

    <!-- Report Filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="reportType" class="block text-sm font-medium text-gray-700">Report Type</label>
                    <select wire:model.live="reportType" id="reportType" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="summary">Summary</option>
                        <option value="detailed">Detailed</option>
                        <option value="analytics">Analytics</option>
                    </select>
                </div>

                <div>
                    <label for="selectedClass" class="block text-sm font-medium text-gray-700">Class</label>
                    <select wire:model.live="selectedClass" id="selectedClass" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">All Classes</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input type="date" wire:model.live="startDate" id="startDate" 
                           class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                </div>

                <div>
                    <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input type="date" wire:model.live="endDate" id="endDate" 
                           class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                </div>
            </div>
        </div>
    </div>

    <!-- Report Content -->
    @if($reportType === 'summary' && isset($reportData['summary']))
        <!-- Summary Report -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($reportData['summary'] as $stat)
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 
                                    @if($stat->status === 'present') bg-green-100
                                    @elseif($stat->status === 'absent') bg-red-100
                                    @elseif($stat->status === 'late') bg-yellow-100
                                    @else bg-blue-100
                                    @endif rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 
                                        @if($stat->status === 'present') text-green-600
                                        @elseif($stat->status === 'absent') text-red-600
                                        @elseif($stat->status === 'late') text-yellow-600
                                        @else text-blue-600
                                        @endif" fill="currentColor" viewBox="0 0 20 20">
                                        @if($stat->status === 'present')
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        @elseif($stat->status === 'absent')
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        @else
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        @endif
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">{{ ucfirst($stat->status) }}</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stat->count }} ({{ $stat->percentage }}%)</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary Info -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Report Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Records</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $reportData['total_records'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Unique Students</dt>
                        <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $reportData['unique_students'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Date Range</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $reportData['date_range']['days'] }} days
                        </dd>
                        <dd class="text-sm text-gray-500">
                            {{ $reportData['date_range']['start'] }} to {{ $reportData['date_range']['end'] }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($reportType === 'detailed' && $reportData->count() > 0)
        <!-- Detailed Report -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Detailed Attendance Records</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($reportData as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $record->attendance_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $record->student->full_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->student->student_id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($record->status === 'present') bg-green-100 text-green-800
                                            @elseif($record->status === 'absent') bg-red-100 text-red-800
                                            @elseif($record->status === 'late') bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800
                                            @endif">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->check_in_time ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->check_out_time ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $record->notes ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($reportData->hasPages())
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4">
                        {{ $reportData->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($reportType === 'analytics' && isset($reportData['daily_trends']))
        <!-- Analytics Report -->
        <div class="space-y-6">
            <!-- Daily Trends Chart Placeholder -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Daily Attendance Trends</h3>
                    <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                        <p class="text-gray-500">Chart visualization would go here (integrate with Chart.js or similar)</p>
                    </div>
                    
                    <!-- Trend Data Table -->
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Late</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Excused</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportData['daily_trends'] as $trend)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $trend['date'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $trend['present'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $trend['absent'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $trend['late'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $trend['excused'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Student Performance -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Student Performance</h3>
                    <div class="space-y-4">
                        @foreach($reportData['student_performance'] as $studentId => $stats)
                            @php
                                $student = App\Models\Student::find($studentId);
                                $attendanceRate = $this->getAttendanceRate($studentId);
                            @endphp
                            @if($student)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $student->full_name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $student->student_id }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-2xl font-bold text-gray-900">{{ $attendanceRate }}%</div>
                                            <div class="text-sm text-gray-500">Attendance Rate</div>
                                        </div>
                                    </div>
                                    <div class="mt-3 grid grid-cols-4 gap-2 text-sm">
                                        <div class="text-center">
                                            <div class="font-medium text-green-600">{{ $stats->where('status', 'present')->sum('count') }}</div>
                                            <div class="text-gray-500">Present</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="font-medium text-red-600">{{ $stats->where('status', 'absent')->sum('count') }}</div>
                                            <div class="text-gray-500">Absent</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="font-medium text-yellow-600">{{ $stats->where('status', 'late')->sum('count') }}</div>
                                            <div class="text-gray-500">Late</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="font-medium text-blue-600">{{ $stats->where('status', 'excused')->sum('count') }}</div>
                                            <div class="text-gray-500">Excused</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!$reportData || (is_array($reportData) && empty($reportData)))
        <div class="bg-white shadow rounded-lg">
            <div class="text-center py-12 text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No data available</h3>
                <p class="mt-1 text-sm text-gray-500">Select filters to generate attendance reports.</p>
            </div>
        </div>
    @endif
</div>

