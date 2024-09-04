<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TarefaResource\Pages;
use App\Filament\Resources\TarefaResource\RelationManagers;
use App\Models\Tarefa;
use Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\DateColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\Checkbox;


class TarefaResource extends Resource
{
    protected static ?string $model = Tarefa::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->required()
                    ->minLength(5)
                    ->maxLength(50)
                    ->disabled(fn($record) => $record && $record->finalizada),
                Textarea::make('descricao')
                    ->maxLength(140)
                    ->nullable()
                    ->disabled(fn($record) => $record && $record->finalizada),
                DateTimePicker::make('data_termino')
                    ->nullable()
                    ->disabled(),
                Select::make('prioridade_id')
                    ->options(function () {
                        return \App\Models\Prioridade::all()->pluck('nome', 'id');
                    })
                    ->required()
                    ->disabled(fn($record) => $record && $record->finalizada)
                    ->default(1),
                Checkbox::make('finalizada')
                    ->label('Finalizada')
                    ->disabled(fn($record) => $record && $record->finalizada)
                    ->visible(fn(string $operation): bool => $operation === 'edit')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')
                    ->label('Nome'),
                TextColumn::make('prioridade.nome')
                    ->label('Prioridade'),
                BooleanColumn::make('finalizada')
                    ->label('Finalizada'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn($record) => $record->user_id === Auth::id() && !$record->finalizada), 
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTarefas::route('/'),
            'create' => Pages\CreateTarefa::route('/create'),
            'edit' => Pages\EditTarefa::route('/{record}/edit'),
        ];
    }
}
