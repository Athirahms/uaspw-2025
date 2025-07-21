<?php

namespace App\Filament\Admin\Resources\BookkingMenuResource\Pages;

use App\Filament\Admin\Resources\BookkingMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookkingMenus extends ListRecords
{
    protected static string $resource = BookkingMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
