<?php

namespace App\Filament\Publisher\Resources\BookResource\Pages;

use App\Filament\Publisher\Resources\BookResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBook extends CreateRecord
{
    protected static string $resource = BookResource::class;
}
