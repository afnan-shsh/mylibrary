<?php

namespace App\Filament\Library\Resources\BookResource\Pages;

use App\Filament\Library\Resources\BookResource;
use Filament\Resources\Pages\ListRecords;

class ListBooks extends ListRecords
{
    protected static string $resource = BookResource::class;
}
