<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\OptionValue;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class OptionValuesResource extends ModelResource
{
    protected string $model = OptionValue::class;

    protected string $column = 'title';

    public function getTitle(): string
    {
        return 'Значения опций';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title'),
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
            Text::make('Заголовок', 'title'),
        ];
    }

    protected function rules($item): array
    {
        return [];
    }
}
