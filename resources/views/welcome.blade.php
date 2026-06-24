<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moodify | Futuristic Music Discovery</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via CDN for immediate preview functionality) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        slate: { 950: '#020617' }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
        
        .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-950 text-slate-300 font-sans antialiased h-screen overflow-hidden flex relative selection:bg-pink-500 selection:text-white" x-data="moodifyApp()" x-init="initApp()">

    <!-- Ambient Glowing Background Effects -->
    <div class="absolute top-[-10%] left-[-10%] w-[40rem] h-[40rem] bg-purple-600/20 rounded-full mix-blend-screen filter blur-[128px] pointer-events-none z-0"></div>
    <div class="absolute bottom-[-10%] right-[-5%] w-[35rem] h-[35rem] bg-pink-600/10 rounded-full mix-blend-screen filter blur-[100px] pointer-events-none z-0"></div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" class="fixed inset-0 bg-black/50 z-40 lg:hidden backdrop-blur-sm" @click="sidebarOpen = false" x-transition.opacity x-cloak></div>

    <!-- LEFT SIDEBAR -->
    <aside class="fixed inset-y-0 left-0 w-64 glass-panel border-r border-slate-800/50 flex flex-col z-50 transform transition-transform duration-300 lg:relative lg:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <!-- Logo -->
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center shadow-[0_0_15px_rgba(236,72,153,0.4)]">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
            </div>
            <span class="text-xl font-bold text-white tracking-wide">Moodify</span>
            <button @click="sidebarOpen = false" class="ml-auto lg:hidden text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-4 space-y-2 overflow-y-auto">
            <a href="#" @click.prevent="currentView = 'home'; currentMood = null; sidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="currentView === 'home' ? 'bg-gradient-to-r from-pink-500/10 to-purple-600/10 text-white font-medium border border-pink-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'">
                <svg class="w-5 h-5" :class="currentView === 'home' ? 'text-pink-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Home
            </a>
            <a href="#" @click.prevent="currentView = 'explore'; currentMood = null; sidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="currentView === 'explore' ? 'bg-gradient-to-r from-pink-500/10 to-purple-600/10 text-white font-medium border border-pink-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'">
                <svg class="w-5 h-5" :class="currentView === 'explore' ? 'text-pink-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                Explore
            </a>
            <a href="#" @click.prevent="currentView = 'favorites'; currentMood = null; sidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="currentView === 'favorites' ? 'bg-gradient-to-r from-pink-500/10 to-purple-600/10 text-white font-medium border border-pink-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'">
                <svg class="w-5 h-5" :class="currentView === 'favorites' ? 'text-pink-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                My Favorites
                <span x-show="favorites.length > 0" x-cloak class="ml-auto text-xs bg-pink-500 text-white px-2 py-0.5 rounded-full" x-text="favorites.length"></span>
            </a>
            <a href="#" @click.prevent="currentView = 'recentlyPlayed'; currentMood = null; sidebarOpen = false" class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors" :class="currentView === 'recentlyPlayed' ? 'bg-gradient-to-r from-pink-500/10 to-purple-600/10 text-white font-medium border border-pink-500/20' : 'text-slate-400 hover:text-white hover:bg-slate-800/50'">
                <svg class="w-5 h-5" :class="currentView === 'recentlyPlayed' ? 'text-pink-400' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Recently Played
            </a>

            <!-- Collapsible Filters -->
            <div class="mt-8" x-data="{ filtersOpen: true }">
                <button @click="filtersOpen = !filtersOpen" class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider hover:text-white">
                    <span>Quick Filters</span>
                    <svg class="w-4 h-4 transform transition-transform" :class="filtersOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="filtersOpen" x-collapse class="px-4 py-2 space-y-3">
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Language</label>
                        <select x-model="filters.language" class="w-full bg-slate-900 border border-slate-700 text-sm rounded-md px-2 py-1.5 focus:outline-none focus:border-pink-500 text-slate-300">
                            <option>Any Language</option>
                            <option>English</option>
                            <option>Hindi</option>
                            <option>Spanish</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 mb-1 block">Vocal Preference</label>
                        <select x-model="filters.vocal" class="w-full bg-slate-900 border border-slate-700 text-sm rounded-md px-2 py-1.5 focus:outline-none focus:border-pink-500 text-slate-300">
                            <option>Both</option>
                            <option>Instrumental</option>
                            <option>Vocal</option>
                        </select>
                    </div>
                    <button @click="applySidebarFilters" class="w-full mt-4 py-2 rounded-lg bg-gradient-to-r from-pink-500 to-purple-600 text-white text-sm font-semibold hover:shadow-[0_0_15px_rgba(236,72,153,0.4)] transition-all">
                        Apply Filters
                    </button>
                </div>
            </div>
        </nav>
        
        <!-- User Mini Profile -->
        <div class="p-4 border-t border-slate-800/50">
            <div class="flex items-center gap-3">
                <img src="https://i.pravatar.cc/150?img=32" alt="User" class="w-10 h-10 rounded-full border border-slate-600">
                <div>
                    <p class="text-sm text-white font-medium">Guest User</p>
                    <p class="text-xs text-slate-500">Free Tier</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full overflow-y-auto relative z-10 scroll-smooth">
        
        <!-- Header -->
        <header class="sticky top-0 z-30 glass-panel border-b border-slate-800/50 px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4 flex-1">
                <button @click="sidebarOpen = true" class="lg:hidden text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <!-- Search Bar -->
                <div class="relative w-full max-w-md hidden sm:block">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input x-model="searchQuery" type="text" placeholder="Search songs, artists, genres..." class="w-full bg-slate-900/50 border border-slate-700/50 text-slate-200 text-sm rounded-full pl-10 pr-4 py-2 focus:outline-none focus:border-pink-500 focus:ring-1 focus:ring-pink-500 transition-colors placeholder-slate-500">
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-1 text-sm text-slate-400 font-medium cursor-pointer hover:text-white">
                    EN <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                <button class="text-slate-400 hover:text-pink-400 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>
        </header>

        <!-- Main Content Padding Wrapper -->
        <div class="p-6 md:p-8 lg:p-10 space-y-12">
            
            <!-- Hero Section -->
            <section x-show="currentView === 'home'" x-cloak class="text-center md:text-left space-y-3 relative z-10">
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white">
                    Mood-Based <br class="md:hidden" />
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-purple-600 drop-shadow-[0_0_15px_rgba(236,72,153,0.5)]">Music Suggestion</span>
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl">Choose your mood and let us curate the perfect vibes for your current state of mind 🎵</p>
            </section>

            <!-- Section Title for other views -->
            <section x-show="currentView !== 'home'" x-cloak class="relative z-10">
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">
                    <span x-show="currentView === 'explore'">Explore All Songs</span>
                    <span x-show="currentView === 'favorites'">My Favorites <span class="text-pink-500">❤️</span></span>
                    <span x-show="currentView === 'recentlyPlayed'">Recently Played <span class="text-purple-500">🕐</span></span>
                </h1>
                <p class="text-slate-400 mt-2" x-show="currentView === 'explore'">Browse our complete collection of 100 songs across English, Hindi, and Spanish.</p>
                <p class="text-slate-400 mt-2" x-show="currentView === 'favorites'">All your saved favorite tracks in one place.</p>
                <p class="text-slate-400 mt-2" x-show="currentView === 'recentlyPlayed'">Tracks you've played recently.</p>
            </section>

            <!-- Mood Selector (Home only) -->
            <section x-show="currentView === 'home'" x-cloak class="space-y-4">
                <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                    How are you feeling?
                </h2>
                <div class="flex overflow-x-auto pb-4 pt-2 -mx-2 px-2 gap-4 snap-x hide-scrollbar" style="scrollbar-width: none;">
                    <template x-for="mood in moods" :key="mood.id">
                        <a href="#" @click.prevent="currentMood = (currentMood === mood.id ? null : mood.id)"
                           class="snap-start flex-shrink-0 relative group rounded-2xl p-4 flex flex-col items-center justify-center w-28 h-32 transition-all duration-300 glass-panel border"
                           :class="currentMood === mood.id ? 'border-' + mood.color + ' bg-slate-800/80 -translate-y-2' : 'border-slate-800 hover:border-slate-600 hover:-translate-y-1 hover:bg-slate-800/50'"
                           :style="currentMood === mood.id ? 'box-shadow: 0 0 20px ' + mood.shadow + ', inset 0 0 10px ' + mood.shadow + ';' : ''">
                            
                            <span class="text-4xl drop-shadow-md mb-2 transform transition-transform group-hover:scale-110" x-text="mood.emoji"></span>
                            <span class="text-sm font-medium" :class="currentMood === mood.id ? 'text-white' : 'text-slate-400 group-hover:text-slate-200'" x-text="mood.label"></span>
                            
                            <div x-show="currentMood === mood.id" x-cloak class="absolute -bottom-1 w-1/2 h-1 rounded-full shadow-[0_0_10px_currentColor]" :class="'bg-' + mood.color"></div>
                        </a>
                    </template>
                </div>
            </section>

            <!-- Advanced Filter Section -->
            <section class="glass-panel rounded-2xl p-6 border border-slate-800/50">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-md font-semibold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Refine Your Recommendations
                    </h3>
                    <button @click="resetFilters" class="text-xs text-slate-400 hover:text-white border border-slate-700 px-3 py-1.5 rounded-md hover:bg-slate-800 transition">Reset Filters</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-medium text-slate-400">Genre</label>
                        <select x-model="filters.genre" class="w-full bg-slate-950/50 border border-slate-700 text-slate-300 text-sm rounded-lg px-3 py-2.5 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none appearance-none">
                            <option>All Genres</option>
                            <option>Pop</option>
                            <option>Hip Hop</option>
                            <option>Rock</option>
                            <option>Electronic</option>
                            <option>Bollywood</option>
                            <option>Latin</option>
                            <option>Reggaeton</option>
                            <option>Alternative</option>
                            <option>Folk</option>
                            <option>Soul</option>
                            <option>R&B</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-medium text-slate-400">Release Year</label>
                        <select x-model="filters.year" class="w-full bg-slate-950/50 border border-slate-700 text-slate-300 text-sm rounded-lg px-3 py-2.5 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none appearance-none">
                            <option>Any Year</option>
                            <option>2024</option>
                            <option>2020s</option>
                            <option>2010s</option>
                            <option>2000s</option>
                            <option>1990s</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-medium text-slate-400">Sort By</label>
                        <select x-model="filters.sortBy" class="w-full bg-slate-950/50 border border-slate-700 text-slate-300 text-sm rounded-lg px-3 py-2.5 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 outline-none appearance-none">
                            <option>Relevance</option>
                            <option>Most Popular</option>
                            <option>Newest First</option>
                            <option>Top Rated</option>
                        </select>
                    </div>
                    <div class="space-y-1.5 flex flex-col justify-center">
                        <div class="flex justify-between items-end">
                            <label class="text-xs font-medium text-slate-400">Energy Level</label>
                            <span class="text-xs font-bold text-purple-400" x-text="filters.energyLevel + '%'"></span>
                        </div>
                        <input type="range" min="0" max="100" x-model="filters.energyLevel" class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-purple-500 outline-none mt-2">
                    </div>
                </div>

                <!-- Quick Filter Pills -->
                <div class="mt-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex flex-wrap gap-2">
                        <button @click="filters.quickFilter = 'For You'" :class="filters.quickFilter === 'For You' ? 'bg-white text-black' : 'bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-white'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">For You</button>
                        <button @click="filters.quickFilter = 'New Releases'" :class="filters.quickFilter === 'New Releases' ? 'bg-white text-black' : 'bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-white'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">New Releases</button>
                        <button @click="filters.quickFilter = 'Top Rated'" :class="filters.quickFilter === 'Top Rated' ? 'bg-white text-black' : 'bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-white'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">Top Rated</button>
                        <button @click="filters.quickFilter = 'Trending'" :class="filters.quickFilter === 'Trending' ? 'bg-white text-black' : 'bg-slate-800 border border-slate-700 text-slate-300 hover:bg-slate-700 hover:text-white'" class="px-4 py-1.5 rounded-full text-xs font-medium transition">Trending</button>
                    </div>
                    <button @click="applyFilters" class="px-6 py-2 rounded-lg bg-gradient-to-r from-pink-500 to-purple-600 text-white text-sm font-semibold hover:shadow-[0_0_15px_rgba(236,72,153,0.5)] transition-all">
                        Apply Filters
                    </button>
                </div>
            </section>

            <!-- Video Grid -->
            <section>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <span x-show="currentView === 'home'">Recommended for you <span class="text-pink-500">💜</span></span>
                        <span x-show="currentView === 'explore'">All Songs <span x-show="filteredSongs.length > 0" x-cloak class="text-sm text-slate-400 font-normal" x-text="'(' + filteredSongs.length + ')'"></span></span>
                        <span x-show="currentView === 'favorites'">Your Favorites <span x-show="favoriteSongs.length > 0" x-cloak class="text-sm text-slate-400 font-normal" x-text="'(' + favoriteSongs.length + ')'"></span></span>
                        <span x-show="currentView === 'recentlyPlayed'">History <span x-show="recentSongs.length > 0" x-cloak class="text-sm text-slate-400 font-normal" x-text="'(' + recentSongs.length + ')'"></span></span>
                    </h2>
                </div>

                <!-- Empty States -->
                <div x-show="displayedSongs.length === 0" x-cloak class="text-center py-20">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-slate-800 flex items-center justify-center">
                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-1">No songs found</h3>
                    <p class="text-slate-400 text-sm">Try adjusting your filters or search query.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
                    <template x-for="song in displayedSongs" :key="song.id">
                        <div class="glass-panel rounded-xl overflow-hidden border border-slate-800/60 group hover:border-slate-600 transition-colors" x-data="{ playing: false }">
                            
                            <!-- Thumbnail Area -->
                            <div class="relative aspect-video bg-slate-900 overflow-hidden">
                                <template x-if="playing">
                                    <iframe class="absolute inset-0 w-full h-full" :src="'https://www.youtube.com/embed/' + song.id + '?autoplay=1'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </template>
                                
                                <div x-show="!playing" class="w-full h-full">
                                    <img :src="'https://img.youtube.com/vi/' + song.id + '/mqdefault.jpg'" :alt="song.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80 group-hover:opacity-100">
                                    
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/10 transition-colors">
                                        <button @click="playing = true; addToRecent(song.id)" class="w-14 h-14 bg-red-600/90 text-white rounded-full flex items-center justify-center pl-1 shadow-[0_0_20px_rgba(220,38,38,0.5)] transform group-hover:scale-110 transition-all">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                                        </button>
                                    </div>
                                    
                                    <div class="absolute bottom-2 right-2 bg-black/80 text-white text-[10px] font-bold px-1.5 py-0.5 rounded" x-text="song.duration"></div>
                                    
                                    <!-- Favorite Button on Thumbnail -->
                                    <button @click.stop="toggleFavorite(song.id)" class="absolute top-2 right-2 w-8 h-8 rounded-full bg-black/50 backdrop-blur-sm flex items-center justify-center transition-all hover:bg-black/80">
                                        <svg class="w-4 h-4 transition-colors" :class="isFavorite(song.id) ? 'text-pink-500 fill-current' : 'text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Meta Details Area -->
                            <div class="p-4">
                                <div class="flex justify-between items-start gap-2">
                                    <div class="flex-1">
                                        <h3 class="font-bold text-slate-100 text-sm line-clamp-1 group-hover:text-pink-400 transition-colors" :title="song.title" x-text="song.title"></h3>
                                        <p class="text-slate-400 text-xs mt-1 flex items-center gap-1">
                                            <span x-text="song.artist"></span>
                                            <svg x-show="song.verified" class="w-3.5 h-3.5 text-slate-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path></svg>
                                        </p>
                                        <p class="text-slate-500 text-[10px] mt-0.5 flex items-center gap-2">
                                            <span x-text="song.language"></span>
                                            <span>•</span>
                                            <span x-text="song.genre"></span>
                                            <span>•</span>
                                            <span x-text="song.year"></span>
                                        </p>
                                    </div>
                                    <button class="text-slate-500 hover:text-white p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                    </button>
                                </div>
                                
                                <div class="mt-3 flex flex-wrap gap-1.5">
                                    <template x-for="tag in song.tags" :key="tag">
                                        <span class="px-2 py-0.5 bg-slate-800/80 border border-slate-700 text-slate-300 text-[10px] rounded-md font-medium" x-text="tag"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            <!-- Call To Action -->
            <section class="mt-8 relative overflow-hidden rounded-2xl glass-panel border border-pink-500/20 p-8 text-center flex flex-col items-center justify-center gap-4">
                <div class="absolute inset-0 bg-gradient-to-r from-pink-500/10 to-purple-600/10 z-0"></div>
                <svg class="w-12 h-12 text-pink-400 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-white mb-2">Login to save your favorites</h2>
                    <p class="text-slate-400 text-sm max-w-md mx-auto mb-6">Create custom playlists, save your current mood vibes, and get better recommendations across all your devices.</p>
                    <button class="px-8 py-3 rounded-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold tracking-wide hover:shadow-[0_0_20px_rgba(236,72,153,0.6)] transform hover:-translate-y-0.5 transition-all">
                        Login / Sign Up
                    </button>
                </div>
            </section>

            <!-- Footer -->
            <footer class="pt-8 pb-4 border-t border-slate-800/50 mt-12 grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        </div>
                        <span class="text-lg font-bold text-white tracking-wide">Moodify</span>
                    </div>
                    <p class="text-xs text-slate-500">Your personal AI-powered mood music companion.</p>
                </div>
                
                <div>
                    <h4 class="text-slate-200 font-semibold mb-3 text-sm">About</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="#" class="hover:text-pink-400 transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-pink-400 transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-pink-400 transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-slate-200 font-semibold mb-3 text-sm">Connect</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="#" class="hover:text-pink-400 transition-colors">Instagram</a></li>
                        <li><a href="#" class="hover:text-pink-400 transition-colors">Twitter X</a></li>
                        <li><a href="#" class="hover:text-pink-400 transition-colors">YouTube</a></li>
                    </ul>
                </div>

                <div class="md:text-right">
                    <h4 class="text-slate-200 font-semibold mb-3 text-sm">Support</h4>
                    <ul class="space-y-2 text-xs text-slate-400 mb-6">
                        <li><a href="#" class="hover:text-pink-400 transition-colors">Help Center</a></li>
                    </ul>
                    <p class="text-xs text-slate-500">Made with ❤️ for music lovers</p>
                </div>
            </footer>
            
        </div>
    </main>

    <script>
        const SONGS_DATA = [
            // English (34)
            {id:'dQw4w9WgXcQ',title:'Never Gonna Give You Up',artist:'Rick Astley',duration:'3:33',language:'English',genre:'Pop',year:1987,tags:['Classic','Pop'],verified:true,energy:65,rating:4.8,views:1400000000,mood:'happy',vocal:'Vocal'},
            {id:'JGwWNGJdvx8',title:'Shape of You',artist:'Ed Sheeran',duration:'4:24',language:'English',genre:'Pop',year:2017,tags:['Pop','Dance'],verified:true,energy:70,rating:4.6,views:5900000000,mood:'romantic',vocal:'Vocal'},
            {id:'60ItHLz5WEA',title:'Faded',artist:'Alan Walker',duration:'3:32',language:'English',genre:'Electronic',year:2015,tags:['EDM','Melodic'],verified:true,energy:60,rating:4.7,views:3200000000,mood:'focus',vocal:'Vocal'},
            {id:'CevxZvSJLk8',title:'Roar',artist:'Katy Perry',duration:'4:30',language:'English',genre:'Pop',year:2013,tags:['Pop','Empowering'],verified:true,energy:85,rating:4.5,views:3800000000,mood:'energetic',vocal:'Vocal'},
            {id:'09R8_2nJtjg',title:'Sugar',artist:'Maroon 5',duration:'5:02',language:'English',genre:'Pop',year:2014,tags:['Pop','Wedding'],verified:true,energy:75,rating:4.6,views:3900000000,mood:'romantic',vocal:'Vocal'},
            {id:'nfWlot6h_JM',title:'Shake It Off',artist:'Taylor Swift',duration:'4:02',language:'English',genre:'Pop',year:2014,tags:['Pop','Dance'],verified:true,energy:90,rating:4.5,views:3100000000,mood:'happy',vocal:'Vocal'},
            {id:'OPf0YbXqDm0',title:'Uptown Funk',artist:'Mark Ronson ft. Bruno Mars',duration:'4:31',language:'English',genre:'Funk',year:2014,tags:['Funk','Groove'],verified:true,energy:95,rating:4.7,views:4800000000,mood:'party',vocal:'Vocal'},
            {id:'t4H_Zoh7G5A',title:'Sorry',artist:'Justin Bieber',duration:'3:26',language:'English',genre:'Pop',year:2015,tags:['Pop','Dance'],verified:true,energy:80,rating:4.4,views:3600000000,mood:'party',vocal:'Vocal'},
            {id:'pXRviuL8Z6g',title:'We Don\'t Talk Anymore',artist:'Charlie Puth',duration:'3:51',language:'English',genre:'Pop',year:2016,tags:['Pop','Breakup'],verified:true,energy:55,rating:4.5,views:2900000000,mood:'sad',vocal:'Vocal'},
            {id:'hT_nvWreIhg',title:'Counting Stars',artist:'OneRepublic',duration:'4:44',language:'English',genre:'Pop Rock',year:2013,tags:['Rock','Inspirational'],verified:true,energy:78,rating:4.7,views:3500000000,mood:'focus',vocal:'Vocal'},
            {id:'7wtfhZwyrcc',title:'Believer',artist:'Imagine Dragons',duration:'3:24',language:'English',genre:'Rock',year:2017,tags:['Rock','Power'],verified:true,energy:92,rating:4.6,views:2600000000,mood:'workout',vocal:'Vocal'},
            {id:'QcIy9Nbs3zw',title:'Blinding Lights',artist:'The Weeknd',duration:'4:23',language:'English',genre:'Pop',year:2019,tags:['Synthwave','Retro'],verified:true,energy:88,rating:4.8,views:2400000000,mood:'party',vocal:'Vocal'},
            {id:'YqeW9_5kURI',title:'Lean On',artist:'Major Lazer',duration:'2:56',language:'English',genre:'Electronic',year:2015,tags:['EDM','Tropical'],verified:true,energy:82,rating:4.5,views:3200000000,mood:'party',vocal:'Vocal'},
            {id:'k2qgadSvNyU',title:'New Rules',artist:'Dua Lipa',duration:'3:45',language:'English',genre:'Pop',year:2017,tags:['Pop','Empowering'],verified:true,energy:75,rating:4.4,views:1800000000,mood:'energetic',vocal:'Vocal'},
            {id:'450p7goxZqk',title:'All of Me',artist:'John Legend',duration:'5:08',language:'English',genre:'R&B',year:2013,tags:['Love','Ballad'],verified:true,energy:35,rating:4.7,views:2200000000,mood:'romantic',vocal:'Vocal'},
            {id:'0KSOMA3QBU0',title:'Dark Horse',artist:'Katy Perry',duration:'3:45',language:'English',genre:'Pop',year:2013,tags:['Pop','Trap'],verified:true,energy:72,rating:4.3,views:1900000000,mood:'party',vocal:'Vocal'},
            {id:'papuvlVeZg8',title:'Rather Be',artist:'Clean Bandit',duration:'3:49',language:'English',genre:'Electronic',year:2014,tags:['EDM','Orchestral'],verified:true,energy:80,rating:4.5,views:1200000000,mood:'happy',vocal:'Vocal'},
            {id:'1G4isv_Fylg',title:'Paradise',artist:'Coldplay',duration:'4:21',language:'English',genre:'Alternative',year:2011,tags:['Alternative','Uplifting'],verified:true,energy:78,rating:4.6,views:1600000000,mood:'happy',vocal:'Vocal'},
            {id:'RBumgq5yVrA',title:'Let Her Go',artist:'Passenger',duration:'4:15',language:'English',genre:'Folk',year:2012,tags:['Acoustic','Sad'],verified:true,energy:40,rating:4.7,views:3200000000,mood:'sad',vocal:'Vocal'},
            {id:'0yW7w8F2Tvs',title:'Chandelier',artist:'Sia',duration:'3:36',language:'English',genre:'Pop',year:2014,tags:['Pop','Power'],verified:true,energy:85,rating:4.5,views:1700000000,mood:'energetic',vocal:'Vocal'},
            {id:'nJh0M3yL6Kc',title:'Hello',artist:'Adele',duration:'6:07',language:'English',genre:'Soul',year:2015,tags:['Soul','Ballad'],verified:true,energy:45,rating:4.7,views:2800000000,mood:'sad',vocal:'Vocal'},
            {id:'3AtDnEC4zak',title:'Stitches',artist:'Shawn Mendes',duration:'3:28',language:'English',genre:'Pop',year:2015,tags:['Pop','Catchy'],verified:true,energy:70,rating:4.4,views:1500000000,mood:'romantic',vocal:'Vocal'},
            {id:'YQHsXMglC9A',title:'Someone Like You',artist:'Adele',duration:'4:45',language:'English',genre:'Soul',year:2011,tags:['Piano','Heartbreak'],verified:true,energy:30,rating:4.8,views:1800000000,mood:'sad',vocal:'Vocal'},
            {id:'rYEDA3JcQqw',title:'Rolling in the Deep',artist:'Adele',duration:'3:54',language:'English',genre:'Soul',year:2010,tags:['Soul','Power'],verified:true,energy:80,rating:4.7,views:2100000000,mood:'energetic',vocal:'Vocal'},
            {id:'uO59tfQ2TbA',title:'Problem',artist:'Ariana Grande',duration:'3:14',language:'English',genre:'Pop',year:2014,tags:['Pop','R&B'],verified:true,energy:85,rating:4.3,views:1200000000,mood:'party',vocal:'Vocal'},
            {id:'iS1g8G_njx8',title:'One Last Time',artist:'Ariana Grande',duration:'3:18',language:'English',genre:'Pop',year:2014,tags:['Pop','Emotional'],verified:true,energy:65,rating:4.5,views:1100000000,mood:'romantic',vocal:'Vocal'},
            {id:'vjW8wmF5VW8',title:'Stay With Me',artist:'Sam Smith',duration:'3:29',language:'English',genre:'Soul',year:2014,tags:['Gospel','Soul'],verified:true,energy:40,rating:4.6,views:1400000000,mood:'sad',vocal:'Vocal'},
            {id:'nSDgHBxUbVQ',title:'Photograph',artist:'Ed Sheeran',duration:'4:35',language:'English',genre:'Pop',year:2014,tags:['Acoustic','Love'],verified:true,energy:45,rating:4.6,views:1300000000,mood:'romantic',vocal:'Vocal'},
            {id:'2Vv-BfVoq4g',title:'Perfect',artist:'Ed Sheeran',duration:'4:40',language:'English',genre:'Pop',year:2017,tags:['Love','Wedding'],verified:true,energy:50,rating:4.7,views:3600000000,mood:'romantic',vocal:'Vocal'},
            {id:'lp-EO5I60KA',title:'Thinking Out Loud',artist:'Ed Sheeran',duration:'4:57',language:'English',genre:'Pop',year:2014,tags:['Love','Dance'],verified:true,energy:60,rating:4.6,views:2200000000,mood:'romantic',vocal:'Vocal'},
            {id:'IcrbM1l_JoY',title:'Wake Me Up',artist:'Avicii',duration:'4:33',language:'English',genre:'Electronic',year:2013,tags:['EDM','Folk'],verified:true,energy:88,rating:4.7,views:2300000000,mood:'energetic',vocal:'Vocal'},
            {id:'6Cp6mKbRTQY',title:'Hey Brother',artist:'Avicii',duration:'4:15',language:'English',genre:'Electronic',year:2013,tags:['EDM','Country'],verified:true,energy:85,rating:4.5,views:800000000,mood:'happy',vocal:'Vocal'},
            {id:'cIriwVhC7gU',title:'See You Again',artist:'Wiz Khalifa',duration:'3:58',language:'English',genre:'Hip Hop',year:2015,tags:['Rap','Tribute'],verified:true,energy:55,rating:4.7,views:5500000000,mood:'sad',vocal:'Vocal'},
            {id:'uQFVqltaHLw',title:'Love Me Like You Do',artist:'Ellie Goulding',duration:'4:14',language:'English',genre:'Pop',year:2015,tags:['Soundtrack','Romance'],verified:true,energy:60,rating:4.5,views:2100000000,mood:'romantic',vocal:'Vocal'},
            
            // Hindi (33)
            {id:'8v-TWxPWIWc',title:'Tum Hi Ho',artist:'Arijit Singh',duration:'4:22',language:'Hindi',genre:'Bollywood',year:2013,tags:['Romance','Ballad'],verified:true,energy:40,rating:4.8,views:800000000,mood:'romantic',vocal:'Vocal'},
            {id:'oij_l8l2Jm8',title:'Chaiyya Chaiyya',artist:'Sukhwinder Singh',duration:'6:54',language:'Hindi',genre:'Bollywood',year:1998,tags:['Classic','Dance'],verified:true,energy:95,rating:4.7,views:450000000,mood:'party',vocal:'Vocal'},
            {id:'TITB3Q5mO6w',title:'Kala Chashma',artist:'Amar Arshi',duration:'3:08',language:'Hindi',genre:'Bollywood',year:2016,tags:['Dance','Party'],verified:true,energy:92,rating:4.5,views:900000000,mood:'party',vocal:'Vocal'},
            {id:'hHW1oY26kxQ',title:'Nashe Si Chadh Gayi',artist:'Arijit Singh',duration:'3:59',language:'Hindi',genre:'Bollywood',year:2016,tags:['Dance','Romance'],verified:true,energy:85,rating:4.4,views:600000000,mood:'happy',vocal:'Vocal'},
            {id:'284OvGysQBg',title:'Ghoomar',artist:'Shreya Ghoshal',duration:'4:42',language:'Hindi',genre:'Bollywood',year:2018,tags:['Folk','Traditional'],verified:true,energy:70,rating:4.6,views:350000000,mood:'happy',vocal:'Vocal'},
            {id:'sI9p70_Wc6o',title:'Dil Diyan Gallan',artist:'Atif Aslam',duration:'4:12',language:'Hindi',genre:'Bollywood',year:2017,tags:['Romance','Soft'],verified:true,energy:35,rating:4.7,views:550000000,mood:'romantic',vocal:'Vocal'},
            {id:'5L7RswVh8Zs',title:'Bom Diggy Diggy',artist:'Zack Knight',duration:'3:57',language:'Hindi',genre:'Bollywood',year:2018,tags:['Party','Dance'],verified:true,energy:90,rating:4.3,views:700000000,mood:'party',vocal:'Vocal'},
            {id:'hFv1yQenPbQ',title:'Aankh Marey',artist:'Neha Kakkar',duration:'3:34',language:'Hindi',genre:'Bollywood',year:2018,tags:['Dance','Remix'],verified:true,energy:88,rating:4.4,views:800000000,mood:'party',vocal:'Vocal'},
            {id:'jCEdTq3j-0I',title:'Dilbar',artist:'Neha Kakkar',duration:'3:24',language:'Hindi',genre:'Bollywood',year:2018,tags:['Dance','Arabic'],verified:true,energy:85,rating:4.3,views:1200000000,mood:'party',vocal:'Vocal'},
            {id:'uB1D9wWxd8w',title:'Vaaste',artist:'Dhvani Bhanushali',duration:'3:27',language:'Hindi',genre:'Pop',year:2019,tags:['Pop','Love'],verified:true,energy:55,rating:4.5,views:1100000000,mood:'romantic',vocal:'Vocal'},
            {id:'wF_B_aagLfI',title:'Ve Maahi',artist:'Arijit Singh',duration:'3:44',language:'Hindi',genre:'Bollywood',year:2019,tags:['Folk','Love'],verified:true,energy:60,rating:4.6,views:650000000,mood:'romantic',vocal:'Vocal'},
            {id:'BBAyRBTfs4I',title:'Tera Ban Jaunga',artist:'Tulsi Kumar',duration:'3:58',language:'Hindi',genre:'Bollywood',year:2019,tags:['Love','Romance'],verified:true,energy:50,rating:4.5,views:500000000,mood:'romantic',vocal:'Vocal'},
            {id:'8OJmT9v23h0',title:'Bekhayali',artist:'Sachet Tandon',duration:'6:26',language:'Hindi',genre:'Bollywood',year:2019,tags:['Rock','Emotional'],verified:true,energy:75,rating:4.7,views:600000000,mood:'sad',vocal:'Vocal'},
            {id:'hqvGOPB0KmQ',title:'Tujhe Kitna Chahne Lage',artist:'Arijit Singh',duration:'4:45',language:'Hindi',genre:'Bollywood',year:2019,tags:['Love','Sad'],verified:true,energy:40,rating:4.8,views:550000000,mood:'sad',vocal:'Vocal'},
            {id:'VOLKJJvfAbg',title:'Makhna',artist:'Tanishk Bagchi',duration:'3:02',language:'Hindi',genre:'Bollywood',year:2019,tags:['Party','Punjabi'],verified:true,energy:82,rating:4.2,views:400000000,mood:'party',vocal:'Vocal'},
            {id:'iMdHfi8hSOA',title:'Coca Cola',artist:'Tony Kakkar',duration:'2:59',language:'Hindi',genre:'Bollywood',year:2019,tags:['Dance','Fun'],verified:true,energy:88,rating:4.1,views:450000000,mood:'party',vocal:'Vocal'},
            {id:'vMLk_TNhXLY',title:'Chogada',artist:'Darshan Raval',duration:'4:32',language:'Hindi',genre:'Bollywood',year:2018,tags:['Garba','Dance'],verified:true,energy:92,rating:4.5,views:700000000,mood:'party',vocal:'Vocal'},
            {id:'wXB7bB1s1J4',title:'Dholida',artist:'Janhvi Shrimankar',duration:'3:20',language:'Hindi',genre:'Bollywood',year:2022,tags:['Garba','Traditional'],verified:true,energy:90,rating:4.4,views:300000000,mood:'party',vocal:'Vocal'},
            {id:'0w62R-ORbD8',title:'Kesariya',artist:'Arijit Singh',duration:'4:28',language:'Hindi',genre:'Bollywood',year:2022,tags:['Romance','Melody'],verified:true,energy:55,rating:4.7,views:650000000,mood:'romantic',vocal:'Vocal'},
            {id:'GdNihg6IyAY',title:'Apna Bana Le',artist:'Arijit Singh',duration:'3:24',language:'Hindi',genre:'Bollywood',year:2022,tags:['Love','Soft'],verified:true,energy:45,rating:4.6,views:400000000,mood:'romantic',vocal:'Vocal'},
            {id:'87JIOAX3njM',title:'Jhoome Jo Pathaan',artist:'Arijit Singh',duration:'3:20',language:'Hindi',genre:'Bollywood',year:2023,tags:['Dance','Party'],verified:true,energy:92,rating:4.5,views:800000000,mood:'party',vocal:'Vocal'},
            {id:'VAdH7iBdR7A',title:'Besharam Rang',artist:'Shilpa Rao',duration:'4:18',language:'Hindi',genre:'Bollywood',year:2023,tags:['Dance','Beach'],verified:true,energy:85,rating:4.4,views:700000000,mood:'party',vocal:'Vocal'},
            {id:'11iZcYbqzaY',title:'Naatu Naatu',artist:'Rahul Sipligunj',duration:'3:36',language:'Hindi',genre:'Telugu',year:2022,tags:['Dance','Award'],verified:true,energy:95,rating:4.8,views:600000000,mood:'party',vocal:'Vocal'},
            {id:'HnvDNv-HzVE',title:'Saami Saami',artist:'Mounika Yadav',duration:'3:48',language:'Hindi',genre:'Telugu',year:2022,tags:['Folk','Dance'],verified:true,energy:88,rating:4.5,views:350000000,mood:'party',vocal:'Vocal'},
            {id:'Nl2qBUJVNeM',title:'Dosti',artist:'Vijay Prakash',duration:'5:18',language:'Hindi',genre:'Telugu',year:2022,tags:['Friendship','Emotional'],verified:true,energy:50,rating:4.6,views:200000000,mood:'happy',vocal:'Vocal'},
            {id:'8Fl6dEhH4zY',title:'Janani',artist:'M M Kreem',duration:'3:42',language:'Hindi',genre:'Telugu',year:2022,tags:['Emotional','Epic'],verified:true,energy:40,rating:4.5,views:150000000,mood:'sad',vocal:'Vocal'},
            {id:'6R8n6FbQDXI',title:'Komuram Bheemudo',artist:'Kaala Bhairava',duration:'4:24',language:'Hindi',genre:'Telugu',year:2022,tags:['Epic','Power'],verified:true,energy:70,rating:4.7,views:250000000,mood:'energetic',vocal:'Vocal'},
            {id:'KUi9gL3jGQs',title:'Sholay',artist:'Vishal Mishra',duration:'3:52',language:'Hindi',genre:'Bollywood',year:2022,tags:['Love','Melody'],verified:true,energy:55,rating:4.3,views:180000000,mood:'romantic',vocal:'Vocal'},
            {id:'5EqbRjGwJGc',title:'Kesariya Dance Mix',artist:'Arijit Singh',duration:'3:45',language:'Hindi',genre:'Bollywood',year:2022,tags:['Remix','Dance'],verified:true,energy:80,rating:4.2,views:220000000,mood:'party',vocal:'Vocal'},
            {id:'Tc0rSY7pQdE',title:'Raataan Lambiyan',artist:'Jubin Nautiyal',duration:'3:50',language:'Hindi',genre:'Bollywood',year:2021,tags:['Love','Soft'],verified:true,energy:35,rating:4.6,views:500000000,mood:'romantic',vocal:'Vocal'},
            {id:'sFMRqjV7OYg',title:'Ranjha',artist:'Jasleen Royal',duration:'3:48',language:'Hindi',genre:'Bollywood',year:2021,tags:['Love','Emotional'],verified:true,energy:45,rating:4.5,views:450000000,mood:'romantic',vocal:'Vocal'},
            {id:'nzCIeFanr1w',title:'Lut Gaye',artist:'Jubin Nautiyal',duration:'3:50',language:'Hindi',genre:'Bollywood',year:2021,tags:['Love','Tragedy'],verified:true,energy:50,rating:4.4,views:1100000000,mood:'sad',vocal:'Vocal'},
            {id:'NpQ-cW1zcwE',title:'Baarish Ban Jaana',artist:'Stebin Ben',duration:'4:12',language:'Hindi',genre:'Bollywood',year:2021,tags:['Romance','Rain'],verified:true,energy:40,rating:4.3,views:300000000,mood:'romantic',vocal:'Vocal'},
            
            // Spanish (33)
            {id:'kJQP7kiw5Fk',title:'Despacito',artist:'Luis Fonsi',duration:'4:42',language:'Spanish',genre:'Latin',year:2017,tags:['Reggaeton','Global'],verified:true,energy:75,rating:4.6,views:8000000000,mood:'party',vocal:'Vocal'},
            {id:'pRpeEdMmmQ0',title:'Waka Waka',artist:'Shakira',duration:'3:31',language:'Spanish',genre:'Latin',year:2010,tags:['World Cup','Dance'],verified:true,energy:90,rating:4.7,views:3500000000,mood:'workout',vocal:'Vocal'},
            {id:'6Mgqbai3fks',title:'Hips Don\'t Lie',artist:'Shakira',duration:'3:38',language:'Spanish',genre:'Latin',year:2006,tags:['Salsa','Dance'],verified:true,energy:88,rating:4.6,views:1200000000,mood:'party',vocal:'Vocal'},
            {id:'weRHyjj34ZE',title:'Whenever Wherever',artist:'Shakira',duration:'3:16',language:'Spanish',genre:'Latin',year:2001,tags:['Pop','Global'],verified:true,energy:85,rating:4.5,views:600000000,mood:'happy',vocal:'Vocal'},
            {id:'p539c7WVPbg',title:'La Tortura',artist:'Shakira',duration:'3:35',language:'Spanish',genre:'Latin',year:2005,tags:['Reggaeton','Drama'],verified:true,energy:80,rating:4.4,views:450000000,mood:'romantic',vocal:'Vocal'},
            {id:'Dsp_8Mm1e-M',title:'La Bicicleta',artist:'Shakira',duration:'3:49',language:'Spanish',genre:'Latin',year:2016,tags:['Vallenato','Tropical'],verified:true,energy:78,rating:4.3,views:800000000,mood:'happy',vocal:'Vocal'},
            {id:'a5irTX82olg',title:'Chantaje',artist:'Shakira',duration:'3:21',language:'Spanish',genre:'Latin',year:2016,tags:['Reggaeton','Pop'],verified:true,energy:82,rating:4.4,views:2200000000,mood:'party',vocal:'Vocal'},
            {id:'6X3S1uwN5lE',title:'Rabiosa',artist:'Shakira',duration:'3:30',language:'Spanish',genre:'Latin',year:2011,tags:['Merengue','Dance'],verified:true,energy:92,rating:4.3,views:400000000,mood:'party',vocal:'Vocal'},
            {id:'1_zgXRdZ1Vw',title:'Échame La Culpa',artist:'Luis Fonsi',duration:'3:20',language:'Spanish',genre:'Latin',year:2017,tags:['Pop','Dance'],verified:true,energy:80,rating:4.4,views:700000000,mood:'party',vocal:'Vocal'},
            {id:'W3GrSMYdKks',title:'Imposible',artist:'Luis Fonsi',duration:'3:52',language:'Spanish',genre:'Latin',year:2018,tags:['Pop','Ballad'],verified:true,energy:60,rating:4.2,views:350000000,mood:'romantic',vocal:'Vocal'},
            {id:'t3y8qd6EJ04',title:'Gasolina',artist:'Daddy Yankee',duration:'3:15',language:'Spanish',genre:'Reggaeton',year:2004,tags:['Classic','Club'],verified:true,energy:95,rating:4.5,views:1100000000,mood:'party',vocal:'Vocal'},
            {id:'FzG4Wm3jVeM',title:'Dura',artist:'Daddy Yankee',duration:'3:33',language:'Spanish',genre:'Reggaeton',year:2018,tags:['Dance','Viral'],verified:true,energy:90,rating:4.4,views:1800000000,mood:'party',vocal:'Vocal'},
            {id:'bs58Lpsj5SU',title:'Con Calma',artist:'Daddy Yankee',duration:'3:22',language:'Spanish',genre:'Reggaeton',year:2019,tags:['Dance','Remix'],verified:true,energy:85,rating:4.3,views:2200000000,mood:'party',vocal:'Vocal'},
            {id:'XqaiVLiR1lE',title:'Mi Gente',artist:'J Balvin',duration:'3:09',language:'Spanish',genre:'Reggaeton',year:2017,tags:['Global','Dance'],verified:true,energy:92,rating:4.5,views:3200000000,mood:'party',vocal:'Vocal'},
            {id:'w2C8rsHUT3w',title:'Ginza',artist:'J Balvin',duration:'3:11',language:'Spanish',genre:'Reggaeton',year:2015,tags:['Club','Dance'],verified:true,energy:88,rating:4.3,views:900000000,mood:'party',vocal:'Vocal'},
            {id:'9xByMBYKEvc',title:'Ay Vamos',artist:'J Balvin',duration:'3:52',language:'Spanish',genre:'Reggaeton',year:2014,tags:['Latin','Urban'],verified:true,energy:82,rating:4.2,views:800000000,mood:'party',vocal:'Vocal'},
            {id:'-UV0QlmZgTw',title:'La Canción',artist:'J Balvin',duration:'4:03',language:'Spanish',genre:'Latin',year:2019,tags:['Latin Trap','Emotional'],verified:true,energy:50,rating:4.5,views:600000000,mood:'sad',vocal:'Vocal'},
            {id:'1wYNM7--gcU',title:'Livin\' La Vida Loca',artist:'Ricky Martin',duration:'4:03',language:'Spanish',genre:'Latin',year:1999,tags:['Classic','Pop'],verified:true,energy:92,rating:4.6,views:350000000,mood:'party',vocal:'Vocal'},
            {id:'p47fEXGabaY',title:'María',artist:'Ricky Martin',duration:'4:26',language:'Spanish',genre:'Latin',year:1995,tags:['Classic','Salsa'],verified:true,energy:88,rating:4.5,views:250000000,mood:'party',vocal:'Vocal'},
            {id:'nRbXq6M5wfw',title:'She Bangs',artist:'Ricky Martin',duration:'4:05',language:'Spanish',genre:'Latin',year:2000,tags:['Pop','Dance'],verified:true,energy:90,rating:4.2,views:180000000,mood:'party',vocal:'Vocal'},
            {id:'Qzs7s6MYpWo',title:'Vente Pa\' Ca',artist:'Ricky Martin',duration:'4:12',language:'Spanish',genre:'Latin',year:2016,tags:['Pop','Tropical'],verified:true,energy:80,rating:4.3,views:500000000,mood:'romantic',vocal:'Vocal'},
            {id:'XbGs_qK22Po',title:'Bailando',artist:'Enrique Iglesias',duration:'4:00',language:'Spanish',genre:'Latin',year:2014,tags:['Pop','Dance'],verified:true,energy:85,rating:4.5,views:3100000000,mood:'party',vocal:'Vocal'},
            {id:'9sg-A-eS6Ig',title:'Hero',artist:'Enrique Iglesias',duration:'4:24',language:'Spanish',genre:'Latin',year:2001,tags:['Ballad','Love'],verified:true,energy:45,rating:4.7,views:600000000,mood:'romantic',vocal:'Vocal'},
            {id:'jlMq3MU9wig',title:'I Like It',artist:'Enrique Iglesias',duration:'4:00',language:'Spanish',genre:'Latin',year:2010,tags:['Pop','Dance'],verified:true,energy:88,rating:4.4,views:450000000,mood:'party',vocal:'Vocal'},
            {id:'UtF6Jej8yb4',title:'Tonight',artist:'Enrique Iglesias',duration:'4:30',language:'Spanish',genre:'Latin',year:2010,tags:['Pop','Club'],verified:true,energy:82,rating:4.3,views:350000000,mood:'party',vocal:'Vocal'},
            {id:'GsF05NqlC5s',title:'Escape',artist:'Enrique Iglesias',duration:'3:30',language:'Spanish',genre:'Latin',year:2001,tags:['Pop','Love'],verified:true,energy:75,rating:4.5,views:300000000,mood:'romantic',vocal:'Vocal'},
            {id:'nJ3ZM8FDBlg',title:'El Perdón',artist:'Nicky Jam',duration:'3:26',language:'Spanish',genre:'Reggaeton',year:2015,tags:['Reggaeton','Emotional'],verified:true,energy:65,rating:4.6,views:1800000000,mood:'sad',vocal:'Vocal'},
            {id:'3YfNFR6xVyM',title:'Felices Los 4',artist:'Maluma',duration:'4:00',language:'Spanish',genre:'Latin',year:2017,tags:['Reggaeton','Drama'],verified:true,energy:78,rating:4.3,views:1200000000,mood:'romantic',vocal:'Vocal'},
            {id:'PiihjyDdP3E',title:'Corazón',artist:'Maluma',duration:'3:06',language:'Spanish',genre:'Latin',year:2017,tags:['Afrobeat','Dance'],verified:true,energy:85,rating:4.2,views:800000000,mood:'party',vocal:'Vocal'},
            {id:'0GvCLbLxH8o',title:'Hawái',artist:'Maluma',duration:'3:20',language:'Spanish',genre:'Latin',year:2020,tags:['Reggaeton','Breakup'],verified:true,energy:70,rating:4.4,views:1100000000,mood:'sad',vocal:'Vocal'},
            {id:'6O56Xz1rCbM',title:'Despacito Remix',artist:'Luis Fonsi',duration:'3:50',language:'Spanish',genre:'Latin',year:2017,tags:['Pop','Remix'],verified:true,energy:80,rating:4.5,views:900000000,mood:'party',vocal:'Vocal'},
            {id:'dT2owtxkU-M',title:'La La La',artist:'Shakira',duration:'3:42',language:'Spanish',genre:'Latin',year:2014,tags:['World Cup','Pop'],verified:true,energy:85,rating:4.4,views:900000000,mood:'happy',vocal:'Vocal'},
            {id:'5qm8PH4xAss',title:'Stressed Out',artist:'Twenty One Pilots',duration:'3:46',language:'English',genre:'Alternative',year:2015,tags:['Alternative','Relatable'],verified:true,energy:72,rating:4.6,views:2600000000,mood:'focus',vocal:'Vocal'}
        ];
    </script>

    <script>
        function moodifyApp() {
            return {
                sidebarOpen: false,
                currentView: 'home',
                currentMood: null,
                searchQuery: '',
                songs: SONGS_DATA,
                favorites: [],
                recentlyPlayed: [],
                filters: {
                    language: 'Any Language',
                    vocal: 'Both',
                    genre: 'All Genres',
                    year: 'Any Year',
                    sortBy: 'Relevance',
                    energyLevel: 50,
                    quickFilter: 'For You'
                },
                moods: [
                    { id: 'happy', emoji: '😊', label: 'Happy', color: 'yellow-400', shadow: 'rgba(250, 204, 21, 0.3)' },
                    { id: 'sad', emoji: '😢', label: 'Sad', color: 'blue-400', shadow: 'rgba(96, 165, 250, 0.3)' },
                    { id: 'energetic', emoji: '⚡', label: 'Energetic', color: 'orange-400', shadow: 'rgba(251, 146, 60, 0.3)' },
                    { id: 'relaxed', emoji: '😌', label: 'Relaxed', color: 'green-400', shadow: 'rgba(74, 222, 128, 0.3)' },
                    { id: 'romantic', emoji: '❤️', label: 'Romantic', color: 'pink-400', shadow: 'rgba(244, 114, 182, 0.3)' },
                    { id: 'focus', emoji: '🎯', label: 'Focus', color: 'purple-400', shadow: 'rgba(192, 132, 252, 0.3)' },
                    { id: 'party', emoji: '🎉', label: 'Party', color: 'cyan-400', shadow: 'rgba(34, 211, 238, 0.3)' },
                    { id: 'workout', emoji: '💪', label: 'Workout', color: 'red-400', shadow: 'rgba(248, 113, 113, 0.3)' }
                ],
                
                initApp() {
                    const savedFavorites = localStorage.getItem('moodify_favorites');
                    const savedRecent = localStorage.getItem('moodify_recent');
                    if (savedFavorites) this.favorites = JSON.parse(savedFavorites);
                    if (savedRecent) this.recentlyPlayed = JSON.parse(savedRecent);
                },
                
                get filteredSongs() {
                    let result = [...this.songs];
                    
                    // Search filter
                    if (this.searchQuery.trim()) {
                        const q = this.searchQuery.toLowerCase();
                        result = result.filter(s => 
                            s.title.toLowerCase().includes(q) || 
                            s.artist.toLowerCase().includes(q) ||
                            s.genre.toLowerCase().includes(q) ||
                            s.tags.some(t => t.toLowerCase().includes(q))
                        );
                    }
                    
                    // Mood filter
                    if (this.currentMood) {
                        result = result.filter(s => s.mood === this.currentMood);
                    }
                    
                    // Language filter
                    if (this.filters.language !== 'Any Language') {
                        result = result.filter(s => s.language === this.filters.language);
                    }
                    
                    // Vocal filter
                    if (this.filters.vocal !== 'Both') {
                        result = result.filter(s => s.vocal === this.filters.vocal);
                    }
                    
                    // Genre filter
                    if (this.filters.genre !== 'All Genres') {
                        result = result.filter(s => s.genre === this.filters.genre);
                    }
                    
                    // Year filter
                    if (this.filters.year !== 'Any Year') {
                        if (this.filters.year === '2024') {
                            result = result.filter(s => s.year === 2024);
                        } else if (this.filters.year === '2020s') {
                            result = result.filter(s => s.year >= 2020 && s.year <= 2029);
                        } else if (this.filters.year === '2010s') {
                            result = result.filter(s => s.year >= 2010 && s.year <= 2019);
                        } else if (this.filters.year === '2000s') {
                            result = result.filter(s => s.year >= 2000 && s.year <= 2009);
                        } else if (this.filters.year === '1990s') {
                            result = result.filter(s => s.year >= 1990 && s.year <= 1999);
                        }
                    }
                    
                    // Energy filter (±20 range)
                    const energyMin = Math.max(0, parseInt(this.filters.energyLevel) - 20);
                    const energyMax = Math.min(100, parseInt(this.filters.energyLevel) + 20);
                    result = result.filter(s => s.energy >= energyMin && s.energy <= energyMax);
                    
                    // Quick filter pills
                    if (this.filters.quickFilter === 'New Releases') {
                        result = result.filter(s => s.year >= 2020);
                    } else if (this.filters.quickFilter === 'Top Rated') {
                        result = result.filter(s => s.rating >= 4.5);
                    } else if (this.filters.quickFilter === 'Trending') {
                        result = result.filter(s => s.views > 1000000000);
                    }
                    // 'For You' shows all (or could be personalized)
                    
                    // Sort
                    if (this.filters.sortBy === 'Most Popular') {
                        result.sort((a, b) => b.views - a.views);
                    } else if (this.filters.sortBy === 'Newest First') {
                        result.sort((a, b) => b.year - a.year);
                    } else if (this.filters.sortBy === 'Top Rated') {
                        result.sort((a, b) => b.rating - a.rating);
                    }
                    // 'Relevance' keeps default order
                    
                    return result;
                },
                
                get displayedSongs() {
                    if (this.currentView === 'favorites') {
                        return this.filteredSongs.filter(s => this.favorites.includes(s.id));
                    }
                    if (this.currentView === 'recentlyPlayed') {
                        const recentIds = [...this.recentlyPlayed].reverse();
                        const recentSongs = [];
                        for (const id of recentIds) {
                            const song = this.songs.find(s => s.id === id);
                            if (song) recentSongs.push(song);
                        }
                        // Also apply other filters to recent
                        const filteredRecent = recentSongs.filter(s => {
                            if (this.filters.language !== 'Any Language' && s.language !== this.filters.language) return false;
                            if (this.filters.genre !== 'All Genres' && s.genre !== this.filters.genre) return false;
                            if (this.searchQuery.trim()) {
                                const q = this.searchQuery.toLowerCase();
                                return s.title.toLowerCase().includes(q) || s.artist.toLowerCase().includes(q);
                            }
                            return true;
                        });
                        return filteredRecent;
                    }
                    if (this.currentView === 'explore') {
                        return this.filteredSongs;
                    }
                    // Home view - show recommended (filtered + limited or all)
                    return this.filteredSongs;
                },
                
                get favoriteSongs() {
                    return this.songs.filter(s => this.favorites.includes(s.id));
                },
                
                get recentSongs() {
                    const recentIds = [...this.recentlyPlayed].reverse();
                    return recentIds.map(id => this.songs.find(s => s.id === id)).filter(Boolean);
                },
                
                toggleFavorite(id) {
                    if (this.favorites.includes(id)) {
                        this.favorites = this.favorites.filter(fav => fav !== id);
                    } else {
                        this.favorites.push(id);
                    }
                    localStorage.setItem('moodify_favorites', JSON.stringify(this.favorites));
                },
                
                isFavorite(id) {
                    return this.favorites.includes(id);
                },
                
                addToRecent(id) {
                    this.recentlyPlayed = this.recentlyPlayed.filter(rid => rid !== id);
                    this.recentlyPlayed.push(id);
                    if (this.recentlyPlayed.length > 50) {
                        this.recentlyPlayed = this.recentlyPlayed.slice(-50);
                    }
                    localStorage.setItem('moodify_recent', JSON.stringify(this.recentlyPlayed));
                },
                
                applyFilters() {
                    // Filters are reactive, this button just provides UX feedback
                    // The computed properties update automatically
                },
                
                applySidebarFilters() {
                    this.sidebarOpen = false;
                    // Same reactive behavior
                },
                
                resetFilters() {
                    this.filters = {
                        language: 'Any Language',
                        vocal: 'Both',
                        genre: 'All Genres',
                        year: 'Any Year',
                        sortBy: 'Relevance',
                        energyLevel: 50,
                        quickFilter: 'For You'
                    };
                    this.searchQuery = '';
                    this.currentMood = null;
                }
            }
        }
    </script>
</body>
</html>