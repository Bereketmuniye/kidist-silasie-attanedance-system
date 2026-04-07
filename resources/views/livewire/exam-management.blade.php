@extends('layouts.app')

@section('title', 'የፈተና አስተዳደር')

@section('content')
<div>
{{-- Page Header --}}
<div class="mb-4 flex flex-col gap-3">
    <div>
        <h1 class="text-xl font-bold text-gray-900">የፈተና አስተዳደር</h1>
        <p class="mt-1 text-xs text-gray-500">ፈተናዎችን ይፍጠሩ፣ ያስተካክሉ እና ያስተዳዱ።</p>
    </div>
    <button wire:click="createExam" type="button"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        ፈተና ይፍጠሩ
    </button>
</div>

{{-- Filters --}}
<div class="mb-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
    <div class="relative">
        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" wire:model.live="search" placeholder="ፈተና ይፈልጉ..."
               class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-9 pr-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
    </div>
</div>

{{-- Exams Table --}}
<div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden">
    @if($exams->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-xs sm:text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ፈተና</th>
                        <th class="hidden sm:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ጥያቄዎች</th>
                        <th class="hidden md:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ከመጠን</th>
                        <th class="hidden lg:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ውጤቶች</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ሁኔታ</th>
                        <th class="px-3 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">ተግባራት</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($exams as $exam)
                    <tr class="hover:bg-indigo-50/30 transition-colors">
                        <td class="px-3 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="h-6 w-6 sm:h-8 sm:w-8 shrink-0 rounded-full bg-purple-100 flex items-center justify-center text-[10px] sm:text-xs font-bold text-purple-700 border border-purple-200">
                                    {{ substr($exam->title,0,1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 text-xs sm:text-sm truncate">{{ $exam->title }}</p>
                                    <p class="text-[10px] sm:text-xs text-gray-500 sm:hidden">{{ $exam->duration_minutes }} ደቂቃ</p>
                                    <div class="sm:hidden space-y-1 mt-1">
                                        <p class="text-[10px] text-gray-500">
                                            <span class="font-medium">ጥያቄዎች:</span> {{ $exam->totalQuestions() }}
                                        </p>
                                        <p class="text-[10px] text-gray-500">
                                            <span class="font-medium">ውጤቶች:</span> {{ $exam->results()->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="hidden sm:table-cell px-3 py-3 whitespace-nowrap text-gray-600 text-xs sm:text-sm">{{ $exam->totalQuestions() }}</td>
                        <td class="hidden md:table-cell px-3 py-3 whitespace-nowrap text-gray-600 text-xs sm:text-sm">{{ $exam->duration_minutes }} ደቂቃ</td>
                        <td class="hidden lg:table-cell px-3 py-3 whitespace-nowrap text-gray-600 text-xs sm:text-sm">{{ $exam->results()->count() }}</td>
                        <td class="px-3 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-bold
                                {{ $exam->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                <span class="mr-1 h-1 w-1 rounded-full {{ $exam->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $exam->is_active ? 'ንቁ' : 'የተቋረጠ' }}
                            </span>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-right">
                            <div class="flex flex-col sm:flex-row gap-1 sm:gap-1">
                                <button wire:click="manageQuestions({{ $exam->id }})" type="button"
                                        class="inline-flex items-center justify-center rounded-lg bg-blue-500 px-2 py-1.5 text-xs font-medium text-white hover:bg-blue-600 transition-colors">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span class="hidden sm:inline ml-1">ጥያቄዎች</span>
                                </button>
                                <button wire:click="editExam({{ $exam->id }})" type="button"
                                        class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-2 py-1.5 text-xs font-medium text-white hover:bg-amber-600 transition-colors">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="hidden sm:inline ml-1">አስተካክል</span>
                                </button>
                                <button wire:click="toggleExamStatus({{ $exam->id }})" type="button"
                                        class="inline-flex items-center justify-center rounded-lg {{ $exam->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }} px-2 py-1.5 text-xs font-medium text-white transition-colors">
                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                    <span class="hidden sm:inline ml-1">{{ $exam->is_active ? 'አግድም' : 'ንቁ' }}</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-3 py-3 border-t border-gray-100 flex items-center justify-between">
            <div class="text-xs text-gray-500">
                ከ {{ $exams->firstItem() }} እስከ {{ $exams->lastItem() }} ከ {{ $exams->total() }} ፈተናዎች
            </div>
            {{ $exams->links() }}
        </div>
    @else
        <div class="p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">ምንም ፈተናዎች የሉም</h3>
            <p class="mt-1 text-xs text-gray-500">የመጀመሪያውን ፈተና ይፍጠሩ።</p>
            <div class="mt-6">
                <button wire:click="createExam" type="button"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 transition-colors">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    ፈተና ይፍጠሩ
                </button>
            </div>
        </div>
    @endif
</div>

{{-- Exam Modal --}}
@if($showModal)
<div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>
        
        <div class="relative w-full max-w-md transform overflow-hidden rounded-xl bg-white p-6 text-left shadow-xl transition-all">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                {{ $isEditing ? 'ፈተና አስተካክል' : 'አዲስ ፈተና' }}
            </h3>
            
            <form wire:submit="saveExam">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">የፈተናው ርዕስ *</label>
                        <input type="text" wire:model="title" required
                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">መግለጫ</label>
                        <textarea wire:model="description" rows="3"
                                  class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ከመጠን (ደቂቃ) *</label>
                        <input type="number" wire:model="duration_minutes" min="5" max="180" required
                               class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('duration_minutes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="is_active" id="is_active" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="is_active" class="ml-2 text-sm text-gray-700">ፈተናው ንቁ ይሁን</label>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-3 justify-end">
                    <button type="button" wire:click="closeModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        ይሰርዙ
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                        {{ $isEditing ? 'አስተካክል' : 'ፍጠር' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Questions List Modal --}}
@if($showQuestionsList)
<div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeQuestionsList"></div>
        
        <div class="relative w-full max-w-4xl transform overflow-hidden rounded-xl bg-white p-6 text-left shadow-xl transition-all">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">ጥያቄዎች አስተዳደር</h3>
                <div class="flex gap-2">
                    <button wire:click="addQuestion" type="button"
                            class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        አዲስ ጥያቄ
                    </button>
                    <button wire:click="closeQuestionsList" type="button"
                            class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            @if($questions->count() > 0)
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @foreach($questions as $index => $question)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-sm font-medium text-indigo-600">ጥያቄ {{ $index + 1 }}</span>
                                        <span class="text-xs text-gray-500">{{ $question->points }} ነጥብ</span>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $question->correct_answer === 'A' ? 'bg-green-100 text-green-800' : ($question->correct_answer === 'B' ? 'bg-blue-100 text-blue-800' : ($question->correct_answer === 'C' ? 'bg-yellow-100 text-yellow-800' : 'bg-purple-100 text-purple-800')) }}">
                                            እውካይ: {{ $question->correct_answer }}
                                        </span>
                                    </div>
                                    <p class="text-gray-900 mb-3">{{ $question->question }}</p>
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 mr-2">A:</span>
                                            <span class="text-gray-800">{{ $question->option_a }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 mr-2">B:</span>
                                            <span class="text-gray-800">{{ $question->option_b }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 mr-2">C:</span>
                                            <span class="text-gray-800">{{ $question->option_c }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="font-medium text-gray-600 mr-2">D:</span>
                                            <span class="text-gray-800">{{ $question->option_d }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <button wire:click="editQuestion({{ $index }})" type="button"
                                            class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        አስተካክል
                                    </button>
                                    <button wire:click="deleteQuestion({{ $index }})" type="button"
                                            class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        ሰርዝ
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">ምንም ጥያቄዎች የሉም</h3>
                    <p class="mt-1 text-xs text-gray-500">የመጀመሪያውን ጥያቄ ይፍጠሩ።</p>
                    <div class="mt-6">
                        <button wire:click="addQuestion" type="button"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            የመጀመሪያ ጥያቄ
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- Question Form Modal --}}
@if($showQuestionModal)
<div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeQuestionModal"></div>
        
        <div class="relative w-full max-w-2xl transform overflow-hidden rounded-xl bg-white p-6 text-left shadow-xl transition-all">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                {{ $isEditingQuestion ? 'ጥያቄ አስተካክል' : 'አዲስ ጥያቄ' }}
            </h3>
            
            <form wire:submit="saveQuestion">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ጥያቄ *</label>
                        <textarea wire:model="question" rows="3" required
                                  class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"></textarea>
                        @error('question') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">አማራጭ A *</label>
                            <input type="text" wire:model="option_a" required
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('option_a') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">አማራጭ B *</label>
                            <input type="text" wire:model="option_b" required
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('option_b') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">አማራጭ C *</label>
                            <input type="text" wire:model="option_c" required
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('option_c') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">አማራጭ D *</label>
                            <input type="text" wire:model="option_d" required
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('option_d') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">እውካይ መልስ *</label>
                            <select wire:model="correct_answer" required
                                    class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                            @error('correct_answer') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ነጥብ *</label>
                            <input type="number" wire:model="points" min="1" max="10" required
                                   class="form-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            @error('points') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-3 justify-end">
                    <button type="button" wire:click="closeQuestionModal"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        ይሰርዙ
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                        {{ $isEditingQuestion ? 'አስተካክል' : 'ጨምር' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('openQuestionModal', () => {
            // The modal will be shown automatically when $showQuestionModal is true
        });
    });
</script>
@endsection
