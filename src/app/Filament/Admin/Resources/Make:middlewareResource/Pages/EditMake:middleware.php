<?php

namespace App\Filament\Admin\Resources\Make:middlewareResource\Pages;

use App\Filament\Admin\Resources\Make:middlewareResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMake:middleware extends EditRecord
{
    protected static string $resource = Make:middlewareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
