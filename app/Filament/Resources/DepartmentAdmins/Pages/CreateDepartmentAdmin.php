<?php

namespace App\Filament\Resources\DepartmentAdmins\Pages;

use App\Filament\Resources\DepartmentAdmins\DepartmentAdminResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartmentAdmin extends CreateRecord
{
    protected static string $resource = DepartmentAdminResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_super_admin'] = false;

        return $data;
    }
}
