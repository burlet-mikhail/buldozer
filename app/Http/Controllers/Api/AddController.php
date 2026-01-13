<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Services\Image;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use MoonShine\Laravel\Notifications\MoonShineNotification;
use MoonShine\Laravel\Notifications\NotificationButton;

class AddController extends Controller
{
    public function getCategories(): array
    {
        return Category::query()
                       ->whereNull('parent')
                       ->get(['id', 'name'])
                       ->toArray();
    }

    public function store(CreateProductRequest $request, $id)
    {
        $city = City::query()->where([
            'name' => $request->city,
        ])->first();

        if (!$city) {
            $city = City::query()->create([
                'name' => $request->city,
                'active' => false,
            ]);
            MoonShineNotification::send(
                message: 'При добавлении объявления был создан новый город, проверьте выберите регион и активируйте его',
                button: new NotificationButton('Проверить', '/admin/resource/city-resource/' . $city->id . '/edit')
            );
        }

        $product = Product::query()->create([
            'title' => $request->get('title'),
            'contact' => $request->get('contact'),
            'messenger' => $request->get('messenger'),
            'min' => $request->get('min'),
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'text' => $request->get('text'),
            'active' => false,
            'user_id' => $id,
            'region_id' => get_region('id'),
        ]);

        if ($request->hasFile('input_file')) {
            $image = new Image();
            $request->validate([
                'input_files.*' => 'required|file|mimes:jpg,png,webp|max:2048',
            ]);

            $product->update([
                'thumbnail' => $image
                    ->processFiles($request->file('input_file'), $product->id)
            ]);
        }

        MoonShineNotification::send(
            message: 'Был создан новый продукт, проверьте и активируйте его',
            button: new NotificationButton('Проверить', '/admin/resource/product-resource/' . $product->id . '/edit')
        );

        $product->categories()->sync($request->select_category);
        $product->cities()->sync($city);
        $product->optionValues()->sync($request->selectedOptions);

        return $product->load(['categories', 'optionValues']);
    }

    public function getCity($city): \Illuminate\Database\Eloquent\Collection|array
    {
        Validator::make([
            'city' => $city
        ], [
            'city' => 'required|string|min:3'
        ]);

        return City::query()->where('name', 'LIKE', $city . '%')->get();
    }

    public function getOptions($id): Collection|array
    {
        return Category::query()
                       ->where('id', $id)
                       ->with([
                           'options' => function ($query) {
                               $query->select('options.id', 'options.title')->with('optionValues');
                           },
                       ])
                       ->first(['id'])
                       ->toArray() ?? collect();
    }
}
