<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Reading\Book;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                TextInput::make('title')
                ->label('title'),
                
                TextInput::make('description')
                ->label('description'),

                TextInput::make('author')
                ->label('author'),

                TextInput::make('pages')
                ->label('Pages Number'),

                Select::make('category_id')
                ->label('الفئة')
                ->relationship('category','name') 
                ->searchable()
                ->preload()
                ->required(),
    



                FileUpload::make('book_path')
                ->label('Book')
                ->directory('reding_books'),

                FileUpload::make('cover_path')
                ->label('Cover')
                ->directory('books_covers'),
                

           ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('title')
                ->label('title')
                ->searchable()
                ->sortable(),

                
                TextColumn::make('description')
                ->label('description')
                ->searchable()
                ->sortable(),

                TextColumn::make('author')
                ->label('author')
                ->searchable()
                ->sortable(),

                TextColumn::make('pages')
                ->label('pages')
                ->searchable()
                ->sortable(),

                ImageColumn::make('cover_path')
                ->label('Book Cover')
                ->size(50)
                ->circular(),

                
                TextColumn::make('category.name')
                ->label('Category'),

  
 

                ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->label('حذف')
                ->before(function ($record) {
                    if ($record->book_path && Storage::disk('public')->exists($record->book_path)) {
                        Storage::disk('public')->delete($record->book_path);
                    }

                    if ($record->cover_path && Storage::disk('public')->exists($record->cover_path)) {
                        Storage::disk('public')->delete($record->cover_path);
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function afterDelete($record)
    {
        if ($record->book_path && Storage::disk('public')->exists($record->book_path)) {
            Storage::disk('public')->delete($record->book_path);
        }
    
        if ($record->cover_path && Storage::disk('public')->exists($record->cover_path)) {
            Storage::disk('public')->delete($record->cover_path);
        }
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
