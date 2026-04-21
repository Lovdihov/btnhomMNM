<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'ThreeX Music' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#0f1021] text-white font-sans antialiased min-h-screen flex flex-col relative">

    <header class="bg-[#0f1021]/80 backdrop-blur-md border-b border-gray-800 py-4 px-6 sticky top-0 z-50">
        <div class="container mx-auto flex items-center justify-between">
            
            <div class="flex items-center gap-6 lg:gap-10">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-purple-400 hover:text-purple-300 whitespace-nowrap">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                    </svg>
                    ThreeX Music
                </a>

                <div class="relative hidden md:block w-48 lg:w-72 z-50">
                    <div class="relative">
                        <input type="text" id="global-search" placeholder="Tìm bài hát, nghệ sĩ, album..." autocomplete="off"
                               class="w-full bg-[#1e2038] border border-gray-700 text-white rounded-full py-2 px-4 pl-10 focus:outline-none focus:border-purple-500 transition shadow-lg text-sm">
                        <svg class="w-4 h-4 absolute left-4 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>

                    <div id="search-results" class="absolute top-full mt-2 w-[150%] left-0 bg-[#1e2038] border border-gray-700 rounded-xl shadow-2xl hidden max-h-[80vh] overflow-y-auto">
                        <div id="search-content" class="p-4"></div>
                    </div>
                </div>
            </div>

            <nav class="hidden xl:flex space-x-6 text-sm font-medium text-gray-300">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-white font-bold' : 'hover:text-white transition' }}">Trang chủ</a>
                <a href="{{ route('charts') }}" class="{{ request()->routeIs('charts') ? 'text-white font-bold' : 'hover:text-white transition' }}">Bảng xếp hạng</a>
                <a href="{{ route('genres') }}" class="{{ request()->routeIs('genres') ? 'text-white font-bold' : 'hover:text-white transition' }}">Thể loại</a>
                <a href="{{ route('artists') }}" class="{{ request()->routeIs('artists') ? 'text-white font-bold' : 'hover:text-white transition' }}">Nghệ sĩ</a>
                <a href="{{ route('albums') }}" class="{{ request()->routeIs('albums') ? 'text-white font-bold' : 'hover:text-white transition' }}">Album</a>
                <a href="{{ route('songs') }}" class="{{ request()->routeIs('songs') ? 'text-white font-bold' : 'hover:text-white transition' }}">Bài hát</a>
                @auth
                    <a href="{{ route('user.favorites') }}" class="{{ request()->routeIs('user.favorites') ? 'text-white font-bold' : 'hover:text-white transition' }}">Yêu thích</a>
                    <a href="{{ route('user.history') }}" class="{{ request()->routeIs('user.history') ? 'text-white font-bold' : 'hover:text-white transition' }}">Lịch sử</a>
                @endauth
            </nav>

            <div class="flex items-center ml-4">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 text-sm font-medium text-gray-300 hover:text-white transition bg-[#1e2038] px-4 py-2 rounded-full border border-gray-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if (Auth::user() && Auth::user()->role_id == 1)
                                <x-dropdown-link :href="route('admin.dashboard')">Quản lý</x-dropdown-link>
                                <div class="border-t border-gray-700"></div>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Đăng xuất
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('register') }}" class="text-sm font-bold text-gray-300 hover:text-white transition">Đăng ký</a>
                        <a href="{{ route('login') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full text-sm font-bold transition shadow-lg shadow-purple-500/30 flex items-center gap-2 whitespace-nowrap">
                            Đăng nhập
                        </a>
                    </div>
                @endauth
            </div>
            
        </div>
    </header>

    <main id="ajax-main-content" class="flex-grow container mx-auto px-4 py-8 pb-28">
        {{ $slot }}
    </main>

    {{-- Global Music Player --}}
    <div id="global-player" class="fixed bottom-0 left-0 right-0 bg-[#0f1021]/95 backdrop-blur-xl border-t border-gray-800 px-4 py-3 z-50 shadow-[0_-10px_30px_rgba(0,0,0,0.5)] flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 w-1/3">
            <img id="player-cover" src="https://via.placeholder.com/50" class="w-12 h-12 rounded-md shadow-md object-cover hidden">
            <div class="overflow-hidden">
                <div id="player-title" class="font-bold text-sm text-white truncate">ThreeX Music</div>
                <div id="player-artist" class="text-xs text-gray-400 truncate">Chọn bài hát để phát</div>
            </div>
            <button id="player-favorite" class="ml-2 text-gray-400 hover:text-red-500 transition hidden">
                <i class="far fa-heart"></i>
            </button>
        </div>

        <div class="flex flex-col items-center w-1/3">
            <div class="flex items-center gap-6 mb-1">
                <button id="btn-random" class="text-gray-400 hover:text-white transition"><i class="fas fa-random"></i></button>
                <button id="btn-prev" class="text-gray-400 hover:text-white transition"><i class="fas fa-step-backward"></i></button>
                
                <button id="btn-play-pause" class="bg-purple-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:scale-105 hover:bg-purple-400 transition shadow-lg shadow-purple-500/30">
                    <i class="fas fa-play ml-1"></i>
                </button>
                
                <button id="btn-next" class="text-gray-400 hover:text-white transition"><i class="fas fa-step-forward"></i></button>
                <button id="btn-repeat" class="text-gray-400 hover:text-white transition"><i class="fas fa-redo"></i></button>
            </div>
            
            <div class="w-full flex items-center gap-2">
                <span id="player-current-time" class="text-[10px] text-gray-500 w-8 text-right">0:00</span>
                <div id="progress-container" class="flex-1 h-1.5 bg-gray-700 rounded-full cursor-pointer relative group">
                    <div id="player-progress" class="absolute top-0 left-0 h-full bg-purple-500 rounded-full w-0 group-hover:bg-purple-400 transition-all pointer-events-none"></div>
                </div>
                <span id="player-duration" class="text-[10px] text-gray-500 w-8">0:00</span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 w-1/3">
            <button class="text-gray-400 hover:text-white transition"><i class="fas fa-list-ul"></i></button>
            <i id="volume-icon" class="fas fa-volume-up text-gray-400 text-sm"></i>
            <div id="volume-container" class="w-24 h-1.5 bg-gray-700 rounded-full cursor-pointer relative">
                <div id="volume-progress" class="absolute top-0 left-0 h-full bg-white rounded-full w-[100%] pointer-events-none transition-all"></div>
            </div>
        </div>
    </div>

    <audio id="main-audio" src=""></audio>

    @stack('scripts')

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? null;
        const audio = document.getElementById('main-audio');
        const playBtn = document.getElementById('btn-play-pause');
        const progressBar = document.getElementById('player-progress');
        const progressContainer = document.getElementById('progress-container');
        const currentTimeEl = document.getElementById('player-current-time');
        const durationEl = document.getElementById('player-duration');
        const coverImg = document.getElementById('player-cover');
        const favBtn = document.getElementById('player-favorite');

        let currentPlayingSongId = null;
        let currentPlaylist = [];
        let currentIndex = -1;
        let isRandom = false;
        let isRepeat = false;

        // 1. PHÁT NHẠC CỐT LÕI
        function corePlaySong(url, title, cover, artist, songId) {
            if (!url || url === 'null') {
                alert('Không tìm thấy nguồn nhạc!');
                return;
            }

            document.getElementById('player-title').innerText = title;
            document.getElementById('player-artist').innerText = artist;
            coverImg.src = cover || 'https://via.placeholder.com/50';
            coverImg.classList.remove('hidden');
            
            if (favBtn) {
                favBtn.classList.remove('hidden');
                favBtn.setAttribute('data-song-id', songId);
                favBtn.onclick = function() { toggleFavorite(songId, this); };
            }

            if (songId && songId !== currentPlayingSongId && csrfToken) {
                // Sync player with server stats/history via AJAX when a new song starts.
                fetch(`/songs/${songId}/play`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).catch(err => console.error(err));
                currentPlayingSongId = songId;
            }

            audio.src = url;
            audio.play().catch(e => console.log("Yêu cầu tương tác để phát nhạc"));
            if (playBtn) playBtn.innerHTML = '<i class="fas fa-pause"></i>';
        }

        // 2. PHÁT NHẠC TỪ GIAO DIỆN
        window.playSong = function(url, title, cover, artist, songId) {
            try {
                buildPlaylist();
                currentIndex = currentPlaylist.findIndex(song => song.songId == songId);
            } catch (e) { console.error(e); }
            corePlaySong(url, title, cover, artist, songId);
        };

        // 3. ĐIỀU KHIỂN & TIẾN TRÌNH
        if (playBtn) {
            playBtn.addEventListener('click', () => {
                if (!audio.src) return;
                if (audio.paused) {
                    audio.play();
                    playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                } else {
                    audio.pause();
                    playBtn.innerHTML = '<i class="fas fa-play ml-1"></i>';
                }
            });
        }

        audio.addEventListener('timeupdate', () => {
            if (audio.duration && progressBar) {
                const progressPercent = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = `${progressPercent}%`;
                if (currentTimeEl) currentTimeEl.innerText = formatTime(audio.currentTime);
            }
        });

        audio.addEventListener('loadedmetadata', () => {
            if (durationEl) durationEl.innerText = formatTime(audio.duration);
        });

        if (progressContainer) {
            progressContainer.addEventListener('click', (e) => {
                if (!audio.src || !audio.duration) return;
                const width = progressContainer.clientWidth;
                audio.currentTime = (e.offsetX / width) * audio.duration;
            });
        }

        function formatTime(seconds) {
            if (isNaN(seconds)) return '0:00';
            const min = Math.floor(seconds / 60);
            const sec = Math.floor(seconds % 60);
            return `${min}:${sec < 10 ? '0' : ''}${sec}`;
        }

        // 4. CHỈNH ÂM LƯỢNG
        const volumeContainer = document.getElementById('volume-container');
        const volumeProgress = document.getElementById('volume-progress');
        const volumeIcon = document.getElementById('volume-icon');

        if (volumeContainer) {
            audio.volume = 1;
            const updateVolume = (e) => {
                const rect = volumeContainer.getBoundingClientRect();
                let newVolume = Math.max(0, Math.min(1, (e.clientX - rect.left) / rect.width)); 
                audio.volume = newVolume;
                if (volumeProgress) volumeProgress.style.width = `${newVolume * 100}%`;
                if (volumeIcon) {
                    if (newVolume === 0) volumeIcon.className = 'fas fa-volume-mute text-gray-400 text-sm';
                    else if (newVolume < 0.5) volumeIcon.className = 'fas fa-volume-down text-gray-400 text-sm';
                    else volumeIcon.className = 'fas fa-volume-up text-gray-400 text-sm';
                }
            };

            volumeContainer.addEventListener('mousedown', (e) => {
                updateVolume(e); 
                const move = (ev) => updateVolume(ev);
                const stop = () => {
                    document.removeEventListener('mousemove', move);
                    document.removeEventListener('mouseup', stop);
                };
                document.addEventListener('mousemove', move);
                document.addEventListener('mouseup', stop);
            });
        }

        // 5. PLAYLIST LOGIC
        function buildPlaylist() {
            currentPlaylist = [];
            const elements = document.querySelectorAll('[onclick^="playSong"], [onclick*=" playSong"]');
            elements.forEach(el => {
                const match = el.getAttribute('onclick').match(/playSong\('([^']*)',\s*'([^']*)',\s*'([^']*)',\s*'([^']*)',\s*(\d+)\)/);
                if (match) {
                    const song = { url: match[1], title: match[2], cover: match[3], artist: match[4], songId: parseInt(match[5]) };
                    if (!currentPlaylist.find(s => s.songId === song.songId)) currentPlaylist.push(song);
                }
            });
        }

        function playNextSong() {
            if (currentPlaylist.length === 0) return;
            if (isRandom) {
                let r; do { r = Math.floor(Math.random() * currentPlaylist.length); } while (r === currentIndex && currentPlaylist.length > 1);
                currentIndex = r;
            } else { currentIndex = (currentIndex + 1) % currentPlaylist.length; }
            const s = currentPlaylist[currentIndex];
            if (s) corePlaySong(s.url, s.title, s.cover, s.artist, s.songId);
        }

        function playPrevSong() {
            if (currentPlaylist.length === 0) return;
            currentIndex = currentIndex - 1 < 0 ? currentPlaylist.length - 1 : currentIndex - 1;
            const s = currentPlaylist[currentIndex];
            if (s) corePlaySong(s.url, s.title, s.cover, s.artist, s.songId);
        }

        document.getElementById('btn-next')?.addEventListener('click', playNextSong);
        document.getElementById('btn-prev')?.addEventListener('click', playPrevSong);
        document.getElementById('btn-random')?.addEventListener('click', function() {
            isRandom = !isRandom;
            this.classList.toggle('text-purple-500', isRandom);
            this.classList.toggle('text-gray-400', !isRandom);
        });
        document.getElementById('btn-repeat')?.addEventListener('click', function() {
            isRepeat = !isRepeat;
            this.classList.toggle('text-purple-500', isRepeat);
            this.classList.toggle('text-gray-400', !isRepeat);
        });

        audio.addEventListener('ended', () => {
            if (isRepeat) { audio.currentTime = 0; audio.play(); } else { playNextSong(); }
        });

        // 6. THẢ TIM & TÌM KIẾM
        window.toggleFavorite = function(songId, buttonElement) {
            if (!csrfToken) return alert("Vui lòng đăng nhập!");
            fetch(`/songs/${songId}/favorite`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            })
            .then(res => res.status === 401 ? (window.location.href = '/login') : res.json())
            .then(data => {
                if (data.status === 'added') {
                    buttonElement.classList.add('text-pink-500');
                    buttonElement.classList.remove('text-gray-400');
                } else {
                    buttonElement.classList.remove('text-pink-500');
                    buttonElement.classList.add('text-gray-400');
                }
            }).catch(err => console.error(err));
        };

        window.toggleFavoriteArtist = function(artistId, buttonElement) {
            if (!csrfToken) return alert("Vui lòng đăng nhập!");

            fetch(`/artists/${artistId}/favorite`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            })
            .then(res => res.status === 401 ? (window.location.href = '/login') : res.json())
            .then(data => {
                const icon = buttonElement.querySelector('i');

                if (data.status === 'added') {
                    buttonElement.classList.add('text-pink-500');
                    buttonElement.classList.remove('text-gray-500', 'text-gray-400');
                    if (icon) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    }
                } else {
                    buttonElement.classList.remove('text-pink-500');
                    buttonElement.classList.add('text-gray-500');
                    if (icon) {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                }
            })
            .catch(err => console.error(err));
        };

        const searchInput = document.getElementById('global-search');
        const searchResults = document.getElementById('search-results');
        const searchContent = document.getElementById('search-content');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const kw = this.value.trim();
                if (kw.length === 0) { searchResults.classList.add('hidden'); return; }
                searchTimeout = setTimeout(() => {
                    fetch('/tim-kiem', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: JSON.stringify({ keyword: kw })
                    })
                    .then(res => res.json())
                    .then(data => renderSearchResults(data, kw))
                    .catch(err => console.error(err));
                }, 500);
            });
            document.addEventListener('click', e => {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) searchResults.classList.add('hidden');
            });
        }

        function renderSearchResults(data, keyword) {
            let html = '';
            if (data.songs?.length > 0) {
                html += `<h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Bài hát</h4>`;
                data.songs.forEach(s => {
                    const t = s.title.replace(/'/g, "\\'");
                    const a = s.artists ? s.artists.map(ar => ar.name).join(', ').replace(/'/g, "\\'") : '';
                    html += `<div onclick="playSong('${s.audio_url}', '${t}', '${s.cover_url}', '${a}', ${s.id})" class="flex items-center gap-3 p-2 hover:bg-white/10 rounded-lg cursor-pointer mb-1 group"><img src="${s.cover_url || 'https://via.placeholder.com/50'}" class="w-10 h-10 rounded object-cover"><div class="flex-1 overflow-hidden"><div class="text-sm font-bold text-white truncate">${s.title}</div><div class="text-xs text-gray-400 truncate">${a}</div></div></div>`;
                });
            }
            if (data.artists?.length > 0) {
                html += `<h4 class="text-xs font-bold text-gray-400 uppercase mb-2 mt-4">Nghệ sĩ</h4>`;
                data.artists.forEach(ar => {
                    html += `<a href="/nghe-si/${ar.id}" class="flex items-center gap-3 p-2 hover:bg-white/10 rounded-lg cursor-pointer mb-1 group"><img src="${ar.avatar_url || 'https://via.placeholder.com/50'}" class="w-10 h-10 rounded-full object-cover"><div class="flex-1 overflow-hidden"><div class="text-sm font-bold text-white truncate">${ar.name}</div></div></a>`;
                });
            }
            if (data.albums?.length > 0) {
                html += `<h4 class="text-xs font-bold text-gray-400 uppercase mb-2 mt-4">Album</h4>`;
                data.albums.forEach(al => {
                    const art = al.artist ? al.artist.name.replace(/'/g, "\\'") : '';
                    html += `<a href="/album/${al.id}" class="flex items-center gap-3 p-2 hover:bg-white/10 rounded-lg cursor-pointer mb-1 group"><img src="${al.cover_url || 'https://via.placeholder.com/50'}" class="w-10 h-10 rounded object-cover"><div class="flex-1 overflow-hidden"><div class="text-sm font-bold text-white truncate">${al.title}</div><div class="text-xs text-gray-400 truncate">${art}</div></div></a>`;
                });
            }
            searchContent.innerHTML = html || `<div class="text-center text-gray-500 py-4">Không tìm thấy "${keyword}"</div>`;
            searchResults.classList.remove('hidden');
        }

        // 7. AJAX PAGE NAVIGATION (keep player alive between pages)
        const ajaxMainContent = document.getElementById('ajax-main-content');
        let ajaxRequestController = null;

        function shouldUseAjaxNavigation(link, event) {
            if (!link || !ajaxMainContent) return false;
            if (event.defaultPrevented || event.button !== 0) return false;
            if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return false;
            if (link.target && link.target !== '_self') return false;
            if (link.hasAttribute('download')) return false;
            if ((link.getAttribute('href') || '').startsWith('#')) return false;
            if (link.closest('#search-results')) return false;

            const url = new URL(link.href, window.location.origin);
            if (url.origin !== window.location.origin) return false;

            // Keep auth/admin flows as full page loads.
            if (url.pathname.startsWith('/admin') || url.pathname === '/logout') return false;

            return true;
        }

        function executeInlineScripts(scopeEl) {
            const scripts = scopeEl.querySelectorAll('script');
            scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                Array.from(oldScript.attributes).forEach(attr => {
                    newScript.setAttribute(attr.name, attr.value);
                });
                newScript.textContent = oldScript.textContent;
                oldScript.parentNode.replaceChild(newScript, oldScript);
            });
        }

        function updateHeaderActiveState(pathname) {
            const navLinks = document.querySelectorAll('header nav a[href]');
            navLinks.forEach(link => {
                const url = new URL(link.href, window.location.origin);
                const isActive = url.pathname === pathname;
                link.classList.toggle('text-white', isActive);
                link.classList.toggle('font-bold', isActive);
                if (!isActive) {
                    link.classList.add('hover:text-white', 'transition');
                }
            });
        }

        async function loadPageWithAjax(url, options = {}) {
            const { pushState = true, scrollTop = true } = options;

            if (ajaxRequestController) ajaxRequestController.abort();
            ajaxRequestController = new AbortController();

            ajaxMainContent.classList.add('opacity-70', 'pointer-events-none');

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-AJAX-NAV': '1'
                    },
                    signal: ajaxRequestController.signal
                });

                if (!response.ok) throw new Error(`Navigation failed: ${response.status}`);

                const html = await response.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newMainContent = doc.getElementById('ajax-main-content') || doc.querySelector('main');

                if (!newMainContent) {
                    window.location.href = url;
                    return;
                }

                ajaxMainContent.innerHTML = newMainContent.innerHTML;
                executeInlineScripts(ajaxMainContent);

                if (doc.title) document.title = doc.title;
                if (pushState) window.history.pushState({}, '', url);
                if (scrollTop) window.scrollTo({ top: 0, behavior: 'auto' });

                updateHeaderActiveState(new URL(url, window.location.origin).pathname);
            } catch (error) {
                if (error.name !== 'AbortError') {
                    window.location.href = url;
                }
            } finally {
                ajaxMainContent.classList.remove('opacity-70', 'pointer-events-none');
            }
        }

        document.addEventListener('click', (event) => {
            const link = event.target.closest('a[href]');
            if (!shouldUseAjaxNavigation(link, event)) return;

            event.preventDefault();
            loadPageWithAjax(link.href);
        });

        window.addEventListener('popstate', () => {
            loadPageWithAjax(window.location.href, { pushState: false, scrollTop: false });
        });
    </script>
</body>
</html>