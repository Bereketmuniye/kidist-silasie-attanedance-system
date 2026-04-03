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
    <header class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm sm:text-xl font-bold text-gray-900">በስመአብ ወወልድ ወመንፈስ ቅዱስ አሐዱ አምላክ አሜን፡፡</h1>
                        <p class="text-xs sm:text-sm text-gray-600">የቅድመ ጋብቻ ትምህርት ፈተናዎች</p>
                    </div>
                </div>
                <a href="{{ route('teacher.login') }}" class="text-indigo-600 hover:text-indigo-800 text-xs sm:text-sm font-medium">
                    ወደ አስተዳደር ይመለሱ
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">የተማማሪ ፈተናዎች</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                የቅድመ ጋብቻ ትምህርት ፈተናዎችን ይውሰኑና ዕውቀታችሁን ይሞክሩ።
            </p>
        </div>

        <!-- Exams Grid -->
        @if($exams->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($exams as $exam)
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                        <!-- Exam Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium text-white bg-white/20">
                                    {{ $exam->questions->count() }} ጥያቄዎች
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">{{ $exam->title }}</h3>
                            @if($exam->description)
                                <p class="text-white/80 text-sm">{{ $exam->description }}</p>
                            @endif
                        </div>

                        <!-- Exam Details -->
                        <div class="p-6">
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">ከመጠን</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $exam->duration_minutes }} ደቂቃ</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">ጠቅላላ ነጥብ</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $exam->questions->sum('points') }} ነጥብ</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-500">የተወሰዱ</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $exam->results->count() }} ተማማሪዎች</span>
                                </div>
                            </div>

                            <!-- Start Exam Button -->
                            <a href="{{ route('exams.take', $exam->id) }}" 
                               class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                ፈተናውን ይጀምሩ
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- No Exams Available -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">ምንም ፈተናዎች የሉም</h3>
                <p class="text-gray-600 mb-8">አሁን የተሰናዳኩ ፈተናዎች የሉም። እባክዎ በኋላ እንደገና ይመልከቱ።</p>
                <a href="{{ route('teacher.login') }}" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    ወደ አስተዳደር ይመለሱ
                </a>
            </div>
        @endif

        <!-- Instructions Section -->
        <div class="mt-16 bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">እንዴት ፈተና እንደምታለፍ</h3>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold text-sm">1</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">ፈተናውን ይምረጡ</h4>
                            <p class="text-gray-600 text-sm">ከምንም ፈተና ይምረጡ እና የፈተናውን ዝርዝር መረጃ ያግኙ።</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold text-sm">2</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">ይመዝገቡ</h4>
                            <p class="text-gray-600 text-sm">ሙሉ ስምዎን ይግቡ፣ ስልክ ቁጥር አማራጭ ነው።</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold text-sm">3</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">ፈተናውን ይውሰኑ</h4>
                            <p class="text-gray-600 text-sm">እያንዳንዱ ጥያቄ በትክክል መልስ ይምረጡና የተወሰኑትን ይገልጽ።</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold text-sm">4</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">ውጤትዎን ያግኙ</h4>
                            <p class="text-gray-600 text-sm">ፈተናው ሲያልቅ ውጤትዎን በስልጠናዊ መልክ ይያግኑ።</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; 2024 በስመአብ ወወልድ ወመንፈስ ቅዱስ አሐዱ አምላክ አሜን። ሁሉም መብቶች የተጠበቁ ናቸው።</p>
            </div>
        </div>
    </footer>
</body>
</html>
