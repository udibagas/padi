<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VillageResource\Pages;
use App\Filament\Resources\VillageResource\RelationManagers;
use App\Models\SubDistrict;
use App\Models\Village;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VillageResource extends Resource
{
    protected static ?string $model = Village::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Location';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sub_district_id')
                    ->relationship('subDistrict', 'name')
                    ->searchable()
                    ->required()
                    ->label('Sub District')
                    ->live()
                    ->afterStateUpdated(fn(Set $set, string $state) => $set('sub_district_code', SubDistrict::find($state)->code)),
                Hidden::make('sub_district_code')
                    ->required(),
                TextInput::make('code')
                    ->numeric()
                    ->required()
                    ->maxLength(10),
                TextInput::make('name')
                    ->required()
                    ->maxLength(50),
                TextInput::make('postal_code')
                    ->required()
                    ->maxLength(5),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subDistrict.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('postal_code')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageVillages::route('/'),
        ];
    }
}
