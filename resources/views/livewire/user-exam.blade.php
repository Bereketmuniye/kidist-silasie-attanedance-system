@section('title', 'ፈተና')

<div>
    @if(!$exam)
        <div class="min-h-screen flex items-center justify-center bg-gray-50">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">ፈተናው አልተገኘም</h3>
                <p class="mt-1 text-sm text-gray-500">የፈተናውን መረጃ ለመፍጠር እንደገና ይሞክሩ።</p>
                <div class="mt-6">
                    <a href="{{ route('exams.list') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 transition-colors">
                        ወደ ፈተናዎች ይመለሱ
                    </a>
                </div>
            </div>
        </div>
    @elseif(!$examStarted && !$examCompleted)
        {{-- Exam Start Screen --}}
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div class="text-center">
                    <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-indigo-100">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-gray-900">{{ $exam->title }}</h2>
                    @if($exam->description)
                        <p class="mt-2 text-sm text-gray-600">{{ $exam->description }}</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">ጥያቄዎች</span>
                            <span class="text-sm text-gray-900">{{ $questions->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">ከመጠን</span>
                            <span class="text-sm text-gray-900">{{ $exam->duration_minutes }} ደቂቃ</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">የአጠቃቀም ነጥብ</span>
                            <span class="text-sm text-gray-900">{{ $questions->sum('points') }}</span>
                        </div>
                    </div>

                    <form wire:submit="startExam" class="mt-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ሙሉ ስም *</label>
                            <input type="text" wire:model="studentName" required
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                   placeholder="ሙሉ ስምዎን ያስገቡ">
                            @error('studentName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ስልክ ቁጥር *</label>
                            <input type="text" wire:model="studentPhone" required
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                   placeholder="ስልክ ቁጥርዎን ያስገቡ">
                            @error('studentPhone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">አስፈላጊ መረጃ</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            <li>ፈተናው ከጀመሩ በኋላ መቆም አይችልም</li>
                                            <li>ከመጠኑ እንዳለፈ ውጤቶች በራስ-ሰጥተው ይላካሉ</li>
                                            <li>እያንዳንዱ ጥያቄ መልስ መስጠን ግዴታ ነው</li>
                                            <li>ከመጠኑ ሲያልፍ በራስ-ሰጥቶ ይላካሉ</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            ፈተናውን ይጀምሩ
                        </button>
                    </form>
                </div>
            </div>
        </div>

    @elseif($examStarted && !$examCompleted)
        {{-- Exam Questions --}}
        <div class="min-h-screen bg-gray-50">
            {{-- Header --}}
            <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <h1 class="text-lg font-semibold text-gray-900">{{ $exam->title }}</h1>
                            <span class="text-sm text-gray-500">{{ $studentName }}</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm font-medium {{ $timeRemaining < 300 ? 'text-red-600' : 'text-gray-600' }}" timer-display>
                                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span id="timer-time">{{ $timeRemaining / 60 }}:{{ sprintf('%02d', $timeRemaining % 60) }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $this->answeredCount }} / {{ $questions->count() }}
                            </div>
                        </div>
                    </div>
                    
                    {{-- Progress Bar --}}
                    <div class="mt-3">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: {{ $this->progress }}%"></div>
                        </div>
                        <div class="mt-1 text-xs text-gray-500 text-right">{{ round($this->progress) }}% ተጠናቋል</div>
                    </div>
                </div>
            </div>

            {{-- Question --}}
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{-- Debug Information --}}
                @if(!$examStarted && !$examCompleted)
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <h4 class="text-sm font-medium text-yellow-800 mb-2">Debug Information:</h4>
                        <div class="text-xs text-yellow-700 space-y-1">
                            <p>Exam ID: {{ $examId ?? 'Not set' }}</p>
                            <p>Exam Loaded: {{ $exam ? 'Yes' : 'No' }}</p>
                            <p>Questions Count: {{ $questions ? $questions->count() : 'No questions array' }}</p>
                            <p>Current Index: {{ $currentQuestionIndex }}</p>
                            @if($exam)
                                <p>Exam Title: {{ $exam->title }}</p>
                                <p>Exam Active: {{ $exam->is_active ? 'Yes' : 'No' }}</p>
                            @endif
                        </div>
                    </div>
                @endif
                
                @if(isset($questions[$currentQuestionIndex]))
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm font-medium text-indigo-600">
                                    ጥያቄ {{ $currentQuestionIndex + 1 }} ከ {{ $questions->count() }}
                                </span>
                                <span class="text-sm text-gray-500">{{ $questions[$currentQuestionIndex]->points }} ነጥብ</span>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $questions[$currentQuestionIndex]->question }}
                            </h3>
                        </div>

                        <div class="space-y-3">
                            {{-- Option A --}}
                            <button wire:click="selectAnswer('A')" 
                                    class="w-full text-left p-4 rounded-lg border-2 transition-all
                                           {{ ($answers[$currentQuestionIndex] ?? null) === 'A' 
                                               ? 'border-indigo-500 bg-indigo-50' 
                                               : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 mr-3 flex items-center justify-center
                                                {{ ($answers[$currentQuestionIndex] ?? null) === 'A' 
                                                    ? 'border-indigo-500 bg-indigo-500' 
                                                    : 'border-gray-300' }}">
                                        @if(($answers[$currentQuestionIndex] ?? null) === 'A')
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        @endif
                                    </div>
                                    <span class="text-gray-900">A. {{ $questions[$currentQuestionIndex]->option_a }}</span>
                                </div>
                            </button>

                            {{-- Option B --}}
                            <button wire:click="selectAnswer('B')" 
                                    class="w-full text-left p-4 rounded-lg border-2 transition-all
                                           {{ ($answers[$currentQuestionIndex] ?? null) === 'B' 
                                               ? 'border-indigo-500 bg-indigo-50' 
                                               : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 mr-3 flex items-center justify-center
                                                {{ ($answers[$currentQuestionIndex] ?? null) === 'B' 
                                                    ? 'border-indigo-500 bg-indigo-500' 
                                                    : 'border-gray-300' }}">
                                        @if(($answers[$currentQuestionIndex] ?? null) === 'B')
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        @endif
                                    </div>
                                    <span class="text-gray-900">B. {{ $questions[$currentQuestionIndex]->option_b }}</span>
                                </div>
                            </button>

                            {{-- Option C --}}
                            <button wire:click="selectAnswer('C')" 
                                    class="w-full text-left p-4 rounded-lg border-2 transition-all
                                           {{ ($answers[$currentQuestionIndex] ?? null) === 'C' 
                                               ? 'border-indigo-500 bg-indigo-50' 
                                               : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 mr-3 flex items-center justify-center
                                                {{ ($answers[$currentQuestionIndex] ?? null) === 'C' 
                                                    ? 'border-indigo-500 bg-indigo-500' 
                                                    : 'border-gray-300' }}">
                                        @if(($answers[$currentQuestionIndex] ?? null) === 'C')
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        @endif
                                    </div>
                                    <span class="text-gray-900">C. {{ $questions[$currentQuestionIndex]->option_c }}</span>
                                </div>
                            </button>

                            {{-- Option D --}}
                            <button wire:click="selectAnswer('D')" 
                                    class="w-full text-left p-4 rounded-lg border-2 transition-all
                                           {{ ($answers[$currentQuestionIndex] ?? null) === 'D' 
                                               ? 'border-indigo-500 bg-indigo-50' 
                                               : 'border-gray-200 hover:border-gray-300 hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <div class="w-6 h-6 rounded-full border-2 mr-3 flex items-center justify-center
                                                {{ ($answers[$currentQuestionIndex] ?? null) === 'D' 
                                                    ? 'border-indigo-500 bg-indigo-500' 
                                                    : 'border-gray-300' }}">
                                        @if(($answers[$currentQuestionIndex] ?? null) === 'D')
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        @endif
                                    </div>
                                    <span class="text-gray-900">D. {{ $questions[$currentQuestionIndex]->option_d }}</span>
                                </div>
                            </button>
                        </div>

                        {{-- Navigation --}}
                        <div class="mt-8 flex justify-between">
                            <button wire:click="previousQuestion" 
                                    {{ $currentQuestionIndex === 0 ? 'disabled' : '' }}
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                ← ያለፉትን
                            </button>
                            
                            <button wire:click="nextQuestion" 
                                    class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                                {{ $currentQuestionIndex === $questions->count() - 1 ? 'ውጤት ይመዝገቡ' : 'የሚቀጥለውን →' }}
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    @elseif($examCompleted && $showResult)
        {{-- Exam Results --}}
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full">
                <div class="text-center">
                    <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full 
                        {{ $examResult->percentage >= 60 ? 'bg-green-100' : 'bg-red-100' }}">
                        <svg class="h-6 w-6 {{ $examResult->percentage >= 60 ? 'text-green-600' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            @if($examResult->percentage >= 60)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @endif
                        </svg>
                    </div>
                    <h2 class="mt-6 text-3xl font-bold text-gray-900">ፈተናው ተጠናቋል!</h2>
                    <p class="mt-2 text-lg text-gray-600">{{ $studentName }}</p>
                </div>

                <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">የተሳከፉ ጥያቄዎች</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $examResult->correct_answers }} / {{ $examResult->total_questions }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">ነጥብ</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $examResult->score }}</span>
                        </div>
                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                            <span class="text-sm font-medium text-gray-700">ፐርሰንት</span>
                            <span class="text-lg font-semibold {{ $examResult->percentage >= 60 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $examResult->percentage }}%
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-3">
                            <span class="text-sm font-medium text-gray-700">የተሳከፉበት ጊዜ</span>
                            <span class="text-sm text-gray-900">{{ $examResult->completed_at->format('H:i:s') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <div class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium
                            {{ $examResult->percentage >= 60 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $examResult->percentage >= 60 ? 'የተሳከቀዎት!' : 'እንደገና ይሞክሩ!' }}
                        </div>
                    </div>

                    <div class="mt-8 space-y-3">
                        <button wire:click="backToExams" 
                                class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            ወደ ፈተናዎች ይመለሱ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Basic Timer --}}
@if($examStarted && !$examCompleted)
<script>
var time = {{ $timeRemaining }};
var el = document.getElementById('timer-time');

setInterval(function() {
    if (time > 0) {
        time--;
        var minutes = Math.floor(time / 60);
        var seconds = time % 60;
        el.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        
        if (time < 300) {
            el.parentElement.className = el.parentElement.className.replace('text-gray-600', 'text-red-600');
        }
    } else {
        location.reload();
    }
}, 1000);
</script>
@endif
