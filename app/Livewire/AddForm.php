<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\Region;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Livewire\Attributes\Rule;
use Livewire\Component;

use Livewire\WithFileUploads;
use MoonShine\Laravel\Notifications\MoonShineNotification;
use MoonShine\Laravel\Notifications\NotificationButton;


class AddForm extends Component {
    use WithFileUploads;

    public bool $success = false;
    public bool $manualCity = false;

    #[Rule( 'required|min:5' )]
    public string $title;

    #[Rule( 'required' )]
    public string $text;

    #[Rule( 'required' )]
    public string $minimumOrder;

    #[Rule( 'required|min:3' )]
    public string $phone;

    #[Rule( 'nullable' )]
    public string $manualCityName;

    #[Rule( 'required|numeric' )]
    public int $price = 0;

    #[Rule( 'required|string' )]
    public string $name;

    #[Rule( 'required', message: 'Выберите категорию', )]
    #[Rule( 'not_in:0', message: 'Выберите категорию', )]
    #[Rule( 'exists:categories,id', message: 'Выберите категорию', )]
    public int $category_id;

    #[Rule( 'required', message: 'Выберите регион', )]
    #[Rule( 'not_in:0', message: 'Выберите регион', )]
    #[Rule( 'exists:regions,id', message: 'Выберите регион', )]
    public string $region_id;

    #[Rule( 'required', message: 'Выберите город', )]
    #[Rule( 'not_in:0', message: 'Выберите город', )]
    public string $city_id;

    #[Rule( [ 'images.*' => 'image|max:10024' ] )]
    public array $images;

    public array $messenger = [
        'whatsapp' => false,
        'viber'    => false,
        'telegram' => false,
    ];

    public array $cities = [];
    public $options;
    public array $selectedOptions = [];

    public function getCities(): void {
        $this->cities = City::query()
                            ->orderBy( 'name' )
                            ->where( 'region_id', $this->region_id )
                            ->get( [ 'id', 'name' ] )->toArray();
    }

    public function save(): void {


        $this->validate();


        if ( $this->manualCity ) {
            $city = City::query()->create( [
                'name'      => $this->manualCityName,
                'region_id' => $this->region_id,
                'active'    => false,
            ] );
            MoonShineNotification::send(
                message: 'При добавлении объявления был создан новый город, проверьте выберите регион и активируйте его',
                button: new NotificationButton('Проверить', '/admin/resource/city-resource/' . $city->id . '/edit')
            );

            $this->city_id = $city->id;

        }


        $product = Product::query()->create( [
            'title'     => $this->title,
            'contact'   => $this->phone,
            'messenger' => $this->messenger,
            'min'       => $this->minimumOrder,
            'name'      => $this->name,
            'price'     => $this->price,
            'text'      => $this->text,
            'active'    => false,
            'user_id'   => auth()->id() ?? null,
            'region_id' => $this->region_id,
        ] );

        $paths  = [];
        $folder = 'products/original/' . $product->id;
        foreach ( $this->images as $image ) {
            $paths[] = $image->store( $folder, 'images' );
        }


        $product->update( [ 'thumbnail' => $paths ] );


        MoonShineNotification::send(
            message: 'Был создан новый продукт, проверьте и активируйте его',
            button: new NotificationButton('Проверить', '/admin/resource/product-resource/' . $product->id . '/edit')
        );

        $product->categories()->sync( $this->category_id );

        $product->cities()->sync( $this->city_id );

        $product->optionValues()->sync( $this->selectedOptions );

        File::cleanDirectory( storage_path( 'app/livewire-tmp' ) );

        $this->success = true;
    }


    public function getCity( $city ): Collection|array {


        Validator::make( [
            'city' => $city
        ], [
            'city' => 'required|string|min:3'
        ] );

        return City::query()->where( 'name', 'LIKE', $city . '%' )->get();
    }

    public function changeCity(): void {
        $this->manualCity = $this->city_id === 'manualCity';
    }

    public function getValues(): void {

        if ( $this->category_id === 0 ) {
            $this->options = collect();
        }

        $this->options = Category::query()
                                 ->where( 'id', $this->category_id )
                                 ->with( [
                                     'options' => function ( $query ) {
                                         $query->select( 'options.id', 'options.title' )->with( 'optionValues' );
                                     },
                                 ] )->first( [ 'id' ] );
    }


    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        $regions    = cache()->rememberForever( 'add_regions', function () {
            return Region::query()->orderBy( 'name' )->get( [ 'id', 'name' ] )->toArray();
        } );
        $categories = cache()->rememberForever( 'categories.add', function () {
            return Category::query()->orderBy( 'name' )
                           ->whereNull( 'parent' )
                           ->get( [ 'id', 'name' ] )
                           ->toArray();
        } );

        return view( 'livewire.add-form', compact( 'regions', 'categories' ) );
    }

}
