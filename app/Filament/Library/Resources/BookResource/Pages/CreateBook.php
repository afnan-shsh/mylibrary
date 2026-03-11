<?php

namespace App\Filament\Library\Resources\BookResource\Pages;

use App\Filament\Library\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;
}
