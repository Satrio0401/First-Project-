<?php

namespace App\Filament\Pages;

use App\Models\Anggota;
use App\Models\Jurusan;
use App\Models\Komisariat;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Forms\Form;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Profile extends Page implements HasForms, HasInfolists
{
    use InteractsWithForms;
    use InteractsWithInfolists;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    protected static ?string $navigationLabel = 'Profil';

    protected static ?string $title = 'Profil';

    protected static ?int $navigationSort = 98;
    public bool $isEditing = false;
    public ?array $data = [];

    public function getView(): string
    {
        return 'filament.pages.profile';
    }

    public function mount(): void
    {
        // 3. Ambil data anggota dan isi properti $data
        $anggota = auth()->user()?->anggota;
        if ($anggota) {
            $this->form->fill($anggota->toArray());
        } else {
            $this->isEditing = true;
        }
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->record(auth()->user()?->anggota)
            ->columns(2)
            ->components([
                TextEntry::make('nama')->label('Nama'),
                TextEntry::make('kelamin')->label('Kelamin'),
                TextEntry::make('no_wa')->label('No. WA'),
                TextEntry::make('tempat_lahir')->label('Tempat Lahir'),
                TextEntry::make('tanggal_lahir')->label('Tanggal Lahir')->date('d F Y'),
                TextEntry::make('alamat')->label('Alamat'),
                TextEntry::make('jurusan.nama_jurusan')->label('Jurusan'),
                TextEntry::make('komisariat.nama')->label('Komisariat LK1'),
                TextEntry::make('tahun_lk1')->label('Tahun LK1'),
                TextEntry::make('cabang_lk2')->label('Cabang LK2'),
                TextEntry::make('tahun_lk2')->label('Tahun LK2'),
                TextEntry::make('badko_lk3')->label('Badko LK3'),
                TextEntry::make('tahun_lk3')->label('Tahun LK3'),
                TextEntry::make('tahun_lkk')->label('Tahun LKK')->visible(fn($record) => $record?->kelamin === 'Perempuan'),
                TextEntry::make('cabang_lkk')->label('Cabang LKK')->visible(fn($record) => $record?->kelamin === 'Perempuan'),
                TextEntry::make('tahun_masuk_kuliah')->label('Tahun Masuk Kuliah'),
                TextEntry::make('latitude')->label('Latitude'),
                TextEntry::make('longitude')->label('Longitude'),
            ]);
    }

    // 4. Ganti getFormSchema() dengan form()
    public function form(Schema $schema): Schema
    {
        $user = auth()->user();
        return $schema
            ->components([
                TextInput::make('nama')->label('Nama')->required()->maxLength(255),
                TextInput::make('no_wa')->label('No. WA')->tel()->maxLength(32),
                Select::make('kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])
                    ->required(),
                TextInput::make('tempat_lahir')->label('Tempat Lahir')->maxLength(255),
                DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->displayFormat('Y-m-d')->placeholder('YYYY-MM-DD'),
                Textarea::make('alamat')->label('Alamat')->rows(3),
                Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->options(fn () => Jurusan::pluck('nama_jurusan', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('tahun_masuk_kuliah')->label('Tahun Masuk Kuliah')->maxLength(4),
                Select::make('komisariat_id')
                    ->label('Komisariat')
                    ->options(fn () => Komisariat::pluck('nama', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(! $user->hasRole('Super Admin')),

                TextInput::make('tahun_lk1')
                    ->label('Tahun LK1')
                    ->numeric()
                    ->maxLength(4)
                    ->nullable(),

                TextInput::make('tahun_lk2')
                    ->label('Tahun LK2')
                    ->numeric()
                    ->maxLength(4)
                    ->nullable(),

                TextInput::make('cabang_lk2')
                    ->label('Cabang LK2')
                    ->nullable(),

                TextInput::make('tahun_lk3')
                    ->label('Tahun LK3')
                    ->numeric()
                    ->maxLength(4)
                    ->nullable(),

                TextInput::make('badko_lk3')
                    ->label('Badko LK3')
                    ->nullable(),

                TextInput::make('tahun_lkk')
                    ->label('Tahun LKK')
                    ->numeric()
                    ->maxLength(4)
                    ->nullable(),

                TextInput::make('cabang_lkk')
                    ->label('Cabang LKK')
                    ->nullable(),

                Textarea::make('prestasi')
                    ->label('Prestasi')
                    ->rows(3)
                    ->nullable(),
                TextInput::make('latitude')
                ->label('Latitude')
                ->numeric()
                ->step(0.00000001)
                ->nullable()
                ,
                TextInput::make('longitude')
                ->label('Longitude')
                ->numeric()
                ->nullable()
                ->step(0.00000001),
                FileUpload::make('foto')
                    ->label('Foto Anggota')
                    ->image()
                    ->directory('anggota')
                    ->imageEditor()
                    ->maxSize(2048),
            ])
            // 5. Definisikan state path, sama seperti di OrganizationSettings
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
            Action::make('cancel')
                ->label('Batal')
                ->color('secondary')
                ->action('cancelEdit'),
        ];
    }

    public function save(): void
    {
        // 6. Ambil state dari form (ini sudah benar)
        $data = $this->form->getState();
        $anggota = auth()->user()?->anggota;

        if ($anggota) {
            $anggota->update($data);
        } else {
            $newAnggota = Anggota::create($data);
            // hubungkan user saat ini ke anggota baru
            auth()->user()->update(['anggota_id' => $newAnggota->id]);
        }

        Notification::make()
            ->success()
            ->title('Profil disimpan')
            ->send();
        $this->isEditing = false;

        // Refresh data di form setelah disimpan

    }
    public function cancelEdit(): void
    {
        // Kembali ke mode tampilan tanpa menyimpan
        $this->isEditing = false;
        // Isi ulang form dengan data asli jika ada perubahan yang belum disimpan
        $this->form->fill(auth()->user()?->anggota?->toArray());
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label('Edit Profil')
            ->action(fn() => $this->isEditing = true);
    }
}
