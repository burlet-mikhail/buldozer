<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\BelongsToMany;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Support\Traits\Models\Seo;
use Support\Traits\MoveImage;

class ProductResource extends ModelResource
{
    use MoveImage, Seo;

    protected string $model = Product::class;

    protected string $column = 'title';

    protected array $with = ['categories', 'cities', 'region', 'optionValues.option'];

    protected bool $columnSelection = true;

    public function getTitle(): string
    {
        return 'Объекты';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title'),
            Switcher::make('Премиум', 'premium')->sortable(),
            Switcher::make('Активное', 'active')->sortable(),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Заголовок', 'title'),
            Text::make('Slug', 'slug'),
            Text::make('Телефон', 'contact'),
            Text::make('Цена', 'price'),
            Text::make('Минимальный заказ', 'min'),
            Switcher::make('Премиум', 'premium'),
            Switcher::make('Активное', 'active'),
        ];
    }

    protected function formFields(): iterable
    {
        $blocks = [];

        if ($item = $this->getItem()) {
            $cats = $item->categories?->pluck('id')->toArray() ?? [];
            if (!empty($cats)) {
                $result = Option::whereIn('id', function ($query) use ($cats) {
                    $query->select('option_id')
                          ->from('category_option')
                          ->whereIn('category_id', $cats);
                })->with([
                    'optionValues' => function ($query) {
                        $query->select('id', 'option_id');
                    }
                ])->get()->mapWithKeys(function ($option) {
                    return [
                        $option->title => $option->optionValues->pluck('id')->toArray()
                    ];
                })->toArray();

                foreach ($result as $key => $item) {
                    $blocks[] =
                        Column::make([
                            BelongsToMany::make($key, 'optionValues', 'title')
                                         ->valuesQuery(fn(Builder $query) => $query->whereIn('id', $item))
                                         ->selectMode(),
                        ])->columnSpan(4);
                }
            }
        }

        return [
            Grid::make([
                Column::make([
                    Box::make([
                        Grid::make([
                            Column::make([
                                Text::make('Заголовок', 'title')->required(),
                            ])->columnSpan(6),
                            Column::make([
                                Text::make('Slug', 'slug'),
                            ])->columnSpan(6),
                        ]),
                        TinyMce::make('Контент', 'text'),
                    ]),
                    Grid::make([
                        ...$blocks
                    ]),

                    Box::make('SEO', $this->getSeoBlock($this->getItem(), 'products.show')),

                ])->columnSpan(9),

                Column::make([
                    Box::make([
                        Text::make('Телефон', 'contact'),
                        Text::make('Цена', 'price'),
                        Text::make('Минимальный заказ', 'min'),

                        BelongsTo::make('Пользователь', 'user', 'name')
                                 ->nullable(),
                        Switcher::make('Премиум', 'premium'),
                        Switcher::make('Активное', 'active'),
                        BelongsToMany::make('Категории', 'categories', 'name')
                                     ->selectMode(),
                        BelongsTo::make('Регион', 'region', 'name')
                            ->searchable(),

                        BelongsToMany::make('Города', 'cities', 'name')
                            ->valuesQuery(function ($q) {
                                $item = $this->getItem();
                                return $q->where('region_id', $item?->region_id ?? null);
                            })
                            ->selectMode()
                            ->searchable()
                            ->creatable(),

                        Image::make('Изображения', 'thumbnail')
                             ->disk('images')
                             ->dir('products/original')
                             ->multiple()
                             ->removable(),
                    ])
                ])->columnSpan(3),

            ]),

            Divider::make(),
        ];
    }

    protected function rules($item): array
    {
        return [];
    }

    protected function search(): array
    {
        return ['id', 'title', 'slug'];
    }
}
