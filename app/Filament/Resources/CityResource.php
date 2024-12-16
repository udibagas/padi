<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use App\Models\Province;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Location';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('province_id')
                    ->relationship('province', 'name')
                    ->searchable()
                    ->required()
                    ->label('Province')
                    ->live()
                    ->afterStateUpdated(fn(Set $set, string $state) => $set('province_code', Province::find($state)->code)),
                Hidden::make('province_code')
                    ->required(),
                TextInput::make('code')
                    ->required()
                    ->maxLength(4)
                    ->numeric()
                    ->label('Code'),
                TextInput::make('name')
                    ->required()
                    ->maxLength(50)
                    ->label('Name'),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('province.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('province_id')
                    ->relationship('province', 'name')
                    ->label('Province'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->icon('heroicon-m-ellipsis-horizontal')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCities::route('/'),
        ];
    }
}
