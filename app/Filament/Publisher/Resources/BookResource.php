<?php

namespace App\Filament\Publisher\Resources;

use App\Filament\Publisher\Resources\BookResource\Pages;
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

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required(),

            Forms\Components\Textarea::make('description')
                ->required(),

            Forms\Components\FileUpload::make('cover')
                ->label('Cover Image')
                ->image()
                ->disk('public')
                ->directory('book-covers')
                ->required()
                ->imagePreviewHeight(100),

            Forms\Components\Select::make('type')
                ->label('Book Type')
                ->options([
                    'sale' => '🛒 For Sale',
                    'rent' => '📖 For Rent',
                ])
                ->required()
                ->live(), // يحدث السعر بناءً على النوع

            Forms\Components\TextInput::make('price')
                ->label('Price ($)')
                ->numeric()
                ->minValue(0)
                ->prefix('$')
                ->placeholder('0.00')
                ->nullable(),

            Forms\Components\Select::make('library_id')
                ->label('Choose Library')
                ->relationship(
                    name: 'library',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn($query) => $query->where('role', 'library'),
                )
                ->required(),

            Forms\Components\Hidden::make('publisher_id')
                ->default(fn() => auth()->user()->publisherProfile->id),

            Forms\Components\Hidden::make('status')
                ->default('pending'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->disk('public')
                    ->height(60)
                    ->width(40),

                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->colors([
                        'success' => 'sale',
                        'info'    => 'rent',
                    ]),

                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->default('-'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('publisher_id', auth()->user()->publisherProfile->id);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit'   => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
