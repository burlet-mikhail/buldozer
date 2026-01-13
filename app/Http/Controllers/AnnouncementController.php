<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class AnnouncementController extends Controller {
    public function __invoke(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {


        return view( 'add_item' );
    }
}
