<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Category;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use Support\Traits\MoveImage;

class CategoryResource extends ModelResource
{
    use MoveImage;

    protected string $model = Category::class;

    protected string $column = 'name';

    public function getTitle(): string
    {
        return 'Категории';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Название', 'name'),
            Text::make('Slug'),
            Switcher::make('Показывать на главной', 'show_in_home'),
            Switcher::make('Показывать в главном меню', 'show_in_menu'),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Название', 'name'),
            Text::make('Slug'),
            Textarea::make('Описание', 'description'),
            Switcher::make('Показывать на главной', 'show_in_home'),
            Switcher::make('Показывать в главном меню', 'show_in_menu'),
            Switcher::make('Показывать в популярных', 'show_in_popular'),
            Switcher::make('Показывать в редких', 'show_in_not_popular'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            ID::make()->sortable(),

            Grid::make([
                Column::make([
                    Text::make('Название', 'name'),
                    Text::make('Slug'),
                    Textarea::make('Описание', 'description'),
                ])->columnSpan(9),
                Column::make([
                    Select::make('Родительская категория', 'parent')
                        ->options(
                            Category::query()->get(['id', 'name'])->pluck('name', 'id')->toArray()
                        )
                        ->nullable(),
                    Switcher::make('Показывать на главной', 'show_in_home'),
                    Switcher::make('Показывать в главном меню', 'show_in_menu'),
                    Switcher::make('Показывать в популярных', 'show_in_popular'),
                    Switcher::make('Показывать в редких', 'show_in_not_popular'),
                    Image::make('Изображения', 'thumbnail')
                         ->disk('images')
                         ->dir('categories/original/')
                         ->removable(),
                ])->columnSpan(3),
            ]),
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
