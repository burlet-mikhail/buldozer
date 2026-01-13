<?php

namespace App\Jobs;

use App\Models\Category;
use App\Parser\Parser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddCategoriesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(public string $region)
    {
        //
    }


    public function handle(): void
    {

        $parser = new Parser();
        foreach ( $parser->parseCategories($this->region) as $category ) {
            Category::query()->firstOrCreate([
                'slug' => $category['slug'],
            ], [
                'name' => $category['name'],
                'slug' => $category['slug'],]);
        }

        sleep(3);
    }
}
