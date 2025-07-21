<?php

namespace App\Filament\Admin\Resources\Make:middlewareResource\Pages;

use App\Filament\Admin\Resources\Make:middlewareResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMake:middlewares extends ListRecords
{
    protected static string $resource = Make:middlewareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
