<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Book;

class TransactionController extends Controller
{
    public function rent(Request $request, Book $book)
    {
        $request->validate([
            'rent_start' => 'required|date',
            'rent_end' => 'required|date|after:rent_start',
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'type' => 'rent',
            'rent_start' => $request->rent_start,
            'rent_end' => $request->rent_end,
        ]);

        return back()->with('success', 'Book rented successfully!');
    }

    public function buy(Book $book)
    {
        Transaction::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'type' => 'sale',
        ]);

        return back()->with('success', 'Book purchased successfully!');
    }

    public function myBooks()
{
    $transactions = \App\Models\Transaction::where('user_id', auth()->id())
        ->where(function($query){
            $query->where('type', 'sale')
                ->orWhere(function($q){
                    $q->where('type', 'rent')
                        ->whereDate('rent_end', '>=', now());
                });
        })
        ->with('book.publisher')
        ->get();

    return view('transactions.my-books', compact('transactions'));
}
}
