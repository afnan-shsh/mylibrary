<style>
    .pub-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 24px;
    }
    .pub-welcome {
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }
    html.dark .pub-card    { background: rgb(30 30 30); border-color: rgb(55 55 55); }
    html.dark .pub-welcome { background: rgb(30 30 30); border-color: rgb(55 55 55); }
    html.dark .pub-welcome h2 { color: white !important; }

    .pub-label { color: #6b7280; font-size: 0.85rem; margin-bottom: 8px; }
    .pub-sub   { font-size: 0.8rem; margin-top: 4px; color: #9ca3af; }
    .pub-num   { font-size: 2rem; font-weight: bold; }

    .c-white  { color: #111827; } html.dark .c-white  { color: white; }
    .c-green  { color: #16a34a; } html.dark .c-green  { color: #22c55e; }
    .c-yellow { color: #d97706; } html.dark .c-yellow { color: #f59e0b; }
    .c-red    { color: #dc2626; } html.dark .c-red    { color: #ef4444; }
    .c-blue   { color: #2563eb; } html.dark .c-blue   { color: #3b82f6; }

    html.dark .pub-label { color: #9ca3af; }
</style>

<div style="padding: 4px 0;">

    {{-- الترحيب --}}
    <div class="pub-welcome">
        <h2 style="font-size: 1.5rem; font-weight: bold; margin: 0;">
            Welcome {{ $name }} 👋
        </h2>
    </div>

    {{-- الإحصاءيات --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">

        <div class="pub-card">
            <div class="pub-label">📚 Total Books</div>
            <div class="pub-num c-yellow">{{ $stats['total'] }}</div>
            <div class="pub-sub" style="color:#f59e0b;">All uploaded books</div>
        </div>

        <div class="pub-card">
            <div class="pub-label">✅ Approved</div>
            <div class="pub-num c-green">{{ $stats['approved'] }}</div>
            <div class="pub-sub">Approved books</div>
        </div>

        <div class="pub-card">
            <div class="pub-label">⏳ Pending</div>
            <div class="pub-num c-yellow">{{ $stats['pending'] }}</div>
            <div class="pub-sub">Waiting for review</div>
        </div>

        <div class="pub-card">
            <div class="pub-label">❌ Rejected</div>
            <div class="pub-num c-red">{{ $stats['rejected'] }}</div>
            <div class="pub-sub">Not approved</div>
        </div>

        <div class="pub-card">
            <div class="pub-label">🛒 Sales</div>
            <div class="pub-num c-green">{{ $stats['sales'] }}</div>
            <div class="pub-sub">Books purchased</div>
        </div>

        <div class="pub-card">
            <div class="pub-label">🕐 Rentals</div>
            <div class="pub-num c-blue">{{ $stats['rents'] }}</div>
            <div class="pub-sub">Books rented</div>
        </div>

    </div>
</div>
