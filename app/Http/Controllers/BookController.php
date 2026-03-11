<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\Review;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['publisher'])->approved();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $books = $query->get();

        foreach ($books as $book) {
            // هل القارئ الحالي يمتلكه (sale)
            $book->isOwned = auth()->check()
                ? Transaction::where('user_id', auth()->id())
                    ->where('book_id', $book->id)
                    ->where('type', 'sale')
                    ->exists()
                : false;

            // هل القارئ الحالي يستعيره هو 
            $book->isMyRent = auth()->check()
                ? Transaction::where('user_id', auth()->id())
                    ->where('book_id', $book->id)
                    ->where('type', 'rent')
                    ->whereDate('rent_end', '>=', now())
                    ->exists()
                : false;
        }

        $bestSellers = Book::approved()
            ->with(['publisher'])
            ->withCount([
                'transactions',
                'transactions as sales_count' => fn($q) => $q->where('type', 'sale'),
                'transactions as rents_count'  => fn($q) => $q->where('type', 'rent'),
            ])
            ->orderByDesc('transactions_count')
            ->take(3)
            ->get();

        return view('books.index', compact('books', 'bestSellers'));
    }

    public function show(Book $book)
    {
        if ($book->status !== 'approved') abort(404);
        $book->load('publisher');

        $alreadyOwned = false;
        $alreadyRented = false;
        $canReview    = false;
        $userReview   = null;

        if (auth()->check()) {
            $alreadyOwned = Transaction::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->where('type', 'sale')
                ->exists();

            $alreadyRented = Transaction::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->where('type', 'rent')
                ->whereDate('rent_end', '>=', now())
                ->exists();

            $canReview = Transaction::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->exists();

            $userReview = Review::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->first();
        }

        $avgRating    = Review::where('book_id', $book->id)->avg('rating') ?? 0;
        $reviewsCount = Review::where('book_id', $book->id)->count();

        // isRented = القارئ الحالي فقط
        $isRented = $alreadyRented;

        return view('books.show', compact(
            'book', 'alreadyOwned', 'isRented',
            'canReview', 'userReview', 'avgRating', 'reviewsCount'
        ));
    }

    public function buy(Book $book)
    {
        Transaction::create([
            'user_id'    => auth()->id(),
            'book_id'    => $book->id,
            'type'       => 'sale',
            'rent_start' => now(),
            'rent_end'   => null,
        ]);

        return back()->with('success', 'Book purchased successfully!');
    }
}
