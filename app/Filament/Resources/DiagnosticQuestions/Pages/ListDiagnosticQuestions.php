<?php

namespace App\Filament\Resources\DiagnosticQuestions\Pages;

use App\Filament\Resources\DiagnosticQuestions\DiagnosticQuestionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDiagnosticQuestions extends ListRecords
{
    protected static string $resource = DiagnosticQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
