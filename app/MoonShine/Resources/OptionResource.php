<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Option;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

class OptionResource extends ModelResource
{
    protected string $model = Option::class;

    protected string $column = 'title';

    protected array $with = ['optionValues'];

    public function getTitle(): string
    {
        return 'Опции';
    }

    protected function indexFields(): iterable
    {
        return [
            Text::make('Заголовок', 'title')->sortable(),
            Switcher::make('Показывать в карточках', 'show_in_card')->sortable(),
            Switcher::make('Учавствует в фильтрации', 'filter')->sortable(),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Заголовок', 'title'),
            Switcher::make('Показывать в карточках', 'show_in_card'),
            Switcher::make('Учавствует в фильтрации', 'filter'),
            Select::make('Шаблон', 'template')->options([
                'checkbox' => 'Чекбокс',
                'radio' => 'Радио',
                'select' => 'Селект',
                'single_range' => 'Один ползунок',
                'two_range' => 'Ползунок от - до',
            ]),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title')->sortable(),
            Switcher::make('Показывать в карточках', 'show_in_card'),
            Switcher::make('Учавствует в фильтрации', 'filter'),
            Select::make('Шаблон', 'template')->options([
                'checkbox' => 'Чекбокс',
                'radio' => 'Радио',
                'select' => 'Селект',
                'single_range' => 'Один ползунок',
                'two_range' => 'Ползунок от - до',
            ]),
            BelongsToMany::make('Категории', 'categories', 'name')
                ->selectMode(),
        ];
    }

    protected function search(): array
    {
        return ['id', 'title'];
    }

    protected function rules($item): array
    {
        return [];
    }
}
