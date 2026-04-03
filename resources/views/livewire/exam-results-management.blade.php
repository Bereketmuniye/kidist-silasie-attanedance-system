@section('title', 'Exam Results Management')

<div>

<!-- Page Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Exam Results Management</h1>
    <p class="mt-1 text-sm text-gray-500">View and analyze student exam performance.</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 gap-4 mb-8 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-3 sm:ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Students</dt>
                    <dd class="text-lg sm:text-lg font-semibold text-gray-900">{{ $this->getStatistics()['total'] }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-3 sm:ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Passed</dt>
                    <dd class="text-lg sm:text-lg font-semibold text-gray-900">{{ $this->getStatistics()['passed'] }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="ml-3 sm:ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Failed</dt>
                    <dd class="text-lg sm:text-lg font-semibold text-gray-900">{{ $this->getStatistics()['failed'] }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 2v8m-3-4h.01M9 17h.01"/>
                    </svg>
                </div>
            </div>
            <div class="ml-3 sm:ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Average Score</dt>
                    <dd class="text-lg sm:text-lg font-semibold text-gray-900">{{ $this->getStatistics()['average'] }}%</dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 border border-gray-200 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Exam</label>
            <select wire:model.live="selectedExamId" 
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                <option value="">All Exams</option>
                @foreach($exams as $exam)
                    <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Result Status</label>
            <select wire:model.live="examFilter" 
                    class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
                <option value="all">All</option>
                <option value="passed">Passed</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <div class="relative">
                <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live="search" placeholder="Search student or phone..."
                       class="w-full rounded-lg border border-gray-300 bg-gray-50 pl-9 pr-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-end gap-3 mt-4">
        <button wire:click="exportResults" type="button"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8V4a2 2 0 00-2-2H5a2 2 0 00-2 2v8m-4-4h12"/>
            </svg>
            Export
        </button>
    </div>
</div>

<!-- Results Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    @if($results->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Phone</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Score</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Points</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Started</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Completed</th>
                        <th class="px-3 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Duration</th>
                        <th class="px-3 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($results as $result)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $result->student_name }}</div>
                                <div class="text-xs text-gray-500">{{ $result->completed_at ? $result->completed_at->format('d/m/Y H:i') : 'N/A' }}</div>
                            </div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $result->exam->title }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                            <div class="text-sm text-gray-900">{{ $result->student_phone }}</div>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                {{ $result->percentage >= 60 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $result->percentage >= 60 ? 'Passed' : 'Failed' }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                            {{ $result->correct_answers }} / {{ $result->total_questions }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden lg:table-cell">
                            {{ $result->score }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $result->percentage }}%
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden sm:table-cell">
                            {{ $result->started_at ? $result->started_at->format('H:i:s') : 'N/A' }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden sm:table-cell">
                            {{ $result->completed_at ? $result->completed_at->format('H:i:s') : 'N/A' }}
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900 hidden md:table-cell">
                            {{ $result->started_at && $result->completed_at ? $result->completed_at->diffInMinutes($result->started_at) : 'N/A' }} min
                        </td>
                        <td class="px-3 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex flex-col sm:flex-row justify-end gap-2">
                                <button wire:click="viewDetails({{ $result->id }})" type="button"
                                        class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    Details
                                </button>
                                <button wire:click="deleteResult({{ $result->id }})" type="button"
                                        class="text-red-600 hover:text-red-900 text-sm">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-3 sm:px-6 py-3 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs sm:text-sm text-gray-700">
                Showing {{ $results->firstItem() }} to {{ $results->lastItem() }} of {{ $results->total() }} results
            </div>
            <div class="flex justify-center sm:justify-end">
                {{ $results->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No results found</h3>
            <p class="mt-1 text-xs text-gray-500">No exam results have been recorded yet.</p>
        </div>
    @endif
</div>

<!-- Details Modal -->
@if($showDetails && $selectedResult)
<div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeDetails"></div>
        
        <div class="relative w-full max-w-4xl bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">የተማማሪ ዝርዘርም</h3>
                    <button wire:click="closeDetails" type="button"
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Student Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">የተማማሪ መረጃ</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ሙሉ ስም:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $selectedResult->student_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ስልክ:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $selectedResult->student_phone }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ፈተና:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $selectedResult->exam->title }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">የፈተና መረጃ</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ከመጠን:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $selectedResult->exam->duration_minutes }} ደቂቃ</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ጠቅም ጥያቄዎች:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $selectedResult->total_questions }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">ጠቅም ነጥብ:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $selectedResult->exam->questions->sum('points') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Summary -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">ውጤት ማጠል</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $selectedResult->correct_answers }}</div>
                            <div class="text-xs text-gray-500">የተሳከፉ</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $selectedResult->total_questions }}</div>
                            <div class="text-xs text-gray-500">ጠቅም</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">{{ $selectedResult->score }}</div>
                            <div class="text-xs text-gray-500">ነጥብ</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold {{ $selectedResult->percentage >= 60 ? 'text-green-600' : 'text-red-600' }}">{{ $selectedResult->percentage }}%</div>
                            <div class="text-xs text-gray-500">ፐርሰንት</div>
                        </div>
                    </div>
                </div>

                <!-- Question Details -->
                <div class="bg-white p-4 rounded-lg border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-900 mb-4">የጥያቄዎች ምርዘር</h4>
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @foreach($selectedResult->answers as $index => $answer)
                            <div class="flex items-start justify-between p-3 rounded-lg border {{ $answer->is_correct ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-sm font-medium text-gray-900">ጥያቄ {{ $index + 1 }}</span>
                                        <span class="text-xs text-gray-500">{{ $answer->question->points }} ነጥብ</span>
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium
                                            {{ $answer->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $answer->is_correct ? 'ትክክ' : 'ተሳከቀዎት' }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-900 mb-2">{{ $answer->question->question }}</div>
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        <div>
                                            <span class="text-gray-600">A:</span> <span class="text-gray-900">{{ $answer->question->option_a }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">B:</span> <span class="text-gray-900">{{ $answer->question->option_b }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">C:</span> <span class="text-gray-900">{{ $answer->question->option_c }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">D:</span> <span class="text-gray-900">{{ $answer->question->option_d }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-4 text-sm">
                                    <div class="text-gray-600">የተማማሪ:</span>
                                    <div class="font-medium {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $answer->selected_answer }}
                                    </div>
                                    <div class="text-gray-600">እውካይ:</span>
                                    <div class="font-medium text-green-600">
                                        {{ $answer->question->correct_answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

</div>
