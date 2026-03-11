<?php

namespace App\Filament\Library\Resources;

use App\Filament\Library\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('library_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->disabled(),
            Forms\Components\Textarea::make('description')->disabled(),
            Forms\Components\Select::make('publisher_id')
                ->relationship('publisher', 'name')
                ->disabled(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending'  => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->default('pending')
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable(),
                Tables\Columns\TextColumn::make('publisher.name')->label('Publisher'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'approved',
                        'warning' => 'pending',
                        'danger'  => 'rejected',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->date()->label('Added On'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter by Status')
                    ->options([
                        'pending'  => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Book $record) => $record->status === 'pending')
                    ->action(fn(Book $record) => $record->update(['status' => 'approved'])),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->visible(fn(Book $record) => $record->status === 'pending')
                    ->action(fn(Book $record) => $record->update(['status' => 'rejected'])),

                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation() // يطلب تأكيد قبل الحذف
                    ->modalHeading('Delete Book')
                    ->modalDescription('Are you sure you want to delete this book? This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
        ];
    }
}
