<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] antialiased">
        <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block z-10">
                    @auth
                        <a href="http://localhost:5173/admin" class="text-sm text-gray-700 dark:text-gray-500 underline">Go to React Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 w-full">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0 mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">Our Portfolio</h1>
                </div>

                <div class="mt-8 bg-white dark:bg-zinc-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        @forelse($portfolioItems as $item)
                            <div class="border border-gray-200 dark:border-zinc-700 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                @if($item->image_url)
                                    <img src="{{ asset($item->image_url) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-100 dark:bg-zinc-700 flex items-center justify-center text-gray-400">
                                        <span>No Image</span>
                                    </div>
                                @endif
                                <div class="p-4">
                                    @if($item->category)
                                        <span class="inline-block px-2 py-1 text-xs font-semibold tracking-wide text-indigo-500 uppercase bg-indigo-50 rounded-full mb-2">{{ $item->category }}</span>
                                    @endif
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $item->title }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $item->client_name }}</p>
                                    <p class="text-gray-500 dark:text-gray-300 text-sm line-clamp-3 mb-4">{{ $item->description }}</p>
                                    @if($item->project_url)
                                        <a href="{{ $item->project_url }}" target="_blank" class="inline-block px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded hover:bg-indigo-500 transition-colors">View Project</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-gray-500 dark:text-gray-400 text-lg">No portfolio items found.</p>
                                <p class="text-gray-400 dark:text-gray-500 text-sm">Check back later for our latest work.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
