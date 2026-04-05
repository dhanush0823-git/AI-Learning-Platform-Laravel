<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use App\Models\Question;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
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
                        MarkdownEditor::make('content')
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
                TextColumn::make('questions_count')
                    ->label('Questions')
                    ->counts('questions')
                    ->badge()
                    ->color('info'),
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
                Action::make('addQuestions')
                    ->label('Add Questions')
                    ->icon('heroicon-o-document-plus')
                    ->color('info')
                    ->modalHeading(fn ($record): string => 'Add Questions for ' . $record->title)
                    ->modalWidth('4xl')
                    ->schema([
                        Repeater::make('questions')
                            ->label('Questions')
                            ->defaultItems(1)
                            ->minItems(1)
                            ->collapsible()
                            ->cloneable()
                            ->itemLabel(fn (array $state): ?string => $state['question_text'] ?? 'New question')
                            ->schema([
                                TextInput::make('topic')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('difficulty_level')
                                    ->options([
                                        1 => 'Level 1',
                                        2 => 'Level 2',
                                        3 => 'Level 3',
                                        4 => 'Level 4',
                                        5 => 'Level 5',
                                    ])
                                    ->required()
                                    ->default(1),
                                Toggle::make('is_active')
                                    ->default(true),
                                Textarea::make('question_text')
                                    ->label('Question')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('option_a')
                                    ->label('Option A')
                                    ->required(),
                                TextInput::make('option_b')
                                    ->label('Option B')
                                    ->required(),
                                TextInput::make('option_c')
                                    ->label('Option C')
                                    ->required(),
                                TextInput::make('option_d')
                                    ->label('Option D')
                                    ->required(),
                                Select::make('correct_option')
                                    ->options([
                                        'a' => 'Option A',
                                        'b' => 'Option B',
                                        'c' => 'Option C',
                                        'd' => 'Option D',
                                    ])
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ])
                    ->action(function (array $data, $record): void {
                        $course = $this->getOwnerRecord();

                        foreach ($data['questions'] ?? [] as $questionData) {
                            $options = [
                                'a' => $questionData['option_a'],
                                'b' => $questionData['option_b'],
                                'c' => $questionData['option_c'],
                                'd' => $questionData['option_d'],
                            ];

                            Question::create([
                                'department_id' => $course->department_id,
                                'course_id' => $course->id,
                                'module_id' => $record->id,
                                'topic' => $questionData['topic'],
                                'difficulty_level' => (int) $questionData['difficulty_level'],
                                'question_text' => $questionData['question_text'],
                                'options' => array_values($options),
                                'correct_option' => $options[$questionData['correct_option']],
                                'is_active' => (bool) ($questionData['is_active'] ?? true),
                            ]);
                        }

                        Notification::make()
                            ->title('Module questions saved')
                            ->body('The questions are now linked to this module for module tests.')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
