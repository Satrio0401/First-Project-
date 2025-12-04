<?php

namespace App\Filament\Resources\Anggotas\Tables;

use App\Filament\Resources\Anggotas\AnggotaResource;
use App\Models\Anggota;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class AnggotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto Anggota')
                    ->square()
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable()
                ->wrap(),

                // Jenis Kelamin
                TextColumn::make('kelamin')
                    ->label('Jenis Kelamin')
                    ->sortable(),

                TextColumn::make('tempat_lahir')
                    ->label('Tempat, Tanggal Lahir')
                    ->formatStateUsing(function ($record) {
                        // Jika tanggal lahir kosong, hanya tampilkan tempat lahir
                        if (empty($record->tanggal_lahir)) {
                            return $record->tempat_lahir ?? '-';
                        }
                        // Format tanggal ke Bahasa Indonesia
                        $tanggal = Carbon::parse($record->tanggal_lahir)
                            ->locale('id')
                            ->translatedFormat('d F Y'); // 'F' untuk nama bulan lengkap
                        // Gabungkan keduanya
                        return $record->tempat_lahir . ', ' . $tanggal;
                    })
                    ->searchable(['tempat_lahir', 'tanggal_lahir']), // Buat bisa dicari

                // Alamat
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(50)
                    ->wrap(),

                // Nomor WhatsApp
                TextColumn::make('no_wa')
                    ->label('No. WA')
                    ->copyable()
                    ->searchable(),

                // Jurusan
                TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->sortable()
                    ->wrap(),

                // Tahun masuk kuliah
                TextColumn::make('tahun_masuk_kuliah')
                    ->label('Masuk Kuliah')
                    ->sortable(),

                // Data pelatihan LK
                TextColumn::make('tahun_lk1')
                    ->label('LK 1')
                    ->sortable(),

                TextColumn::make('tahun_lk2')
                    ->label('LK 2')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tahun_lk3')
                    ->label('LK 3')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tahun_lkk')
                    ->label('LKK')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('komisariat.nama')
                    ->label('Komisariat')
                    ->sortable()
                    ->wrap(),
                

                // Prestasi
                TextColumn::make('prestasi')
                    ->label('Prestasi')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('komisariat_id')
                    ->label('Komisariat')
                    ->relationship('komisariat', 'nama')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('jurusan_id')
                    ->label('Jurusan')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                
                SelectFilter::make('tahun_lk1')
                    ->label('Tahun LK1')
                    ->options(fn () => Anggota::whereNotNull('tahun_lk1')
                        ->distinct()
                        ->orderBy('tahun_lk1', 'desc')
                        ->pluck('tahun_lk1', 'tahun_lk1')
                        ->toArray()),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Anggota')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data anggota ini? Tindakan ini tidak dapat dibatalkan.')
                    ->modalSubmitActionLabel('Ya, Hapus'),
                Action::make('buatUser')
                ->label('Buat User')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->visible(function (Anggota $record): bool {
                        /** @var \App\Models\User|null $user */
                        $user = auth()->user();
                        $isSuperAdmin = $user?->hasRole('Super Admin') ?? false;
                        $hasNoUser = is_null($record->user);
                        return $isSuperAdmin && $hasNoUser;
                    })
                ->url(fn ($record) => AnggotaResource::getUrl('create-user-from-anggota', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Anggota Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menghapus semua anggota yang dipilih? Tindakan ini tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Ya, Hapus Semua'),
                ]),
            ]);
    }
}
