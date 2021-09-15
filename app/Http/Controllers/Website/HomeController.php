<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slider  = Slider::inrandomOrder(5)->get();

        $popularProduct = Product::with('images')->inrandomOrder(6)->get();
        $latestProduct  = Product::with('images')->latest()->limit(6)->get();

        // $popularProduct = collect($products)->slice(0, 6)->all();

        $projects = Project::with('images')->inrandomOrder(4)->get();

        $partners = Partner::get();
        $about    = Setting::first();
        // return $about;
        return view('website.home', compact('slider', 'popularProduct', 'latestProduct', 'projects', 'about', 'partners'));
    }
}
