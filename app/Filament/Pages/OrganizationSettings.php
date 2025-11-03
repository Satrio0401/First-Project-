<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\Misi;
use App\Models\SejarahPengurus;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use UnitEnum;
use Filament\Schemas\Schema;

class OrganizationSettings extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Pengaturan Organisasi';

    protected static ?string $title = 'Pengaturan Organisasi';

    protected static ?int $navigationSort = 99;

    public ?array $data = [];
    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Super Admin');
    }
    public function getView(): string
    {
        return 'filament.pages.organization-settings';
    }

    public function mount(): void
    {
        $settings = Setting::getMultiple(['visi', 'misi', 'sejarah']);
        
        $sejarahKepengurusan = SejarahPengurus::orderBy('order_column')->get()->toArray();
        
        $this->form->fill([
            'visi' => $settings['visi'] ?? '',
            'misi' => $settings['visi'] ?? '',
            'sejarah' => $settings['sejarah'] ?? '',
            'sejarah_kepengurusan' => $sejarahKepengurusan,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visi & Misi')
                    ->schema([
                        Textarea::make('visi')
                            ->label('Visi Organisasi')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('misi')
                            ->label('Misi Organisasi')
                            ->rows(8)
                            ->helperText('Pisahkan setiap poin misi dengan menekan tombol Enter.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Sejarah Organisasi')
                    ->schema([
                        Textarea::make('sejarah')
                            ->label('Sejarah')
                            ->rows(10)
                            ->columnSpanFull(),
                    ]),

                Section::make('Sejarah Kepengurusan')
                    ->schema([
                        Repeater::make('sejarah_kepengurusan')
                            ->label('Periode Kepengurusan')
                            ->schema([
                                TextInput::make('periode_mulai')
                                    ->label('Tahun Mulai')
                                    ->numeric()->length(4)->required(),
                                
                                TextInput::make('periode_berakhir')
                                    ->label('Tahun Berakhir')
                                    ->numeric()->length(4)->required(),
                                
                                TextInput::make('ketua')
                                    ->label('Ketua')
                                    ->required(),
                                
                                TextInput::make('wakil_ketua')
                                    ->label('Wakil Ketua'),
                            ])
                            ->columns(4)
                            ->addActionLabel('Tambah Periode')
                            ->columnSpanFull()
                            ->orderColumn('order_column')
                            ->reorderable(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('visi', $data['visi']);
        Setting::set('misi', $data['misi']);
        Setting::set('sejarah', $data['sejarah']);
        SejarahPengurus::query()->delete();
        if (!empty($data['sejarah_kepengurusan'])) {
            foreach ($data['sejarah_kepengurusan'] as $index => $periode) {
                SejarahPengurus::create([
                    'periode_mulai' => $periode['periode_mulai'],
                    'periode_berakhir' => $periode['periode_berakhir'],
                    'ketua' => $periode['ketua'],
                    'wakil_ketua' => $periode['wakil_ketua'],
                    'order_column' => $index + 1,
                ]);
            }
        }

        Notification::make()
            ->title('Berhasil Disimpan')
            ->success()
            ->send();
    }
}
