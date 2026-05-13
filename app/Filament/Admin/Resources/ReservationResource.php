<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationLabel = 'Reservations';

    protected static ?string $pluralModelLabel = 'Reservations';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Guest Information')
                    ->description('Personal details of the guest making the reservation')
                    ->schema([
                        Forms\Components\TextInput::make('surname')
                            ->label('Surname')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->nullable()
                            ->maxLength(255),
                    ])->columns(3),

                Forms\Components\Section::make('Reservation Details')
                    ->description('Date, time and meal session information')
                    ->schema([
                        Forms\Components\DatePicker::make('reservation_date')
                            ->label('Reservation Date')
                            ->required()
                            ->minDate(now())
                            ->native(false),
                        Forms\Components\Select::make('session')
                            ->label('Meal Session')
                            ->required()
                            ->options([
                                'lunch' => 'Lunch (12:00 - 14:00)',
                                'dinner' => 'Dinner (19:00 - 22:00)',
                            ])
                            ->native(false),
                        Forms\Components\TimePicker::make('reservation_time')
                            ->label('Reservation Time')
                            ->required()
                            ->native(false),
                        Forms\Components\TextInput::make('number_of_guests')
                            ->label('Number of Guests')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(55),
                    ])->columns(2),

                Forms\Components\Section::make('Additional Information')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->label('Special Notes')
                            ->nullable()
                            ->maxLength(1000)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->required()
                            ->options([
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->native(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('surname')
                    ->label('Surname')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reservation_date')
                    ->label('Date')
                    ->date('M d, Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reservation_time')
                    ->label('Time')
                    ->time('H:i'),
                Tables\Columns\TextColumn::make('session')
                    ->label('Session')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'lunch' => 'info',
                        'dinner' => 'warning',
                        default => 'secondary',
                    }),
                Tables\Columns\TextColumn::make('number_of_guests')
                    ->label('Guests')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('reservation_date', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->label('Filter by Status'),
                Tables\Filters\SelectFilter::make('session')
                    ->options([
                        'lunch' => 'Lunch',
                        'dinner' => 'Dinner',
                    ])
                    ->label('Filter by Session'),
                Tables\Filters\Filter::make('reservation_date')
                    ->form([
                        Forms\Components\DatePicker::make('reservation_date_from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('reservation_date_until')
                            ->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['reservation_date_from'],
                                fn(Builder $q, $date) => $q->whereDate('reservation_date', '>=', $date),
                            )
                            ->when(
                                $data['reservation_date_until'],
                                fn(Builder $q, $date) => $q->whereDate('reservation_date', '<=', $date),
                            );
                    })
                    ->label('Filter by Date Range'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canDelete(Model $record): bool
    {
        return true;
    }
}
