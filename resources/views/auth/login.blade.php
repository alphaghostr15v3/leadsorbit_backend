<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Leads Orbit</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f3ff',
                            100: '#e0e7ff',
                            400: '#818cf8',
                            500: '#667eea',
                            600: '#5568d3',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #020617;
            background-image: 
                radial-gradient(at 0% 0%, rgba(102, 126, 234, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(118, 75, 162, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(102, 126, 234, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(118, 75, 162, 0.1) 0px, transparent 50%);
        }

        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }

        .bg-orb {
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
            opacity: 0.2;
        }

        .orb-1 { top: -100px; left: -100px; background: #667eea; }
        .orb-2 { bottom: -100px; right: -100px; background: #764ba2; }

        input:focus {
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-orb orb-1"></div>
    <div class="bg-orb orb-2"></div>

    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 mb-6 group transition-all duration-300 hover:scale-110">
                <i class="bi bi-hexagon-fill text-4xl text-indigo-500"></i>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight mb-2">Leads <span class="text-indigo-500">Orbit</span></h1>
            <p class="text-gray-400">Control center access</p>
        </div>

        <!-- Login Card -->
        <div class="glass-card rounded-3xl p-8 md:p-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 blur-3xl -mr-16 -mt-16"></div>
            
            <form action="{{ route('login') }}" method="POST" class="space-y-6 relative">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" 
                            class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl py-3 pl-11 pr-4 focus:outline-none focus:border-indigo-500 transition-all placeholder:text-gray-600"
                            placeholder="admin@leadsorbit.com" required value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <a href="#" class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">Forgot password?</a>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                            class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-xl py-3 pl-11 pr-4 focus:outline-none focus:border-indigo-500 transition-all placeholder:text-gray-600"
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-slate-900">
                    <label for="remember" class="ml-2 block text-sm text-gray-400">Keep me logged in</label>
                </div>

                <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-4 rounded-xl transition-all transform hover:scale-[1.02] active:scale-[0.98] shadow-lg shadow-indigo-600/20">
                    Enter Dashboard
                    <i class="bi bi-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>

        <div class="mt-8 text-center text-gray-500 text-sm">
            &copy; 2026 <span class="text-gray-400 font-medium tracking-wide uppercase text-xs">Leads Orbit v2.0</span>
        </div>
    </div>
</body>
</html>
