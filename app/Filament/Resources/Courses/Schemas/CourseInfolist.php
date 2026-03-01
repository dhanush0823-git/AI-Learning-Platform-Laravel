<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CourseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('department.name')
                    ->label('Department'),
                TextEntry::make('difficulty')
                    ->badge(),
                TextEntry::make('total_modules'),
                TextEntry::make('icon')
                    ->placeholder('-'),
                TextEntry::make('youtube_link')
                    ->placeholder('-'),
                TextEntry::make('duration')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
