<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\City;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class CityResource extends ModelResource
{
    protected string $model = City::class;

    protected string $column = 'name';

    public function getTitle(): string
    {
        return 'Города';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Slug'),
            Switcher::make('Active'),
            BelongsTo::make('Регион', 'region', 'name')
                ->nullable()
                ->searchable(),
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
            Text::make('Название', 'name'),
            Text::make('Slug'),
            Switcher::make('Active'),
            BelongsTo::make('Регион', 'region', 'name')
                ->nullable()
                ->searchable(),
        ];
    }

    protected function rules($item): array
    {
        return [];
    }

    protected function search(): array
    {
        return ['id', 'name', 'slug'];
    }
}
