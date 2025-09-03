<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Filament\Resources\KategoriResource\RelationManagers;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $modelLabel = 'Kategori';
    protected static ?string $pluralModelLabel = 'Kategori';
    protected static ?string $slug = 'data-kategori';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->placeholder('Masukkan Nama Kategori')
                    ->label('Nama Kategori')
                    ->required(),
                TextInput::make('keterangan')
                    ->placeholder('Masukkan Keterangan (opsional)')
                    ->label('Keterangan Kategori'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Kategori'),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->default('-'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageKategoris::route('/'),
        ];
    }
}
