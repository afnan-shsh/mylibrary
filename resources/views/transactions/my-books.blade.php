@extends('layouts.reader')

@section('content')

<div class="mybooks-page">

    <div class="section-header">
        <h2>📚 My Books</h2>
        <div class="section-divider"></div>
        <a href="{{ route('books.index') }}" class="mybooks-browse">+ Browse More</a>
    </div>

    @if($transactions->isEmpty())
        <div class="empty-state">
            <div class="icon">📭</div>
            <p>You haven't bought or rented any books yet.</p>
            <a href="{{ url('/books') }}">Browse Books</a>
        </div>
    @else
        <div class="mybooks-grid">
            @foreach($transactions as $transaction)
            <div class="mybook-card">
                {{-- Cover --}}
                <a href="{{ route('books.show', $transaction->book->id) }}" class="mybook-cover-link">
                    <div class="mybook-cover">
                        @if($transaction->book->cover)
                            <img src="{{ asset('storage/' . $transaction->book->cover) }}" alt="{{ $transaction->book->title }}">
                        @else
                            📗
                        @endif
                    </div>
                </a>

                <div class="mybook-body">
                    {{-- Badge --}}
                    @if($transaction->type === 'sale')
                        <span class="mybook-badge purchased">✅ Purchased</span>
                    @else
                        <span class="mybook-badge renting">📖 Renting</span>
                    @endif

                    <div class="mybook-title">{{ $transaction->book->title }}</div>
                    <div class="mybook-library">
                        🏛️ {{ $transaction->book->library->name ?? 'Unknown Library' }}
                    </div>

                    @if($transaction->type === 'rent')
                        <div class="mybook-expiry">
                            ⏳ Until <span>{{ \Carbon\Carbon::parse($transaction->rent_end)->format('d M Y') }}</span>
                        </div>
                    @endif

                    <a href="{{ route('books.show', $transaction->book->id) }}" class="mybook-btn">View Book</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif

</div>

@endsection
