<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BrandController extends Controller
{
    public function index(): Response {
        $brands = Brand::all();
        return Inertia::render('admin/brand/index', ['brands' => $brands]);
    }
    public function create(): Response {
        return Inertia::render('admin/brand/create');
    }
}
