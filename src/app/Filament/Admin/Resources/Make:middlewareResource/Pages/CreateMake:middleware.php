<?php

namespace App\Filament\Admin\Resources\Make:middlewareResource\Pages;

use App\Filament\Admin\Resources\Make:middlewareResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMake:middleware extends CreateRecord
{
    protected static string $resource = Make:middlewareResource::class;
}
