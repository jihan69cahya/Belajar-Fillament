<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationGroup = 'Kelola';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Pelanggan';
    protected static ?string $pluralModelLabel = 'Pelanggan';
    protected static ?string $slug = 'kelola-pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->placeholder('Masukkan Nama Pelanggan')
                    ->label('Nama Pelanggan')
                    ->required()
                    ->prefixIcon('heroicon-o-user'),

                TextInput::make('telepon')
                    ->placeholder('Masukkan Nomor Telepon Aktif')
                    ->label('Nomor Telepon')
                    ->required()
                    ->tel()
                    ->prefixIcon('heroicon-o-phone'),

                TextInput::make('alamat')
                    ->placeholder('Masukkan Alamat Lengkap')
                    ->label('Alamat Pelanggan')
                    ->required()
                    ->prefixIcon('heroicon-o-home'),

                Radio::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->inline()
                    ->inlineLabel(false)
                    ->required(),

                TextInput::make('email')
                    ->placeholder('Masukkan Email Aktif')
                    ->label('Email')
                    ->required()
                    ->email()
                    ->prefixIcon('heroicon-o-at-symbol'),

                TextInput::make('username')
                    ->placeholder('Masukkan Username (untuk login)')
                    ->label('Username')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->prefixIcon('heroicon-o-user-circle'),

                TextInput::make('password')
                    ->placeholder('Masukkan Password (untuk login)')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(fn($context) => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : null)
                    ->dehydrated(fn($state) => filled($state))
                    ->afterStateHydrated(function ($component, $state, $record, $context) {
                        if ($context === 'edit') {
                            $component->state(null);
                        }
                    })
                    ->prefixIcon('heroicon-o-lock-closed'),

                TextInput::make('password_confirmation')
                    ->placeholder('Konfirmasi Password')
                    ->label('Konfirmasi Password')
                    ->password()
                    ->revealable()
                    ->required(fn($get, $context) => $get('password') ? true : ($context === 'create'))
                    ->same('password')
                    ->dehydrated(false),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Pelanggan'),
                TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        if ($state === 'L') {
                            return 'Laki-laki';
                        } elseif ($state === 'P') {
                            return 'Perempuan';
                        }
                        return $state;
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'L' => 'danger',
                        'P' => 'success',
                    }),
                TextColumn::make('telepon')
                    ->searchable()
                    ->label('Nomor Telepon'),
                TextColumn::make('alamat')
                    ->searchable()
                    ->label('Alamat Pelanggan'),
                TextColumn::make('user_info')
                    ->label('Informasi User')
                    ->getStateUsing(function ($record) {
                        return $record->username . ' (' . $record->email . ')';
                    }),
                TextColumn::make('created_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->label('Bergabung Sejak'),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }
}
