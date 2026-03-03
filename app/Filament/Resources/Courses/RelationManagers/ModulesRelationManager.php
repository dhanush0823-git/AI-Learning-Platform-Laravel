<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ModulesRelationManager extends RelationManager
{
    protected static string $relationship = 'modules';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('module_number')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->numeric()
                    ->minValue(0)
                    ->suffix('min'),
                Toggle::make('completed')
                    ->default(false),
                Repeater::make('lessons')
                    ->relationship()
                    ->schema([
                        TextInput::make('lesson_number')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Select::make('lesson_type')
                            ->options([
                                'video' => 'Video',
                                'reading' => 'Reading',
                                'quiz' => 'Quiz',
                            ])
                            ->required(),
                        TextInput::make('duration')
                            ->numeric()
                            ->minValue(0)
                            ->default(10)
                            ->suffix('min'),
                        TextInput::make('video_url')
                            ->url()
                            ->placeholder('https://...')
                            ->maxLength(255),
                        Textarea::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->orderColumn('lesson_number')
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('module_number')
                    ->label('No.')
                    ->sortable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('duration')
                    ->label('Duration (min)')
                    ->sortable(),
                TextColumn::make('completed')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Completed' : 'Pending')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
            ])
            ->defaultSort('module_number')
            ->paginated(false)
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
