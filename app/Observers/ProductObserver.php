<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver {
    public function created( Product $product ): void {
        $this->removeCache();
    }

    public function updated( Product $product ): void {
        $this->removeCache();
    }

    public function deleted( Product $product ): void {
        $this->removeCache();
    }

    protected function removeCache(): void {
        cache()->flush();
    }

}
