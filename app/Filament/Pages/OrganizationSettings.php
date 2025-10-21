<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class OrganizationSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Pengaturan Organisasi';

    protected static ?string $title = 'Pengaturan Organisasi';

    protected static ?int $navigationSort = 99;

    public ?array $data = [];
    
    public function getView(): string
    {
        return 'filament.pages.organization-settings';
    }

    public function mount(): void
    {
        $settings = Setting::getMultiple(['visi', 'misi', 'sejarah', 'sejarah_kepengurusan']);
        
        $this->form->fill([
            'visi' => $settings['visi'] ?? '',
            'misi' => $settings['misi'] ?? '',
            'sejarah' => $settings['sejarah'] ?? '',
            'sejarah_kepengurusan' => $settings['sejarah_kepengurusan'] 
                ? json_decode($settings['sejarah_kepengurusan'], true) 
                : [],
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Visi & Misi')
                    ->schema([
                        Textarea::make('visi')
                            ->label('Visi Organisasi')
                            ->rows(4)
                            ->columnSpanFull(),
                        
                        Textarea::make('misi')
                            ->label('Misi Organisasi')
                            ->rows(6)
                            ->helperText('Gunakan enter untuk memisahkan setiap poin misi')
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
                                TextInput::make('periode')
                                    ->label('Periode')
                                    ->placeholder('contoh: 2020-2022')
                                    ->required(),
                                
                                TextInput::make('ketua')
                                    ->label('Ketua')
                                    ->required(),
                                
                                TextInput::make('wakil_ketua')
                                    ->label('Wakil Ketua'),
                            ])
                            ->columns(3)
                            ->defaultItems(0)
                            ->columnSpanFull()
                            ->collapsible()
                            ->orderColumn('order')
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
        Setting::set('sejarah_kepengurusan', json_encode($data['sejarah_kepengurusan']));

        Notification::make()
            ->title('Berhasil Disimpan')
            ->success()
            ->send();
    }
}
