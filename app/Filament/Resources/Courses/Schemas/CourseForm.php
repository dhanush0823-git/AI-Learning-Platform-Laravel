<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('department_id')
                    ->relationship('department', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('difficulty')
                    ->options(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'])
                    ->required(),
                TextInput::make('total_modules')
                    ->required()
                    ->numeric()
                    ->default(5),
                TextInput::make('icon')
                    ->default(null),
                TextInput::make('youtube_link')
                    ->default(null),
                TextInput::make('duration')
                    ->default(null),
            ]);
    }
}
