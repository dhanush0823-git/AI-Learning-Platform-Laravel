<?php

namespace App\Filament\Resources\DepartmentAdmins;

use App\Filament\Resources\DepartmentAdmins\Pages\CreateDepartmentAdmin;
use App\Filament\Resources\DepartmentAdmins\Pages\EditDepartmentAdmin;
use App\Filament\Resources\DepartmentAdmins\Pages\ListDepartmentAdmins;
use App\Filament\Resources\DepartmentAdmins\Schemas\DepartmentAdminForm;
use App\Filament\Resources\DepartmentAdmins\Tables\DepartmentAdminsTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class DepartmentAdminResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Access Control';

    protected static ?string $modelLabel = 'Department Admin';

    protected static ?string $pluralModelLabel = 'Department Admins';

    public static function form(Schema $schema): Schema
    {
        return DepartmentAdminForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DepartmentAdminsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('is_super_admin', false);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartmentAdmins::route('/'),
            'create' => CreateDepartmentAdmin::route('/create'),
            'edit' => EditDepartmentAdmin::route('/{record}/edit'),
        ];
    }
}
