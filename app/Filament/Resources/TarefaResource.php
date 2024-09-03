<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TarefaResource\Pages;
use App\Filament\Resources\TarefaResource\RelationManagers;
use App\Models\Tarefa;
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
                ->maxLength(50),
            Textarea::make('descricao')
                ->maxLength(140)
                ->nullable(),
            DateTimePicker::make('data_termino')
                ->nullable()
                ->disabled(fn ($state) => !is_null($state)),
            Select::make('prioridade_id')
                ->options(function () {
                    return \App\Models\Prioridade::all()->pluck('nome', 'id');
                })
                ->required()
                ->default(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
