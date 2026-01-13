<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use App\Models\Page;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class PageResource extends ModelResource
{
    protected string $model = Page::class;

    protected string $column = 'title';

    public function getTitle(): string
    {
        return 'Страницы';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title'),
            Text::make('Slug', 'slug'),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Заголовок', 'title'),
            Text::make('Slug', 'slug'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Заголовок', 'title'),
            Text::make('Slug', 'slug'),
            TinyMce::make('Контент', 'text'),
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
