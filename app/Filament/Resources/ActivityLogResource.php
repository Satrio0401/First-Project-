<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Spatie\Activitylog\Models\Activity;
use Filament\Schemas\Schema;
use BackedEnum;
use UnitEnum;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Log Aktivitas';

    protected static UnitEnum|string|null $navigationGroup = 'Sistem';

    protected static ?string $modelLabel = 'Log Aktivitas';

    protected static ?string $pluralModelLabel = 'Log Aktivitas';

    protected static ?int $navigationSort = 99;

    // Tidak perlu form karena log tidak diedit
    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i:s')
                    ->sortable()
                    ->timezone('Asia/Makassar'), // sesuaikan timezone

                TextColumn::make('causer.name')
                    ->label('Dilakukan Oleh')
                    ->default('Sistem')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('subject_type')
                    ->label('Model')
                    ->formatStateUsing(fn(?string $state) => $state
                        ? class_basename($state)
                        : '-'
                    )
                    ->badge()
                    ->color('gray'),

                TextColumn::make('subject_id')
                    ->label('ID Data')
                    ->default('-'),

                TextColumn::make('event')
                    ->label('Event')
                    ->badge()
                    ->color(fn(?string $state) => match($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default   => 'gray',
                    })
                    ->formatStateUsing(fn(?string $state) => match($state) {
                        'created' => 'Dibuat',
                        'updated' => 'Diperbarui',
                        'deleted' => 'Dihapus',
                        default   => $state ?? '-',
                    }),

                TextColumn::make('properties')
                    ->label('Perubahan')
                    ->formatStateUsing(function ($state, $record) {
                        if (blank($state)) return '-';

                        if (is_string($state)) {
                            $props = json_decode($state, true);
                        } elseif ($state instanceof \Illuminate\Support\Collection) {
                            $props = $state->toArray();
                        } elseif (is_array($state)) {
                            $props = $state;
                        } else {
                            $props = (array) $state;
                        }
                        
                        // Coba ambil dari $props, atau gunakan $record->properties jika $props kosong
                        if (empty($props) && $record->properties) {
                            $props = $record->properties instanceof \Illuminate\Support\Collection 
                                ? $record->properties->toArray() 
                                : (array) $record->properties;
                        }

                        if (empty($props)) return '-';

                        // Tampilkan sebagai raw JSON dengan format yang rapi
                        return '<pre style="white-space: pre-wrap; font-size: 0.8rem; line-height: 1.2;">' . json_encode($props, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</pre>';
                    })
                    ->html()
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Event')
                    ->options([
                        'created' => 'Dibuat',
                        'updated' => 'Diperbarui',
                        'deleted' => 'Dihapus',
                    ]),

                SelectFilter::make('subject_type')
                    ->label('Model')
                    ->options([
                        \App\Models\Anggota::class    => 'Anggota',
                        \App\Models\Komisariat::class => 'Komisariat',
                        // tambah model lain di sini
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }

    // Nonaktifkan create, edit, delete dari UI
    public static function canCreate(): bool { return false; }

    public static function canViewAny(): bool
    {
        // Sesuaikan dengan role yang boleh melihat log, misalnya 'Super Admin'
        return auth()->user()->hasRole('Super Admin');
    }
}