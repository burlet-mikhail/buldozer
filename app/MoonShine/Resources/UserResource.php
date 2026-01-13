<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\User;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $column = 'name';

    public function getTitle(): string
    {
        return 'Пользователи';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name'),
            Text::make('Почта', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Компания', 'company'),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Имя', 'name'),
            Text::make('Почта', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Компания', 'company'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name'),
            Text::make('Почта', 'email'),
            Text::make('Телефон', 'phone'),
            Text::make('Компания', 'company'),
        ];
    }

    protected function rules($item): array
    {
        return [];
    }

    protected function search(): array
    {
        return ['id', 'name', 'email'];
    }
}
