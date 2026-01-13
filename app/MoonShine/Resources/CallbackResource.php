<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Callback;
use MoonShine\Laravel\Enums\Action;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class CallbackResource extends ModelResource
{
    protected string $model = Callback::class;

    protected string $column = 'name';

    public function getTitle(): string
    {
        return 'Заявки';
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::CREATE, Action::MASS_DELETE);
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name'),
            Text::make('Телефон', 'phone'),
            BelongsTo::make('Объект', 'product', 'title'),
            BelongsTo::make('Пользователь', 'user', 'name'),
        ];
    }

    protected function detailFields(): iterable
    {
        return $this->indexFields();
    }

    protected function formFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Имя', 'name'),
            Text::make('Телефон', 'phone'),
        ];
    }

    protected function rules($item): array
    {
        return [];
    }

    protected function search(): array
    {
        return ['id', 'phone', 'name'];
    }
}
