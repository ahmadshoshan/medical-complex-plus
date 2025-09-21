<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('عنوان الصورة'),

                FileUpload::make('image')
                    ->label('الصورة')
                    ->image()
                    ->directory('gallery')   // خليه جوه public disk
                    ->disk('public')         // مهم جداً
                    ->visibility('public')
                    ->required(),
            ]);
    }
}
