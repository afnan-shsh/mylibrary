<style>
    .dash-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 24px;
    }
    /* لما Filament يكون في Dark Mode يضيف class="dark" على html */
    html.dark .dash-card {
        background: rgb(30 30 30);
        border-color: rgb(55 55 55);
    }
    html.dark .dash-welcome {
        background: rgb(30 30 30) !important;
        border-color: rgb(55 55 55) !important;
    }
    html.dark .dash-welcome h2 { color: white; }
    html.dark .dash-label { color: #9ca3af; }

    .dash-welcome {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }
    .dash-label { color: #6b7280; font-size: 0.85rem; margin-bottom: 8px; }
    .dash-num   { font-size: 2rem; font-weight: bold; }
    .dash-sub   { font-size: 0.8rem; margin-top: 4px; color: #9ca3af; }

    .c-white  { color: #111827; } html.dark .c-white  { color: white; }
    .c-green  { color: #16a34a; } html.dark .c-green  { color: #22c55e; }
    .c-yellow { color: #d97706; } html.dark .c-yellow { color: #f59e0b; }
    .c-red    { color: #dc2626; } html.dark .c-red    { color: #ef4444; }
    .c-indigo { color: #4f46e5; } html.dark .c-indigo { color: #818cf8; }
    .c-sky    { color: #0284c7; } html.dark .c-sky    { color: #38bdf8; }
    .c-gold   { color: #b45309; } html.dark .c-gold   { color: #fbbf24; }
</style>

<div style="padding: 4px 0;">

    {{-- بوكس الترحيب --}}
    <div class="dash-welcome">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin: 0;">
            Welcome {{ $name }} 👋
        </h2>
    </div>

    {{-- صف 1: إحصاءيات الكتب --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 16px;">

        <div class="dash-card">
            <div class="dash-label">📚 Total Books</div>
            <div class="dash-num c-yellow">{{ $stats['total'] }}</div>
            <div class="dash-sub" style="color:#f59e0b;">All books in your library</div>
        </div>

        <div class="dash-card">
            <div class="dash-label">✅ Approved</div>
            <div class="dash-num c-green">{{ $stats['approved'] }}</div>
            <div class="dash-sub">Approved books</div>
        </div>

        <div class="dash-card">
            <div class="dash-label">⏳ Pending</div>
            <div class="dash-num c-yellow">{{ $stats['pending'] }}</div>
            <div class="dash-sub">Waiting for review</div>
        </div>

        <div class="dash-card">
            <div class="dash-label">❌ Rejected</div>
            <div class="dash-num c-red">{{ $stats['rejected'] }}</div>
            <div class="dash-sub">Not approved</div>
        </div>

    </div>

    {{-- صف 2: مبيعات واستعارات --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">

        <div class="dash-card">
            <div class="dash-label">🛒 Total Sales</div>
            <div class="dash-num c-indigo">{{ $stats['sales'] }}</div>
            <div class="dash-sub">Books purchased</div>
        </div>

        <div class="dash-card">
            <div class="dash-label">📖 Total Rentals</div>
            <div class="dash-num c-sky">{{ $stats['rents'] }}</div>
            <div class="dash-sub">Books rented</div>
        </div>

        <div class="dash-card">
            <div class="dash-label">🏆 Top Book</div>
            @if($topBook)
                <div class="dash-num c-gold" style="font-size:1rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $topBook->title }}
                </div>
                <div class="dash-sub">{{ $topBook->transactions_count }} transactions</div>
            @else
                <div style="color:#6b7280; font-size:1rem; margin-top:8px;">No data yet</div>
            @endif
        </div>

    </div>

</div>
