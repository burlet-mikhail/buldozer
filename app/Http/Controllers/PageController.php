<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class PageController extends Controller {
    public function __invoke( Page $page ): View|Application|Factory|\Illuminate\Contracts\Foundation\Application {
        return view( 'page.page', compact( 'page' ) );
    }
}
