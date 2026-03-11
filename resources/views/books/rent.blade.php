@extends('layouts.reader')

@section('content')

<div class="rent-page">

    <a href="{{ route('books.show', $book->id) }}" class="back-link">← Back to Book</a>

    <div class="rent-wrapper">

        {{-- Left: Book Info --}}
        <div class="rent-left">
            <div class="rent-cover">
                @if($book->cover)
                    <img src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}">
                @else
                    <div class="rent-cover-placeholder">📗</div>
                @endif
            </div>
            <div class="rent-book-info">
                <div class="rent-book-title">{{ $book->title }}</div>
                <div class="rent-book-publisher">{{ $book->publisher->name ?? 'Unknown Publisher' }}</div>
                @if($book->price)
                    <div class="rent-book-price">${{ $book->price }} / period</div>
                @endif
            </div>
        </div>

        {{-- Right: Form --}}
        <div class="rent-right">
            <div class="rent-badge">📖 Rent This Book</div>
            <h1 class="rent-title">Choose Your Rental Period</h1>
            <p class="rent-sub">Select start and end dates for your rental.</p>

            @if(session('success'))
                <div class="rent-success">✅ {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="rent-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <form action="{{ route('books.rent', $book->id) }}" method="POST" class="rent-form">
                @csrf

                <div class="rent-field">
                    <label>📅 Start Date & Time</label>
                    <input type="datetime-local" name="rent_start"
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        required>
                </div>

                <div class="rent-field">
                    <label>🏁 End Date & Time</label>
                    <input type="datetime-local" name="rent_end"
                        min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                        required>
                </div>

                <div class="rent-info-box">
                    💡 You can rent for any duration. The book will be available in <strong>My Books</strong> until the end date.
                </div>

                <button type="submit" class="rent-btn">Confirm Rental →</button>

            </form>
        </div>

    </div>
</div>

@endsection
