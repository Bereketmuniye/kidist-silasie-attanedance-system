<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login - Orthodox Church Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&family=Playfair+Display:wght@400;700;900&display=swap');
        
        body {
            font-family: 'Crimson Text', serif;
        }
        
        .orthodox-gradient {
            background: linear-gradient(135deg, #2c1810 0%, #4a2c1a 25%, #6b3e2a 50%, #4a2c1a 75%, #2c1810 100%);
        }
        
        .gold-gradient {
            background: linear-gradient(135deg, #d4af37 0%, #f4e4c1 50%, #d4af37 100%);
        }
        
        .cross-pattern {
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 35px, rgba(212, 175, 55, 0.1) 35px, rgba(212, 175, 55, 0.1) 70px),
                repeating-linear-gradient(-45deg, transparent, transparent 35px, rgba(212, 175, 55, 0.1) 35px, rgba(212, 175, 55, 0.1) 70px);
        }
        
        .orthodox-border {
            border: 3px solid #d4af37;
            box-shadow: 
                0 0 20px rgba(212, 175, 55, 0.3),
                inset 0 0 20px rgba(212, 175, 55, 0.1);
        }
        
        .iconic-cross {
            position: relative;
            width: 60px;
            height: 60px;
        }
        
        .iconic-cross::before,
        .iconic-cross::after {
            content: '';
            position: absolute;
            background: #d4af37;
        }
        
        .iconic-cross::before {
            width: 100%;
            height: 8px;
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }
        
        .iconic-cross::after {
            width: 8px;
            height: 100%;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .ornamental-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid #d4af37;
        }
        
        .ornamental-corner.top-left {
            top: -2px;
            left: -2px;
            border-right: none;
            border-bottom: none;
        }
        
        .ornamental-corner.top-right {
            top: -2px;
            right: -2px;
            border-left: none;
            border-bottom: none;
        }
        
        .ornamental-corner.bottom-left {
            bottom: -2px;
            left: -2px;
            border-right: none;
            border-top: none;
        }
        
        .ornamental-corner.bottom-right {
            bottom: -2px;
            right: -2px;
            border-left: none;
            border-top: none;
        }
        
        .input-orthodox {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #d4af37;
            transition: all 0.3s ease;
        }
        
        .input-orthodox:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #f4e4c1;
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
        }
        
        .btn-orthodox {
            background: linear-gradient(135deg, #2c1810 0%, #4a2c1a 100%);
            border: 2px solid #d4af37;
            color: #f4e4c1;
            transition: all 0.3s ease;
        }
        
        .btn-orthodox:hover {
            background: linear-gradient(135deg, #4a2c1a 0%, #6b3e2a 100%);
            border-color: #f4e4c1;
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.4);
            transform: translateY(-2px);
        }
        
        .holy-text {
            font-family: 'Playfair Display', serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="orthodox-gradient cross-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Main Login Container -->
        <div class="relative bg-white/95 backdrop-blur-sm rounded-lg orthodox-border p-8 shadow-2xl">
            <!-- Ornamental Corners -->
            <div class="ornamental-corner top-left"></div>
            <div class="ornamental-corner top-right"></div>
            <div class="ornamental-corner bottom-left"></div>
            <div class="ornamental-corner bottom-right"></div>
            
            <!-- Header with Cross -->
            <div class="text-center mb-8">
                <div class="iconic-cross mx-auto mb-4"></div>
                <h1 class="holy-text text-3xl font-bold text-amber-900 mb-2">
                    Holy Trinity Church
                </h1>
                <p class="text-amber-800 text-lg font-medium">
                    Teacher Portal
                </p>
                <div class="w-24 h-1 gold-gradient mx-auto mt-4 rounded-full"></div>
            </div>
            
            <!-- Login Form -->
            <form method="POST" action="{{ route('teacher.login.submit') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="remember" value="true">
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-amber-900 font-semibold mb-2">
                        Email Address
                    </label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                           class="input-orthodox w-full px-4 py-3 rounded-lg text-amber-900 placeholder-amber-600"
                           placeholder="Enter your email" value="{{ old('email') }}">
                </div>
                
                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-amber-900 font-semibold mb-2">
                        Password
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                           class="input-orthodox w-full px-4 py-3 rounded-lg text-amber-900 placeholder-amber-600"
                           placeholder="Enter your password">
                </div>
                
                <!-- Error Messages -->
                @if($errors->any())
                    <div class="bg-red-50 border-2 border-red-300 text-red-800 px-4 py-3 rounded-lg orthodox-border">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 001.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-sm">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember-me" name="remember" type="checkbox" 
                           class="h-4 w-4 text-amber-700 focus:ring-amber-500 border-amber-300 rounded">
                    <label for="remember-me" class="ml-2 block text-amber-900">
                        Remember me
                    </label>
                </div>
                
                <!-- Submit Button -->
                <div>
                    <button type="submit" class="btn-orthodox w-full py-3 px-4 rounded-lg font-semibold text-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        Enter Sacred Portal
                    </button>
                </div>
            </form>
            
            <!-- Footer Links -->
            <div class="mt-8 text-center space-y-3 border-t border-amber-200 pt-6">
                <a href="{{ route('student.register') }}" 
                   class="block text-amber-700 hover:text-amber-800 font-medium transition-colors">
                    Student Registration
                </a>
                <a href="{{ route('exams.list') }}" 
                   class="block text-amber-700 hover:text-amber-800 font-medium transition-colors">
                    View Available Exams
                </a>
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="text-center mt-8">
            <div class="inline-flex items-center space-x-2 text-amber-200">
                <div class="w-8 h-px bg-amber-400"></div>
                <span class="text-sm font-medium">✠</span>
                <div class="w-8 h-px bg-amber-400"></div>
            </div>
            <p class="text-amber-300 text-sm mt-2">
                © 2024 Holy Trinity Church Management System
            </p>
        </div>
    </div>
</body>
</html>
