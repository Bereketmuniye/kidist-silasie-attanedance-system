
<div>
{{-- Page Header --}}
<div class="mb-4 flex flex-col gap-3">
    <div>
        <h1 class="text-xl font-bold text-gray-900">የተማሪዎች አስተዳደር</h1>
        <p class="mt-1 text-xs text-gray-500">የተማሪዎችን መረጃ ይጨምሩ፣ ያስተካክሉ እና ያስተዳዱ።</p>
    </div>
    <button wire:click="createStudent" type="button"
            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        ተማሪ ይጨምሩ
    </button>
</div>

{{-- Filters --}}
<div class="mb-4 rounded-xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
    <div class="relative">
        <svg class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" wire:model.live="search" placeholder="ስም፣ የክርስትና ስም፣ ስልክ ቁጥር..."
               class="w-full rounded-lg border border-gray-200 bg-gray-50 pl-9 pr-3 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
    </div>
</div>

{{-- Students Table --}}
<div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-200 overflow-hidden">
    @if($students->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-xs sm:text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ተማሪ</th>
                        <th class="hidden sm:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">የክርስትና ስም</th>
                        <th class="hidden md:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ስልክ ቁጥር</th>
                        <th class="hidden lg:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">አድራሻ</th>
                        <th class="hidden xl:table-cell px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">የጋራ ንስሐ አባት</th>
                        <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ሁኔታ</th>
                        <th class="px-3 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">ተግባራት</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($students as $student)
                    <tr class="hover:bg-indigo-50/30 transition-colors">
                        <td class="px-3 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="h-6 w-6 sm:h-8 sm:w-8 shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] sm:text-xs font-bold text-indigo-700 border border-indigo-200">
                                    {{ substr($student->full_name,0,1) }}{{ substr($student->full_name, strpos($student->full_name, ' ') + 1, 1) ?? '' }}
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 text-xs sm:text-sm truncate">{{ $student->full_name }}</p>
                                    <div class="sm:hidden space-y-1 mt-1">
                                        @if($student->baptismal_name)
                                            <p class="text-[10px] text-gray-500">
                                                <span class="font-medium">የክርስትና:</span> {{ $student->baptismal_name }}
                                            </p>
                                        @endif
                                        @if($student->phone_number)
                                            <p class="text-[10px] text-gray-500">
                                                <span class="font-medium">ስልክ:</span> {{ $student->phone_number }}
                                            </p>
                                        @endif
                                        @if($student->address)
                                            <p class="text-[10px] text-gray-500">
                                                <span class="font-medium">አድራሻ:</span> {{ Str::limit($student->address, 30) }}
                                            </p>
                                        @endif
                                        @if($student->common_confessor_father)
                                            <p class="text-[10px] text-gray-500">
                                                <span class="font-medium">ንስሐ አባት:</span> {{ $student->common_confessor_father }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="hidden sm:table-cell px-3 py-3 whitespace-nowrap text-gray-600 text-xs sm:text-sm">{{ $student->baptismal_name ?? '—' }}</td>
                        <td class="hidden md:table-cell px-3 py-3 whitespace-nowrap text-gray-600 text-xs sm:text-sm">{{ $student->phone_number ?? '—' }}</td>
                        <td class="hidden lg:table-cell px-3 py-3 whitespace-nowrap text-gray-600 text-xs sm:text-sm truncate" title="{{ $student->address ?? '—' }}">{{ Str::limit($student->address ?? '—', 20) }}</td>
                        <td class="hidden xl:table-cell px-3 py-3 whitespace-nowrap text-gray-600 text-xs sm:text-sm truncate" title="{{ $student->common_confessor_father ?? '—' }}">{{ Str::limit($student->common_confessor_father ?? '—', 15) }}</td>
                        <td class="px-3 py-3 whitespace-nowrap">
                            <span class="inline-flex items-center rounded-full px-2 py-1 text-[10px] font-bold
                                {{ $student->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                <span class="mr-1 h-1 w-1 rounded-full {{ $student->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $student->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-3 py-3 whitespace-nowrap text-right">
                            <div class="flex flex-col sm:flex-row gap-1 sm:gap-1">
                                <button wire:click="editStudent({{ $student->id }})" type="button"
                                        class="rounded-lg px-2 py-1 text-[10px] font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                                    Edit
                                </button>
                                <button wire:click="toggleStudentStatus({{ $student->id }})" type="button"
                                        class="rounded-lg px-2 py-1 text-[10px] font-bold {{ $student->is_active ? 'text-amber-600 bg-amber-50 hover:bg-amber-100' : 'text-emerald-600 bg-emerald-50 hover:bg-emerald-100' }} transition-colors">
                                    {{ $student->is_active ? 'Deact' : 'Act' }}
                                </button>
                                <button wire:click="deleteStudent({{ $student->id }})" type="button"
                                        class="rounded-lg px-2 py-1 text-[10px] font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                                    Del
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="border-t border-gray-100 px-3 py-3 bg-gray-50">
                {{ $students->links() }}
            </div>
        @endif
    @else
        <div class="flex flex-col items-center justify-center py-12 text-center px-4">
            <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center mx-auto mb-4">
                <svg class="h-6 w-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <p class="text-sm font-bold text-gray-700">No students found</p>
            <p class="mt-1 text-xs text-gray-400">Try adjusting your search or add a new student.</p>
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
                    <h3 class="text-sm sm:text-base font-bold text-white">{{ $isEditing ? 'Edit Student' : 'Add New Student' }}</h3>
                    <p class="text-[10px] sm:text-xs text-indigo-200">{{ $isEditing ? 'Update the student details below.' : 'Fill in the details to add a new student.' }}</p>
                </div>
<div class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);">

    {{-- Panel --}}
    <div class="relative w-full max-w-2xl rounded-2xl bg-white shadow-2xl ring-1 ring-gray-200 overflow-hidden"
         x-data x-on:click.stop>

        {{-- Modal Header --}}
        <div class="flex items-center justify-between border-b border-gray-100 bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/20">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($isEditing)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        @endif
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">{{ $isEditing ? 'Edit Student' : 'Add New Student' }}</h3>
                    <p class="text-xs text-indigo-200">{{ $isEditing ? 'Update the student record below.' : 'Fill in the details to add a new student.' }}</p>
                </div>
            </div>
            <button wire:click="closeModal" type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg text-white/70 hover:text-white hover:bg-white/20 transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <form wire:submit.prevent="saveStudent">
            <div class="max-h-[60vh] sm:max-h-[70vh] overflow-y-auto p-3 sm:p-6">
                <div class="grid grid-cols-1 gap-4 sm:gap-5 sm:grid-cols-2">

                    {{-- Full Name --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="full_name" placeholder="e.g. Abebe Kebede"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Baptismal Name --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Baptismal Name <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="baptismal_name" placeholder="e.g. Michael"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('baptismal_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone Number --}}
                    <div>
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Phone Number <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="phone_number" placeholder="e.g. +251 911 234 567"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('phone_number') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Address <span class="text-red-500">*</span></label>
                        <textarea wire:model="address" placeholder="Enter student address"
                                  class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition" rows="3"></textarea>
                        @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Common Confessor Father --}}
                    <div class="sm:col-span-2">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5">Common Confessor Father <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="common_confessor_father" placeholder="e.g. Father Samuel"
                               class="w-full rounded-lg sm:rounded-xl border border-gray-300 bg-white px-3 py-2.5 sm:px-4 sm:py-3 text-sm text-gray-800 placeholder-gray-400 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 transition">
                        @error('common_confessor_father') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
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
                                <p class="text-xs sm:text-sm font-semibold text-gray-700">Active Student</p>
                                <p class="text-[10px] sm:text-xs text-gray-400">Inactive students won't appear in attendance lists.</p>
                            </div>
                        </label>
                    </div>

                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-2 sm:gap-3 border-t border-gray-100 bg-gray-50 px-4 py-3 sm:px-6 sm:py-4">
                <button type="button" wire:click="closeModal"
                        class="w-full sm:w-auto rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-xs sm:text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    Cancel
                </button>
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-md shadow-indigo-500/30 hover:bg-indigo-700 transition-all">
                    <svg class="h-3 w-3 sm:h-4 sm:w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $isEditing ? 'Update Student' : 'Add Student' }}
                </button>
            </div>
        </form>
    </div>
@endif
