<?php

namespace App\Filament\Resources\DiagnosticQuestions\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DiagnosticQuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('department.code')
                    ->label('Department')
                    ->sortable(),
                TextColumn::make('level')
                    ->badge(),
                TextColumn::make('question')
                    ->limit(70)
                    ->searchable(),
                TextColumn::make('correct_option')
                    ->label('Answer')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
