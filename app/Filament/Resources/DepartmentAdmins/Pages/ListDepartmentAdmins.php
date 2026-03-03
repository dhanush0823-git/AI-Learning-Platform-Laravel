<?php

namespace App\Filament\Resources\DepartmentAdmins\Pages;

use App\Filament\Resources\DepartmentAdmins\DepartmentAdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDepartmentAdmins extends ListRecords
{
    protected static string $resource = DepartmentAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
