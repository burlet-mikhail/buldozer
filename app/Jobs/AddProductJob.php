<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Product;
use App\Parser\Parser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(5);
        $parser = new Parser();
        $product = $parser->parseProduct( $this->data['region'], $this->data['link'] );

        if ($product){
            $productAdded = Product::query()->firstOrCreate([
               'slug' => $product['slug']
            ], [
                'title' => $product['name'],
                'text' => $product['content'],
                'contact' => $product['phone'],
                'characteristic' => json_encode($product['char']),
                'link' => $product['link'],
                'region_id' => $this->data['region']['id'],
            ]);
            $productAdded->categories()->sync($product['category']);
            dump($productAdded->link);
        }
    }
}
