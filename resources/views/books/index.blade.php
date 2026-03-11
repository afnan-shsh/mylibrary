@extends('layouts.reader')

@section('content')

<div class="books-page">

    <div class="search-wrap">
        <form method="GET" action="{{ route('books.index') }}" class="search-form">
            <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}">
            <button type="submit">🔍</button>
        </form>
    </div>

    @if($bestSellers->count() > 0)
    <div class="section-header">
        <h2>🏆 Best Sellers</h2>
        <div class="section-divider"></div>
    </div>
    <div class="bestsellers-grid">
        @foreach($bestSellers as $i => $bs)
        <a href="{{ route('books.show', $bs->id) }}" class="bestseller-card">
            <div class="bs-rank">#{{ $i + 1 }}</div>
            <div class="bs-cover">
                @if($bs->cover)
                    <img src="{{ asset('storage/' . $bs->cover) }}" alt="{{ $bs->title }}">
                @else 📗 @endif
            </div>
            <div class="bs-info">
                <div class="bs-title">{{ $bs->title }}</div>
                <div class="bs-publisher">{{ $bs->publisher->name ?? 'Unknown' }}</div>
                <div class="bs-stats">
                    <span class="bs-stat">🛒 {{ $bs->sales_count }}</span>
                    <span class="bs-stat">📖 {{ $bs->rents_count }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

    <div class="section-header">
        <h2>📚 Discover Books</h2>
        <div class="section-divider"></div>
    </div>

    <div class="books-grid">
        @forelse($books as $book)
        <div class="book-card">
            <a href="{{ route('books.show', $book->id) }}" class="book-cover-link">
                <div class="book-cover">
                    @if($book->cover)
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}">
                    @else 📗 @endif
                    <div class="book-cover-overlay">View Details →</div>
                </div>
            </a>
            <div class="book-body">
                <div class="book-badges">
                    @if($book->created_at->diffInDays(now()) <= 30)
                        <span class="badge badge-new">New</span>
                    @endif
                    @if($book->isOwned)
                        <span class="badge badge-owned">✓ Owned</span>
                    @elseif($book->isMyRent)
                        <span class="badge badge-rented">📖 Renting</span>
                    @else
                        <span class="badge badge-available">Available</span>
                    @endif
                </div>
                <div class="book-title">{{ $book->title }}</div>
                <div class="book-publisher">By {{ $book->publisher->name ?? 'Unknown Publisher' }}</div>
                @if($book->price)
                    <div class="book-price">${{ $book->price }}</div>
                @endif
                <a href="{{ route('books.show', $book->id) }}" class="btn-details">View Details</a>
            </div>
        </div>
        @empty
            <div class="empty-books">
                <div class="icon">📭</div>
                <p>No books found.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection
