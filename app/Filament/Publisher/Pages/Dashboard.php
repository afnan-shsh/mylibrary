<?php

namespace App\Filament\Publisher\Pages;

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

    // لا widgets خالص
    protected function getHeaderWidgets(): array { return []; }
    protected function getFooterWidgets(): array { return []; }

    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        $user = auth()->user();
        $publisherId = $user->publisherProfile?->id;

        $bookIds = $publisherId
            ? Book::where('publisher_id', $publisherId)->pluck('id')
            : collect();

        $stats = [
            'total'    => $publisherId ? Book::where('publisher_id', $publisherId)->count() : 0,
            'approved' => $publisherId ? Book::where('publisher_id', $publisherId)->where('status', 'approved')->count() : 0,
            'pending'  => $publisherId ? Book::where('publisher_id', $publisherId)->where('status', 'pending')->count() : 0,
            'rejected' => $publisherId ? Book::where('publisher_id', $publisherId)->where('status', 'rejected')->count() : 0,
            'sales'    => Transaction::whereIn('book_id', $bookIds)->where('type', 'sale')->count(),
            'rents'    => Transaction::whereIn('book_id', $bookIds)->where('type', 'rent')->count(),
        ];

        return view('filament.publisher.pages.dashboard-header', [
            'name'  => $user->name,
            'stats' => $stats,
        ]);
    }
}
