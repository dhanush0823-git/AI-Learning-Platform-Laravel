<?php

namespace App\Filament\Resources\DiagnosticQuestions;

use App\Filament\Resources\DiagnosticQuestions\Pages\CreateDiagnosticQuestion;
use App\Filament\Resources\DiagnosticQuestions\Pages\EditDiagnosticQuestion;
use App\Filament\Resources\DiagnosticQuestions\Pages\ListDiagnosticQuestions;
use App\Filament\Resources\DiagnosticQuestions\Schemas\DiagnosticQuestionForm;
use App\Filament\Resources\DiagnosticQuestions\Tables\DiagnosticQuestionsTable;
use App\Models\DiagnosticQuestion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DiagnosticQuestionResource extends Resource
{
    protected static ?string $model = DiagnosticQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Diagnostic Questions';

    protected static string|UnitEnum|null $navigationGroup = 'Learning';

    public static function form(Schema $schema): Schema
    {
        return DiagnosticQuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiagnosticQuestionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDiagnosticQuestions::route('/'),
            'create' => CreateDiagnosticQuestion::route('/create'),
            'edit' => EditDiagnosticQuestion::route('/{record}/edit'),
        ];
    }
}
