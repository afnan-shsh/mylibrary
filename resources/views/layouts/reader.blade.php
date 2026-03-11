<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Library') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark-early');
        }
    </script>
</head>
<body>

<header class="navbar" style="display:flex; justify-content:space-between; align-items:center; padding:15px 40px;">
    <div class="logo">📚 MyLibrary</div>

    <nav style="display:flex; align-items:center; gap:20px;">
        <button id="darkToggle" class="dark-btn"></button>
        <a href="{{ url('/books') }}">Books</a>

        @auth
            @if(auth()->user()->role === 'reader')
                <a href="{{ route('my.books') }}">My Books</a>
            @endif

            <div style="position:relative;">
                {{-- الدائرة --}}
                <div id="userCircle" style="
                    width:35px; height:35px; border-radius:50%;
                    background:#4f46e5; color:white; display:flex;
                    align-items:center; justify-content:center;
                    font-weight:bold; text-transform:uppercase; cursor:pointer;
                    font-size:0.9rem; user-select:none;
                ">{{ substr(auth()->user()->name, 0, 1) }}</div>

                {{-- Dropdown --}}
                <div id="userDropdown" style="
                    display:none; position:absolute; top:45px; right:0;
                    background:white; border:1px solid #e5e7eb; border-radius:12px;
                    min-width:210px;
                    box-shadow:0 8px 24px rgba(0,0,0,0.12); z-index:100;
                    overflow:hidden;
                ">
                    {{-- معلومات المستخدم --}}
                    <div style="padding:14px 16px; border-bottom:1px solid #f3f4f6;">
                        <div style="font-weight:600; color:#111827; font-size:0.9rem; margin-bottom:3px;">
                            {{ auth()->user()->name }}
                        </div>
                        <div style="color:#9ca3af; font-size:0.78rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            {{ auth()->user()->email }}
                        </div>
                    </div>

                    <div style="padding:6px;">
                        @if(in_array(auth()->user()->role, ['publisher', 'library', 'admin']))
                            @php $dashUrl = match(auth()->user()->role) {
                                'publisher' => '/publisher',
                                'library'   => '/library',
                                'admin'     => '/admin',
                            }; @endphp
                            <a href="{{ $dashUrl }}" style="
                                display:block; padding:8px 10px; color:#374151;
                                text-decoration:none; border-radius:6px; font-size:0.88rem;
                            "
                            onmouseover="this.style.background='#f3f4f6'"
                            onmouseout="this.style.background='transparent'">
                                📊 Dashboard
                            </a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" style="
                                background:none; border:none; color:#e11d48;
                                font-weight:600; cursor:pointer; width:100%;
                                text-align:left; padding:8px 10px; font-size:0.88rem;
                                border-radius:6px; font-family:inherit;
                            "
                            onmouseover="this.style.background='#fef2f2'"
                            onmouseout="this.style.background='transparent'">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="login-nav-btn">Login</a>
        @endguest
    </nav>
</header>

@if(request()->routeIs('books.index'))
<section class="hero">
    <h1>Discover Your Next Favorite Book</h1>
    <p>Explore, Rent, and Enjoy Reading 📖</p>
</section>
@endif

<main class="container">
    @if(session('success'))
        <div style="background:#16a34a; color:white; padding:10px; text-align:center; border-radius:8px; margin-bottom:16px;">
            {{ session('success') }}
        </div>
    @endif
    @yield('content')
</main>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    // Dark Mode
    const darkBtn = document.getElementById('darkToggle');
    if (localStorage.getItem('darkMode') === 'true') document.body.classList.add('dark');
    darkBtn.addEventListener('click', () => {
        document.body.classList.toggle('dark');
        localStorage.setItem('darkMode', document.body.classList.contains('dark'));
    });

    // User Dropdown
    const circle = document.getElementById('userCircle');
    const dropdown = document.getElementById('userDropdown');
    if (circle) {
        circle.addEventListener('click', () => {
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });
        document.addEventListener('click', e => {
            if (!circle.contains(e.target) && !dropdown.contains(e.target))
                dropdown.style.display = 'none';
        });
    }
</script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
