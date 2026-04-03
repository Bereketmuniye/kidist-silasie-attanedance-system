<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ምዝገብዎ ተሳክተባ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Noto Sans Ethiopic', sans-serif;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .success-checkmark {
            animation: scaleIn 0.5s ease-in-out;
        }
        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 sm:py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 sm:space-x-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm sm:text-xl font-bold text-gray-900">በስመአብ ወወልድ ወመንፈስ ቅዱስ አሐዱ አምላክ አሜን፡፡</h1>
                        <p class="text-xs sm:text-sm text-gray-600">የቅድመ ጋብቻ ትምህርት ምዝገብያ</p>
                    </div>
                </div>
                <a href="{{ route('student.register') }}" class="text-green-600 hover:text-green-800 text-xs sm:text-sm font-medium">
                    እንደገና ለመመዝገብ
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success Card -->
        <div class="glass-effect rounded-2xl p-8 shadow-xl text-center">
            <!-- Success Icon -->
            <div class="success-animation w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-8">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Success Message -->
            <h2 class="text-3xl font-bold text-gray-900 mb-4">ምዝገባዎ በተሳካ ሁኔታ ተጠናቋል!</h2>
            
            @if(session('student_name'))
                <p class="text-xl text-gray-700 mb-6">
                  {{ session('student_name') }}፣
                </p>
            @endif
            
            <p class="text-lg text-gray-700 mb-8">
                በቅድመ ጋብቻ ትምህርት ላይ መሳተፍዎን እናመሰግናለን።
            </p>

            <!-- Important Information -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">አስፈላጊ መረጃ</h3>
                <div class="space-y-3 text-gray-700">
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p>
                            ቦታ:- ጎ/መ/ቅዱስ ገብርኤል ካ/ሰ/ት/ት ራእየ ቴዎፍሎስ (አዲሱ ህንጻ)
                        </p>
                    </div>
                    <div class="flex items-start space-x-2">
                        <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-3A3 3 0 0014 12V4a3 3 0 00-3-3H7a3 3 0 00-3 3v8a3 3 0 003 3h4z"></path>
                        </svg>
                        <p>
                            የትምህርቱ የሚጀምርበት ቀን:- መጋቢት 27/2018 ዓ/ም
                        </p>
                    </div>
                </div>
            </div>

  

            <!-- Course Details -->
            <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-xl p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">የትምህርቱ ዝርዝል መረጃ</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-800 mb-3">የትምህርቱ ዓላማ</h4>
                        <p class="text-gray-600">
                            የቅድመ ጋብቻ እና ድኅረ ጋብቻ ሕይወት ለመረዳት
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">ለተጨማሪ መረጃ</h3>
                <div class="text-gray-700 space-y-2">
                    <p>ስልክ፡ +251-XXX-XXX-XXX</p>
                    <p>ኢሜይል፡ info@kidistsilasie.org</p>
                    <p>አድራሻ፡ ጎ/መ/ቅዱስ ገብርኤል ካ/ሰ/ት/ት</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('exams.list') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    ፈተናዎች ይውሰን
                </a>
                
                <a href="{{ route('teacher.login') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    ወደ መገቢያ ይመለሱ
                </a>
                
                <a href="{{ route('student.register') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    አዲስ መመዝገብያ
                </a>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-8 text-center text-gray-600 text-sm">
            <p class="mt-2">&copy; 2024 በስመአብ ወወልድ ወመንፈስ ቅዱስ አሐዱ አምላክ አሜን። ሁሉም መብቶች የተጠበቁ ናቸው።</p>
        </div>
    </main>
</body>
</html>
