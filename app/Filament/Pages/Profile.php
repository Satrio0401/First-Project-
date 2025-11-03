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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;

    protected static ?string $navigationLabel = 'Profil';

    protected static ?string $title = 'Profil';

    protected static ?int $navigationSort = 98;
    
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
            $this->data = $anggota->toArray();
        }
        // Isi form dari properti $data
        $this->form->fill($this->data);
    }

    // 4. Ganti getFormSchema() dengan form()
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')->label('Nama')->required()->maxLength(255),
                TextInput::make('no_wa')->label('No. WA')->tel()->maxLength(32),
                TextInput::make('tempat_lahir')->label('Tempat Lahir')->maxLength(255),
                DatePicker::make('tanggal_lahir')->label('Tanggal Lahir')->displayFormat('Y-m-d')->placeholder('YYYY-MM-DD'),
                Textarea::make('alamat')->label('Alamat')->rows(3),
                Select::make('jurusan_id')
                    ->label('Jurusan')
                    ->options(fn () => Jurusan::pluck('nama_jurusan', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Select::make('komisariat_id')
                    ->label('Komisariat')
                    ->options(fn () => Komisariat::pluck('nama', 'id')->toArray())
                    ->searchable()
                    ->preload()
                    ->nullable(),
                TextInput::make('tahun_masuk_kuliah')->label('Tahun Masuk')->maxLength(4),
                TextInput::make('latitude')->label('Latitude')->numeric()->nullable(),
                TextInput::make('longitude')->label('Longitude')->numeric()->nullable(),
            ])
            // 5. Definisikan state path, sama seperti di OrganizationSettings
            ->statePath('data');
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

        // Refresh data di form setelah disimpan
        $this->form->fill(auth()->user()->anggota->fresh()->toArray());
    }
}