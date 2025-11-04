<?php

namespace App\Filament\Resources\Anggotas\Pages;

use App\Filament\Resources\Anggotas\AnggotaResource;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUserFromAnggota extends Page implements HasForms
{
    use InteractsWithRecord;
    use InteractsWithForms;

    protected static string $resource = AnggotaResource::class;

    protected string $view = 'filament::filament.resources.anggotas.pages.create-user-from-anggota';
    public ?array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        abort_if($this->record->user, 404);
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(table: User::class, column: 'email'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->revealable(),
                Select::make('roles')
                    ->label('Role')
                    ->multiple()
                    ->options(Role::pluck('name', 'id'))
                    ->preload()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        
        $data = $this->form->getState();

        
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'anggota_id' => $this->record->id,
        ]);

        
        $user->assignRole($data['roles']);

        
        Notification::make()
            ->title('User berhasil dibuat')
            ->success()
            ->send();

        
        $this->redirect(AnggotaResource::getUrl('index'));
    }
}
