<?php

namespace App\Filament\Resources\DiagnosticQuestions\Pages;

use App\Filament\Resources\DiagnosticQuestions\DiagnosticQuestionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDiagnosticQuestion extends EditRecord
{
    protected static string $resource = DiagnosticQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
