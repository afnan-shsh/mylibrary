<?php

namespace App\Filament\Library\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\Book;
use App\Models\Transaction;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home';

    public function getTitle(): string { return ''; }
    public function getHeading(): string { return ''; }
    public function getSubheading(): ?string { return null; }

    protected function getHeaderWidgets(): array { return []; }
    protected function getFooterWidgets(): array { return []; }

    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        $libraryId = auth()->id();

        // IDs الكتب المعتمدة في هذه المكتبة
        $approvedBookIds = Book::where('library_id', $libraryId)
            ->where('status', 'approved')
            ->pluck('id');

        $stats = [
            'total'    => Book::where('library_id', $libraryId)->count(),
            'approved' => Book::where('library_id', $libraryId)->where('status', 'approved')->count(),
            'pending'  => Book::where('library_id', $libraryId)->where('status', 'pending')->count(),
            'rejected' => Book::where('library_id', $libraryId)->where('status', 'rejected')->count(),
            'sales'    => Transaction::whereIn('book_id', $approvedBookIds)->where('type', 'sale')->count(),
            'rents'    => Transaction::whereIn('book_id', $approvedBookIds)->where('type', 'rent')->count(),
        ];

        // أكثر كتاب مبيعاً
        $topBook = Book::where('library_id', $libraryId)
            ->where('status', 'approved')
            ->withCount('transactions')
            ->orderByDesc('transactions_count')
            ->first();

        return view('filament.library.pages.dashboard-header', [
            'name'    => auth()->user()->name,
            'stats'   => $stats,
            'topBook' => $topBook,
        ]);
    }
}
