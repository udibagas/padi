<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'All' => Tab::make('All'),
            'Published' => Tab::make('Publshed')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', true)),
            'Unpublished' => Tab::make('Unpublished')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_published', false)),
        ];
    }
}
