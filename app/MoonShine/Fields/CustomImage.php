<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use Illuminate\Database\Eloquent\Model;
use MoonShine\UI\Fields\Image;

class CustomImage extends Image
{
    public function afterDelete(Model $item): void
    {
        if (!$this->isDeleteFiles()) {
            return;
        }

        if ($this->isMultiple()) {
            if (!is_array($item->{$this->getColumn()})) {
                return;
            }

            foreach ($item->{$this->getColumn()} as $value) {
                $this->deleteFile($value);
            }
        } elseif (!empty($item->{$this->getColumn()})) {
            $this->deleteFile($item->{$this->getColumn()});
        }

        $this->deleteDir();
    }
}
