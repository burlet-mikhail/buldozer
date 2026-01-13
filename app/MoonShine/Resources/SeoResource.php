<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Validation\Rule;
use Leeto\Seo\Models\Seo;
use Leeto\Seo\Rules\UrlRule;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class SeoResource extends ModelResource
{
    protected string $model = Seo::class;

    protected string $column = 'title';

    public function getTitle(): string
    {
        return 'SEO';
    }

    protected function indexFields(): iterable
    {
        return [
            ID::make()->sortable(),
            Text::make('Url'),
            Text::make('Title'),
            Text::make('Description'),
        ];
    }

    protected function detailFields(): iterable
    {
        return [
            ID::make(),
            Text::make('Url'),
            Text::make('Title'),
            Text::make('Description'),
            Text::make('Keywords'),
        ];
    }

    protected function formFields(): iterable
    {
        return [
            Box::make([
                ID::make()->sortable(),
                Text::make('Url')->required(),
                Text::make('Title')->required(),
                Text::make('Description'),
                Text::make('Keywords'),
                TinyMce::make('Text'),
            ])
        ];
    }

    protected function rules($item): array
    {
        return [
            'title' => ['required', 'string', 'min:1'],
            'url' => [
                'required',
                'string',
                new UrlRule,
                Rule::unique('seo')->ignoreModel($item)
            ]
        ];
    }

    protected function search(): array
    {
        return ['id', 'url', 'title'];
    }
}
