<?php

namespace App\Filament\Resources\DepartmentAdmins\Pages;

use App\Filament\Resources\DepartmentAdmins\DepartmentAdminResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDepartmentAdmin extends EditRecord
{
    protected static string $resource = DepartmentAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
