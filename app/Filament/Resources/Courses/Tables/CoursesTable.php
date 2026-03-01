<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('department.code')
                    ->label('Department')
                    ->sortable(),
                TextColumn::make('difficulty')
                    ->badge(),
                TextColumn::make('total_modules')
                    ->sortable(),
                TextColumn::make('icon')
                    ->searchable(),
                TextColumn::make('youtube_link')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('duration')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->paginated(false)
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ]);
    }
}
