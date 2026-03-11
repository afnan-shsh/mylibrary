@extends('layouts.reader')

@section('content')

<div class="show-page">

    <a href="{{ route('books.index') }}" class="back-link">← Back to Books</a>

    <div class="show-wrapper">

        {{-- left: cover --}}
        <div class="show-left">
            <div class="show-cover-wrap">
                @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}" class="show-cover-img">
                @else
                    <div class="show-cover-placeholder">📗</div>
                @endif
            </div>

            <div class="show-stats">
                <div class="show-stat">
                    <span class="show-stat-num">{{ $book->transactions()->where('type','sale')->count() }}</span>
                    <span class="show-stat-label">🛒 Sales</span>
                </div>
                <div class="show-stat">
                    <span class="show-stat-num">{{ $book->transactions()->where('type','rent')->count() }}</span>
                    <span class="show-stat-label">📖 Rentals</span>
                </div>
            </div>
        </div>

        {{-- right: info --}}
        <div class="show-right">

            @if($isRented && !$alreadyOwned)
                <span class="show-status-badge rented">Currently Rented</span>
            @elseif($alreadyOwned)
                <span class="show-status-badge owned">You Own This</span>
            @else
                <span class="show-status-badge available">Available</span>
            @endif

            <h1 class="show-title">{{ $book->title }}</h1>

            <p class="show-meta">
                📚 By <strong>{{ $book->publisher->name ?? 'Unknown Publisher' }}</strong>
                &nbsp;·&nbsp;
                🏛️ {{ $book->library->name ?? 'Unknown Library' }}
            </p>

            {{-- التقييم العام --}}
            <div class="show-rating-wrap">
                <div class="show-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <span class="star filled">★</span>
                        @else
                            <span class="star empty">★</span>
                        @endif
                    @endfor
                </div>
                <span class="show-rating-text">
                    {{ $avgRating > 0 ? number_format($avgRating, 1) : 'No ratings' }}
                    @if($reviewsCount > 0)
                        <span style="color:#9ca3af;">({{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }})</span>
                    @endif
                </span>
            </div>

            <div class="show-description">{{ $book->description }}</div>

            @if($book->price)
            <div class="show-price">
                ${{ $book->price }}
                <span class="show-type">{{ ucfirst($book->type ?? 'buy') }}</span>
            </div>
            @endif

            <hr class="show-divider">

            {{-- Actions --}}
            @auth
                @if($alreadyOwned)
                    <div class="show-owned-msg">✅ You already own or have rented this book.</div>
                @elseif($isRented)
                    <div class="show-rented-msg">⏳ This book is currently rented by someone else.</div>
                @else
                    <div class="show-actions">
                        <form action="{{ route('books.buy', $book->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-buy">🛒 Buy Now</button>
                        </form>
                        <a href="{{ route('rent.page', $book->id) }}" class="btn-rent">📖 Rent</a>
                    </div>
                @endif

                {{-- نظام التقييم --}}
                @if($canReview)
                <div class="review-section">
                    <hr class="show-divider">
                    <h3 class="review-title">
                        {{ $userReview ? '✏️ Update Your Rating' : '⭐ Rate This Book' }}
                    </h3>

                    @if(session('success'))
                        <div class="review-success">✅ {{ session('success') }}</div>
                    @endif

                    <form action="{{ route('reviews.store', $book->id) }}" method="POST" class="star-form">
                        @csrf
                        <div class="star-input">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}"
                                    {{ ($userReview && $userReview->rating == $i) ? 'checked' : '' }}>
                                <label for="star{{ $i }}">★</label>
                            @endfor
                        </div>
                        <button type="submit" class="review-btn">Submit Rating</button>
                    </form>
                </div>
                @endif

            @else
                <a href="{{ route('login') }}" class="btn-login-prompt">🔐 Login to Buy or Rent</a>
            @endauth

        </div>
    </div>
</div>

@endsection
