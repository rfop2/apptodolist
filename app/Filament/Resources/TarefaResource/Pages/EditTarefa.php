<?php

namespace App\Filament\Resources\TarefaResource\Pages;

use App\Filament\Resources\TarefaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTarefa extends EditRecord
{
    protected static string $resource = TarefaResource::class;
    

    protected function getActions(): array
    {
        $actions = parent::getActions();

        if ($this->record && $this->record->finalizada) {
            unset($actions['save']);
        }

        return $actions;
    }

    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
