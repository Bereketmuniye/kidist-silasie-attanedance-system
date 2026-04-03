@section('title', 'Class Management')

<div>

{{-- Page Header --}}
<div class="mb-4 flex flex-col gap-3">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Class Management</h1>
        <p class="mt-1 text-xs text-gray-500">Add, edit and manage class courses.</p>
    </div>
    <button wire:click="createClass" type="button"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Add Class
    </button>
</div>

{{-- Filters --}}
<div class="mb-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
    <div class="relative">
        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" wire:model.live="search" placeholder="Search class name, code, description..."
               class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-9 pr-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
    </div>
</div>

{{-- Classes Table --}}
<div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden">
    @if($classes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-100 text-xs sm:text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Class</th>
                        <th class="hidden sm:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Teacher</th>
                        <th class="hidden lg:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Schedule</th>
                        <th class="hidden lg:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Room</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Students</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($classes as $class)
                    <tr class="hover:bg-indigo-50/30 transition-colors">
                        <td class="px-3 py-3">
                            <div>
                                <p class="font-semibold text-gray-800 text-xs sm:text-sm">{{ $class->name }}</p>
                                <p class="text-xs text-gray-400">{{ $class->code }}</p>
                                @if($class->description)
                                    <p class="text-xs text-gray-500 mt-1 hidden sm:block">{{ Str::limit($class->description, 30) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="hidden sm:table-cell px-3 py-3">
                            <div class="flex items-center gap-2">
                                <div class="h-6 w-6 shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-700 border border-indigo-200">
                                    {{ substr($class->teacher->first_name,0,1) }}{{ substr($class->teacher->last_name,0,1) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-gray-700 text-xs truncate">{{ $class->teacher->first_name }} {{ $class->teacher->last_name }}</p>
                                    <p class="text-[10px] text-gray-400 truncate">{{ $class->teacher->department }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="hidden lg:table-cell px-3 py-3 text-gray-600 text-xs">{{ $class->schedule ?? '—' }}</td>
                        <td class="hidden lg:table-cell px-3 py-3 text-gray-600 text-xs">{{ $class->room ?? '—' }}</td>
                        <td class="px-3 py-3">
                            <div class="flex items-center gap-1">
                                <svg class="h-3 w-3 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <span class="text-xs font-medium text-gray-700">{{ $class->students->count() }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-3">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-bold
                                {{ $class->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                <span class="mr-1 h-1 w-1 rounded-full {{ $class->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $class->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-right">
                            <div class="flex flex-col sm:flex-row gap-1 sm:gap-1 justify-end">
                                <button wire:click="editClass({{ $class->id }})" type="button"
                                        class="rounded-lg px-2 py-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors whitespace-nowrap">
                                    Edit
                                </button>
                                <button wire:click="toggleClassStatus({{ $class->id }})" type="button"
                                        class="rounded-lg px-2 py-1 text-[10px] font-bold {{ $class->is_active ? 'text-amber-600 bg-amber-50 hover:bg-amber-100' : 'text-emerald-600 bg-emerald-50 hover:bg-emerald-100' }} transition-colors whitespace-nowrap">
                                    {{ $class->is_active ? 'Deact' : 'Act' }}
                                </button>
                                <button wire:click="deleteClass({{ $class->id }})" type="button"
                                        class="rounded-lg px-2 py-1 text-[10px] font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-colors whitespace-nowrap">
                                    Del
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($classes->hasPages())
            <div class="border-t border-gray-100 px-3 py-3 bg-gray-50">
                {{ $classes->links() }}
            </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-12 text-center px-4">
            <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <p class="text-sm font-bold text-gray-700">No classes found</p>
            <p class="mt-1 text-xs text-gray-400">Try adjusting your search or add a new class.</p>
        </div>
    @endif
</div>

{{-- ============================================================
     MODAL — single overlay, inside the root div
     ============================================================ --}}
@if($showModal)
<div class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4" style="background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);">

    {{-- Panel --}}
    <div class="relative w-full max-w-2xl max-h-[95vh] rounded-xl sm:rounded-2xl bg-white shadow-2xl ring-1 ring-gray-200 overflow-hidden"
         x-data x-on:click.stop>

        {{-- Modal Header --}}
        <div class="flex items-center justify-between border-b border-gray-100 bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-3 sm:px-6 sm:py-5">
            <div class="flex items-center gap-2 sm:gap-3">
                <div class="flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-lg sm:rounded-xl bg-white/20">
                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($isEditing)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        @endif
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm sm:text-base font-bold text-white">{{ $isEditing ? 'Edit Class' : 'Add New Class' }}</h3>
                    <p class="text-[10px] sm:text-xs text-indigo-200">{{ $isEditing ? 'Update the class details below.' : 'Fill in the details to add a new class.' }}</p>
                </div>
            </div>
            <button wire:click="closeModal" type="button"
                    class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg text-white/70 hover:text-white hover:bg-white/20 transition-colors">
                <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <form wire:submit.prevent="saveClass">
            <div class="max-h-[60vh] sm:max-h-[70vh] overflow-y-auto p-3 sm:p-6">
                <div class="grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2">

                    {{-- Class Name --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Class Name <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="name" placeholder="e.g. Advanced Mathematics"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Class Code --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Class Code <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="code" placeholder="e.g. MATH301"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Teacher --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Teacher <span class="text-red-500">*</span></label>
                        <select wire:model="teacher_id"
                                class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->first_name }} {{ $teacher->last_name }} - {{ $teacher->department }}</option>
                            @endforeach
                        </select>
                        @error('teacher_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Schedule --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Schedule</label>
                        <input type="text" wire:model="schedule" placeholder="e.g. Mon, Wed, Fri - 9:00 AM"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('schedule') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Room --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Room</label>
                        <input type="text" wire:model="room" placeholder="e.g. Room 101"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('room') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Description</label>
                        <textarea wire:model="description" placeholder="Enter class description"
                                  class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition" rows="3"></textarea>
                        @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Student Selection --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Select Students</label>
                        
                        {{-- Select All / Clear All --}}
                        <div class="mb-3 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" 
                                       wire:click="toggleSelectAll"
                                       wire:model.live="selectAll"
                                       class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                <span class="text-xs sm:text-sm font-medium text-gray-700">
                                    {{ $this->selectAll ? 'Clear All' : 'Select All' }} Students
                                </span>
                            </label>
                            @if($selected_students && count($selected_students) > 0)
                                <span class="text-xs text-gray-500 sm:ml-auto">
                                    {{ count($selected_students) }} of {{ $students->count() }} selected
                                </span>
                            @endif
                        </div>
                        
                        <div class="max-h-40 sm:max-h-48 overflow-y-auto border border-gray-300 rounded-lg sm:rounded-xl bg-white shadow-sm">
                            @if($students->count() > 0)
                                <div class="p-2 sm:p-3 space-y-1 sm:space-y-2">
                                    @foreach($students as $student)
                                        <label class="flex items-center gap-2 sm:gap-3 p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="checkbox" 
                                                   wire:model="selected_students" 
                                                   value="{{ $student->id }}"
                                                   class="h-3 w-3 sm:h-4 sm:w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">{{ $student->full_name }}</p>
                                                <p class="text-[10px] sm:text-xs text-gray-500 truncate">{{ $student->baptismal_name }} • {{ $student->phone_number }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-4 sm:p-6 text-center text-gray-500">
                                    <svg class="h-6 w-6 sm:h-8 sm:w-8 mx-auto mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <p class="text-xs sm:text-sm">No active students available</p>
                                </div>
                            @endif
                        </div>
                        @error('selected_students') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Active checkbox --}}
                    <div class="sm:col-span-2">
                        <label class="inline-flex items-center gap-2 sm:gap-3 cursor-pointer select-none group">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_active" class="sr-only peer">
                                <div class="w-8 h-5 sm:w-10 sm:h-6 rounded-full bg-gray-200 peer-checked:bg-indigo-600 transition-colors shadow-inner"></div>
                                <div class="absolute top-0.5 left-0.5 h-4 w-4 sm:h-5 sm:w-5 rounded-full bg-white shadow peer-checked:translate-x-3 sm:peer-checked:translate-x-4 transition-transform"></div>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm font-semibold text-gray-700">Active Class</p>
                                <p class="text-[10px] sm:text-xs text-gray-400">Inactive classes won't appear in attendance lists</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 border-t border-gray-100 bg-gray-50 px-4 py-3 sm:px-6 sm:py-4">
                <button wire:click="closeModal" type="button"
                        class="w-full sm:w-auto rounded-lg px-4 py-2.5 text-xs sm:text-sm font-bold text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button type="submit"
                        class="w-full sm:w-auto rounded-lg px-4 py-2.5 text-xs sm:text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ $isEditing ? 'Update Class' : 'Create Class' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endif

</div>
