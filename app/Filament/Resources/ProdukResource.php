<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Filament\Resources\ProdukResource\RelationManagers;
use App\Models\Kategori;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $modelLabel = 'Produk';
    protected static ?string $pluralModelLabel = 'Produk';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode')
                    ->placeholder('Masukkan Kode Produk')
                    ->label('Kode Produk')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->prefixIcon('heroicon-o-hashtag'),
                TextInput::make('nama')
                    ->placeholder('Masukkan Nama Produk')
                    ->label('Nama Produk')
                    ->required()
                    ->prefixIcon('heroicon-o-archive-box'),
                Select::make('kategori_id')
                    ->label('Jenis Kategori')
                    ->options(Kategori::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->prefixIcon('heroicon-o-tag'),
                TextInput::make('harga')
                    ->placeholder('Masukkan Harga Produk')
                    ->label('Harga Jual Produk')
                    ->required()
                    ->integer()
                    ->prefixIcon('heroicon-o-currency-dollar'),
                FileUpload::make('foto')
                    ->label('Foto Produk')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('produk')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->searchable()
                    ->sortable()
                    ->label('Kode Produk'),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Produk'),
                TextColumn::make('relKategori.nama')
                    ->label('Kategori')
                    ->sortable()
                    ->badge()
                    ->default('Tidak ada kategori'),
                TextColumn::make('harga')
                    ->label('Harga Jual Produk')
                    ->sortable()
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                ImageColumn::make('foto')
                    ->label('Foto Produk')
                    ->disk('public')
                    ->height(60)
                    ->defaultImageUrl(asset('assets/img/default.jpg')),
            ])
            ->filters([
                SelectFilter::make('Jenis Kategori')
                    ->options(Kategori::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->attribute('kategori_id')
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button(),
                Tables\Actions\DeleteAction::make()->button(),
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
            'index' => Pages\ManageProduks::route('/'),
        ];
    }
}
