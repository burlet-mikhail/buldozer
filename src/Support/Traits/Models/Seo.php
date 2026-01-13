<?php

declare(strict_types=1);

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Text;

trait Seo
{
    public string $routeName = '';

    public function getSeoBlock(Model|null $item, string $routeName): array
    {
        if (!$item || !$item->exists) {
            return [];
        }

        $this->routeName = $routeName;

        $seo = \Leeto\Seo\Models\Seo::query()
            ->where('url', route($routeName, $item, false))
            ->first();

        return [
            Box::make('SEO', [
                Text::make('Title', 'seo_title')
                    ->setValue($seo->title ?? $item->title ?? '')
                    ->nullable(),
                Text::make('Description', 'seo_description')
                    ->setValue($seo->description ?? '')
                    ->nullable(),
                Text::make('Keywords', 'seo_keywords')
                    ->setValue($seo->keywords ?? '')
                    ->nullable(),
                TinyMce::make('Text', 'seo_text')
                    ->setValue($seo->text ?? '')
                    ->nullable()
            ])
        ];
    }

    public function saveSeoData(array $seoData, Model $item): void
    {
        if (!$seoData || !$this->routeName) {
            return;
        }

        \Leeto\Seo\Models\Seo::query()->updateOrCreate([
            'url' => route($this->routeName, $item, false),
        ], [
            'title' => $seoData['seo_title'] ?? '',
            'description' => $seoData['seo_description'] ?? '',
            'keywords' => $seoData['seo_keywords'] ?? '',
            'text' => $seoData['seo_text'] ?? '',
        ]);
    }
}
