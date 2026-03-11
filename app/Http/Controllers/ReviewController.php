<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // تحقق إن القارئ اشترى أو استعار الكتاب
        $hasPurchased = Transaction::where('user_id', auth()->id())
            ->where('book_id', $bookId)
            ->exists();

        if (!$hasPurchased) {
            return back()->withErrors(['review' => 'You must buy or rent this book before reviewing.']);
        }

        // حفظ أو تحديث التقييم
        Review::updateOrCreate(
            ['user_id' => auth()->id(), 'book_id' => $bookId],
            ['rating'  => $request->rating]
        );

        return back()->with('success', 'Review submitted! ⭐');
    }
}
