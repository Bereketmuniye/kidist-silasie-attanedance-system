<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>የቅድመ ጋብቻ ትምህርት መመዝገብያ</title>
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
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .checkbox-custom {
            transition: all 0.2s ease;
        }
        .checkbox-custom:checked {
            transform: scale(1.1);
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm sm:text-xl font-bold text-gray-900">በስመአብ ወወልድ ወመንፈስ ቅዱስ አሐዱ አምላክ አሜን፡፡</h1>
                        <p class="text-xs sm:text-sm text-gray-600">የቅድመ ጋብቻ ትምህርት መመዝገብያ</p>
                    </div>
                </div>
                <a href="{{ route('teacher.login') }}" class="text-indigo-600 hover:text-indigo-800 text-xs sm:text-sm font-medium">
                    ወደ መገቢያ ይመለሱ
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="px-4 sm:px-6 lg:px-8 py-6 sm:py-12">
        <!-- Introduction Card -->
        <div class="glass-effect rounded-2xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 shadow-xl">
            <div class="text-center mb-6 sm:mb-8">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3 sm:mb-4">የቅድመ ጋብቻ ትምህርት መመዝገብያ</h2>
                <div class="max-w-3xl mx-auto text-gray-700 space-y-3 sm:space-y-4">
                    <p class="text-base sm:text-lg leading-relaxed">
                        "ሰው ብቻውን ይሆን ዘንድ መልካም አይደለምና የሚመቸውን እረዳት እንፍጠርለት" (ዘፍ 2 : 21)
                    </p>
                    <p class="text-sm sm:text-base">
                        በኢ/ኦ/ተ/ቤ/ክ የጎ/መ/ሕ/ቅዱስ ገብርኤል ካ/ሰ/ት/ት በትምህርትና ሥልጠና ክፍል የተዘጋጀ 
                        የቅድመ ጋብቻ ትምህርት ፈላጊዎችን ለመመዝገብ የተዘጋጀ ቅጽ
                    </p>
                </div>
            </div>

            <!-- Course Information -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8">
                <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">የትምህርቱ መረጃ</h3>
                <div class="grid md:grid-cols-2 gap-3 sm:gap-4">
                    <div>
                        <span class="font-medium text-gray-700 text-sm sm:text-base">የትምህርቱ ዓላማ:</span>
                        <p class="text-gray-600 text-xs sm:text-sm mt-1">
                            በእጮኝነት ሕይወት ውስጥ ላሉ እህት ወንድሞች ወደፊት ሊኖሯቸው ስለሚችል የቅድመ ጋብቻ እና ድኅረ ጋብቻ ግንዛቤ መፍጠር
                        </p>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700 text-sm sm:text-base">የትምህርቱ ዘወትር:</span>
                        <p class="text-gray-600 text-xs sm:text-sm mt-1">
                            እሑድ ከ 8-10 ሰዓት<br>
                            የሚጀምረው:- መጋቢት 27/2018 ዓ/ም
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <span class="font-medium text-gray-700 text-sm sm:text-base">ቦታ:</span>
                        <p class="text-gray-600 text-xs sm:text-sm mt-1">
                            ጎ/መ/ቅዱስ ገብርኤል ካ/ሰ/ት/ት ራእየ ቴዎፍሎስ (አዲሱ ህንጻ)
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="glass-effect rounded-2xl p-4 sm:p-6 lg:p-8 shadow-xl">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">የመመዝገብያ ቅጽ</h3>
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-3 sm:px-4 py-3 rounded-lg mb-4 sm:mb-6">
                    <div class="flex items-start space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 001.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p class="text-xs sm:text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-3 sm:px-4 py-3 rounded-lg mb-4 sm:mb-6">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 001.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-xs sm:text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('student.register.submit') }}" class="space-y-6">
                @csrf
                
                <!-- Male Information Section -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6">
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>የወንዱ መረጃ</span>
                    </h4>
                    
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                የወንዱ ሙሉ ስም
                            </label>
                            <input type="text" id="full_name" name="full_name"
                                   class="form-input w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                                   placeholder="ሙሉ ስምዎን ያስገቡ" value="{{ old('full_name') }}">
                        </div>
                        
                        <div>
                            <label for="baptismal_name" class="block text-sm font-medium text-gray-700 mb-2">
                                የክርስትና ስም
                            </label>
                            <input type="text" id="baptismal_name" name="baptismal_name"
                                   class="form-input w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                                   placeholder="የክርስትና ስምዎን ያስገቡ" value="{{ old('baptismal_name') }}">
                        </div>
                    </div>
                </div>

                <!-- Female Information Section -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6">
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>የሴቷ መረጃ</span>
                    </h4>
                    
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="partner_full_name" class="block text-sm font-medium text-gray-700 mb-2">
                                የሴቷ ሙሉ ስም
                            </label>
                            <input type="text" id="partner_full_name" name="partner_full_name"
                                   class="form-input w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                                   placeholder="የሴቷ ሙሉ ስም ያስገቡ" value="{{ old('partner_full_name') }}">
                        </div>
                        
                        <div>
                            <label for="partner_baptismal_name" class="block text-sm font-medium text-gray-700 mb-2">
                                የሴቷ የክርስትና ስም
                            </label>
                            <input type="text" id="partner_baptismal_name" name="partner_baptismal_name"
                                   class="form-input w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                                   placeholder="የሴቷ የክርስትና ስም ያስገቡ" value="{{ old('partner_baptismal_name') }}">
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6">
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>የእውቂያ መረጃ</span>
                    </h4>
                    
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                                ስልክ <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="phone_number" name="phone_number" required
                                   class="form-input w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                                   placeholder="+251 9X XXX XXXX" value="{{ old('phone_number') }}">
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                የመኖርያ አድራሻ <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3" required
                                      class="form-input w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                                      placeholder="ሙሉ አድራሻዎን ያስገቡ">{{ old('address') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Spiritual Information -->
                <div class="bg-gray-50 rounded-xl p-4 sm:p-6">
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4 flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        <span>የመንፈሳዊ መረጃ</span>
                    </h4>
                    
                    <div>
                        <label for="common_confessor_father" class="block text-sm font-medium text-gray-700 mb-2">
                            የጋራ ንስሐ አባት አለዎት?
                        </label>
                        <input type="text" id="common_confessor_father" name="common_confessor_father"
                               class="form-input w-full px-3 sm:px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base"
                               placeholder="አዎ ከሆነ የንስሐ አባትዎን ያስገቡ" value="{{ old('common_confessor_father') }}">
                    </div>
                </div>

                <!-- Agreement Section -->
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-4 sm:p-6">
                    <h4 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">ማሳሰብያ</h4>
                    <div class="bg-white rounded-lg p-3 sm:p-4 mb-4">
                        <p class="text-gray-700 mb-3 text-sm sm:text-base">
                            ይኅን የቅድመ ጋብቻ ትምህርት ለመማር ምዝገባው የምታከናውኑ እህት ወንድሞች ከእጮኛቹ ጋር በአካል አብሮ በመገኝት የምትወስዱት ትምህርት እንዲሁም ስልጠና በመሆኑ የሁለታችሁ መገኘት የግድ ይላል::
                        </p>
                        <p class="text-gray-600 text-xs sm:text-sm italic">
                            ማሳሰብያ ፡-ይኅን የቅድመ ጋብቻ ትምህርት ለመማር ምዝገባው የምታከናውኑ እህት ወንድሞች ከእጮኛቹ ጋር በአካል አብሮ በመገኝት የምትወስዱት ትምህርት እንዲሁም ስልጠና በመሆኑ የሁለታችሁ መገኘት የግድ ይላል::
                        </p>
                    </div>
                    
                    <div class="flex items-start space-x-3">
                        <input type="checkbox" id="agreement" name="agreement" value="1" required
                               class="checkbox-custom mt-1 h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="agreement" class="text-xs sm:text-sm text-gray-700">
                            የትምህርቱን ዓላማ መረዳትዎን እና መስማማትዎን እዚህ ይግለጹ። ከመመዝገብዎ በፊት ይህንን ግልጽ በሆነ ሁኔታ መስማማት ግዴታ ነው። <span class="text-red-500">*</span>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center pt-4 sm:pt-6">
                    <button type="submit" 
                            class="gradient-bg text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg hover:shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center space-x-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>ይመዝገቡ</span>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-8 sm:mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
            <div class="text-center text-gray-600 text-xs sm:text-sm">
                <p>&copy; 2024 በስመአብ ወወልድ ወመንፈስ ቅዱስ አሐዱ አምላክ አሜን። ሁሉም መብቶች የተጠበቁ ናቸው።</p>
                <p class="mt-1 sm:mt-2">በኢ/ኦ/ተ/ቤ/ክ የጎ/መ/ሕ/ቅዱስ ገብርኤል ካ/ሰ/ት/ት</p>
            </div>
        </div>
    </footer>
</body>
</html>
