<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ፈተናዎች</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Noto Sans Ethiopic', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">

<!-- Header -->
<header class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                </svg>
            </div>

            <div>
                <h1 class="text-lg font-bold text-gray-900">
                    በስመአብ ወወልድ ወመንፈስ ቅዱስ አሐዱ አምላክ አሜን
                </h1>
                <p class="text-sm text-gray-600">
                    የቅድመ ጋብቻ ትምህርት ፈተናዎች
                </p>
            </div>
        </div>

        <a href="{{ route('teacher.login') }}"
           class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            ወደ አስተዳደር ግባ
        </a>

    </div>
</header>

<!-- Main -->
<main class="max-w-7xl mx-auto px-4 py-12">

    <!-- Title -->
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">
            የተማሪ ፈተናዎች
        </h2>

        <p class="text-gray-600 max-w-2xl mx-auto">
            ከሚገኙት ፈተናዎች አንዱን ይምረጡ እና ዕውቀታችሁን ይፈትኑ።
        </p>
    </div>

    <!-- Exams -->
    @if($exams->count() > 0)

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($exams as $exam)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                    <!-- Top -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 text-white">

                        <div class="flex justify-between mb-3">
                            <span class="text-sm bg-white/20 px-3 py-1 rounded-full">
                                {{ $exam->questions->count() }} ጥያቄ
                            </span>
                        </div>

                        <h3 class="text-xl font-bold mb-2">
                            {{ $exam->title }}
                        </h3>

                        @if($exam->description)
                            <p class="text-sm text-white/80">
                                {{ $exam->description }}
                            </p>
                        @endif

                    </div>

                    <!-- Details -->
                    <div class="p-6 space-y-3">

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">የፈተና ጊዜ</span>
                            <span>{{ $exam->duration_minutes }} ደቂቃ</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">ጠቅላላ ነጥብ</span>
                            <span>{{ $exam->questions->sum('points') }}</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">የወሰዱት</span>
                            <span>{{ $exam->results->count() }} ሰዎች</span>
                        </div>

                        <a href="{{ route('exams.take', $exam->id) }}"
                           class="block text-center mt-4 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            ፈተናውን ጀምር
                        </a>

                    </div>
                </div>
            @endforeach

        </div>

    @else

        <!-- Empty -->
        <div class="text-center py-16">
            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                አሁን ምንም ፈተና የለም
            </h3>
            <p class="text-gray-600 mb-6">
                እባክዎ በኋላ እንደገና ይመልከቱ።
            </p>

            <a href="{{ route('teacher.login') }}"
               class="px-6 py-3 bg-indigo-600 text-white rounded-lg">
                ወደ አስተዳደር ግባ
            </a>
        </div>

    @endif


    <!-- Instructions -->
    <div class="mt-16 bg-white p-8 rounded-xl shadow">

        <h3 class="text-2xl font-bold text-center mb-8">
            መመሪያ
        </h3>

        <div class="grid md:grid-cols-2 gap-6 text-sm">

            <div>
                <h4 class="font-semibold mb-1">1. ፈተና ይምረጡ</h4>
                <p class="text-gray-600">ከሚገኙት ፈተናዎች አንዱን ይምረጡ።</p>
            </div>

            <div>
                <h4 class="font-semibold mb-1">2. መረጃ ያስገቡ</h4>
                <p class="text-gray-600">ሙሉ ስምዎን ያስገቡ።</p>
            </div>

            <div>
                <h4 class="font-semibold mb-1">3. ፈተናውን ይውሰኑ</h4>
                <p class="text-gray-600">ጥያቄዎችን በትክክል መልስ ይምረጡ።</p>
            </div>

            <div>
                <h4 class="font-semibold mb-1">4. ውጤት ይመልከቱ</h4>
                <p class="text-gray-600">ፈተናው ከጨረሰ በኋላ ውጤትዎን ያዩ።</p>
            </div>

        </div>

    </div>

</main>

<!-- Footer -->
<footer class="bg-gray-50 border-t mt-16 py-6 text-center text-sm text-gray-500">
    © 2024 ሁሉም መብቶች የተጠበቁ ናቸው።
</footer>

</body>
</html>