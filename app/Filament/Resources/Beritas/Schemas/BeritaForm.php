<?php

namespace App\Filament\Resources\Beritas\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Berita')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('URL-friendly versi dari judul')
                            ->readOnly(),
                        
                        Select::make('kategori')
                            ->label('Kategori')
                            ->options([
                                'Artikel' => 'Artikel',
                                'Pengumuman' => 'Pengumuman',
                            ])
                            ->required()
                            ->native(false),
                        
                        FileUpload::make('gambar')
                            ->label('Gambar Utama')
                            ->image()
                            ->directory('berita')
                            ->imageEditor()
                            ->maxSize(2048),
                    ])->columns(2),
                
                Section::make('Konten')
                    ->schema([
                        RichEditor::make('konten')
                            ->label('Konten Berita')
                            ->required()
                            ->toolbarButtons([
                                ['bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',],
                                ['h2',
                                'h3',],
                                ['bulletList',
                                'orderedList',
                                'blockquote',
                                'codeBlock',
                                'undo',
                                'redo',]
                            ])
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Pengaturan Publikasi')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Terbitkan')
                            ->default(true)
                            ->helperText('Berita yang diterbitkan akan tampil di website'),
                        
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->default(now())
                            ->displayFormat('d/m/Y H:i')
                            ->seconds(false),
                    ])->columns(2),
            ]);
    }
}
