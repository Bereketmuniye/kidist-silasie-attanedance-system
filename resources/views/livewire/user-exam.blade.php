@section('title', 'ፈተና')

<div>
    @if(!$exam)
        <div class="min-h-screen flex items-center justify-center bg-gray-50">
            <div class="text-center">
                <h3 class="mt-2 text-lg font-medium text-gray-900">ፈተናው አልተገኘም።</h3>
                <p class="mt-1 text-sm text-gray-500">እባክዎ ዳግም ይሞክሩ።</p>
                <div class="mt-6">
                    <a href="{{ route('exams.list') }}"
                       class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        ወደ ፈተናዎች ዝርዝር ተመለስ
                    </a>
                </div>
            </div>
        </div>

    @elseif(!$examStarted && !$examCompleted)
        {{-- Start Screen --}}
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4">
            <div class="max-w-md w-full space-y-8">

                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $exam->title }}</h2>
                    @if($exam->description)
                        <p class="mt-2 text-sm text-gray-600">{{ $exam->description }}</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">

                    <div class="space-y-4">
                        <div class="flex justify-between border-b pb-2">
                            <span>የጥያቄዎች ብዛት</span>
                            <span>{{ $questions->count() }}</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span>የፈተና ጊዜ</span>
                            <span>{{ $exam->duration_minutes }} ደቂቃ</span>
                        </div>

                        <div class="flex justify-between border-b pb-2">
                            <span>ጠቅላላ ነጥብ</span>
                            <span>{{ $questions->sum('points') }}</span>
                        </div>
                    </div>

                    <form wire:submit="startExam" class="mt-6 space-y-4">

                        <div>
                            <label class="block text-sm">ሙሉ ስምዎ *</label>
                            <input type="text" wire:model="studentName" required
                                   class="w-full border rounded-lg px-3 py-2"
                                   placeholder="እባክዎ ሙሉ ስምዎን ያስገቡ">
                        </div>

                        <div>
                            <label class="block text-sm">ስልክ ቁጥርዎ *</label>
                            <input type="text" wire:model="studentPhone" required
                                   class="w-full border rounded-lg px-3 py-2"
                                   placeholder="እባክዎ ስልክ ቁጥርዎን ያስገቡ">
                        </div>

                        {{-- Warning --}}
                        <div class="bg-yellow-50 border p-4 rounded-lg text-sm">
                            <ul class="list-disc space-y-1 ml-4">
                                <li>ፈተናውን ከጀመሩ በኋላ መቆም አይቻልም</li>
                                <li>የተወሰነው ጊዜ ሲያበቃ በራስ-ሰር ይጠናቀቃል</li>
                                <li>ሁሉንም ጥያቄዎች መመልስ ያስፈልጋል</li>
                            </ul>
                        </div>

                        <button type="submit"
                                class="w-full bg-indigo-600 text-white py-3 rounded-lg hover:bg-indigo-700">
                            ፈተናውን ጀምር
                        </button>

                    </form>
                </div>
            </div>
        </div>

    @elseif($examStarted && !$examCompleted)

        {{-- Exam --}}
        <div class="min-h-screen bg-gray-50">

            {{-- Header --}}
            <div class="bg-white shadow-sm p-4 flex justify-between">
                <div>
                    <h1 class="font-semibold">{{ $exam->title }}</h1>
                    <p class="text-sm text-gray-500">{{ $studentName }}</p>
                </div>

                <div class="text-sm">
                    ⏱ <span id="timer-time">{{ $timeRemaining / 60 }}:{{ sprintf('%02d', $timeRemaining % 60) }}</span>
                </div>
            </div>

            {{-- Question --}}
            <div class="max-w-3xl mx-auto p-6">

                @if(isset($questions[$currentQuestionIndex]))
                    <div class="bg-white p-6 rounded-xl shadow">

                        <p class="text-sm text-indigo-600 mb-2">
                            ጥያቄ {{ $currentQuestionIndex + 1 }} / {{ $questions->count() }}
                        </p>

                        <h3 class="mb-4">
                            {{ $questions[$currentQuestionIndex]->question }}
                        </h3>

                        <div class="space-y-3">
                            @foreach(['A','B','C','D'] as $opt)
                                <button wire:click="selectAnswer('{{ $opt }}')"
                                        class="w-full text-left border p-3 rounded-lg
                                        {{ ($answers[$currentQuestionIndex] ?? null) === $opt ? 'bg-indigo-100 border-indigo-500' : '' }}">
                                    {{ $opt }}.
                                    {{ $questions[$currentQuestionIndex]['option_'.strtolower($opt)] }}
                                </button>
                            @endforeach
                        </div>

                        <div class="flex justify-between mt-6">
                            <button wire:click="previousQuestion"
                                    class="px-4 py-2 bg-gray-200 rounded">
                                ← ወደ ቀድሞ
                            </button>

                            <button wire:click="nextQuestion"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded">
                                {{ $currentQuestionIndex == $questions->count()-1 ? 'ፈተናውን ጨርስ' : 'ቀጣይ →' }}
                            </button>
                        </div>

                    </div>
                @endif

            </div>
        </div>

    @elseif($examCompleted && $showResult)

        {{-- Result --}}
        <div class="min-h-screen flex items-center justify-center bg-gray-50">
            <div class="bg-white p-6 rounded-xl shadow max-w-md w-full text-center">

                <h2 class="text-2xl font-bold">ፈተናው ተጠናቀቀ!</h2>
                <p class="text-gray-600">{{ $studentName }}</p>

                <div class="mt-6 space-y-3 text-left">

                    <div class="flex justify-between">
                        <span>ትክክለኛ መልሶች</span>
                        <span>{{ $examResult->correct_answers }} / {{ $examResult->total_questions }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>ያገኙት ነጥብ</span>
                        <span>{{ $examResult->score }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>መቶኛ</span>
                        <span>{{ $examResult->percentage }}%</span>
                    </div>

                    <div class="flex justify-between">
                        <span>የጨረሱበት ጊዜ</span>
                        <span>{{ $examResult->completed_at->format('H:i') }}</span>
                    </div>

                </div>

                <div class="mt-6">
                    <span class="px-3 py-1 rounded-full text-sm
                        {{ $examResult->percentage >= 60 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $examResult->percentage >= 60 ? 'አልፈዋል!' : 'እንደገና ይሞክሩ!' }}
                    </span>
                </div>

                <button wire:click="backToExams"
                        class="mt-6 w-full border py-2 rounded">
                    ወደ ፈተናዎች ተመለስ
                </button>

            </div>
        </div>

    @endif
</div>

{{-- Timer --}}
@if($examStarted && !$examCompleted)
<script>
let time = {{ $timeRemaining }};
let el = document.getElementById('timer-time');

setInterval(() => {
    if (time > 0) {
        time--;
        let m = Math.floor(time / 60);
        let s = time % 60;
        el.textContent = m + ':' + (s < 10 ? '0' : '') + s;
    } else {
        location.reload();
    }
}, 1000);
</script>
@endif