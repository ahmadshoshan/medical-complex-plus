<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\Builder;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static string|\UnitEnum|null $navigationGroup = 'الاعدادات';


    protected static ?int $navigationSort = 100;


    public static function getLabel(): ?string
    {
        return 'مستخدم';
    }

    public static function getPluralLabel(): ?string
    {
        return 'المستخدمين';
    }
    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
    // public static function getEloquentQuery(): EloquentBuilder

    // {
    //     // return parent::getEloquentQuery()->where('name', '!=', 'admin');

    //     $query = parent::getEloquentQuery();

    //     // إذا لم يكن المستخدم الحالي لديه صلاحية 'admin'، أخفِ المستخدم 'admin'
    //     if (!Auth::user()?->hasRole('admin') ) {
    //         $query->where('name', '!=', 'admin');
    //     }

    //     return $query;
    // }
}
