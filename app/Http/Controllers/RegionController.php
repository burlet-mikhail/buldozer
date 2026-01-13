<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Services\Region\RegionServices;
use Illuminate\Http\RedirectResponse;

class RegionController extends Controller {

    public function __construct(
        private RegionServices $regionService
    ) {}

    public function __invoke(Region $region): RedirectResponse {
        $this->regionService->set($region->id);

        return redirect()->route('s.home', $region);
    }

}
