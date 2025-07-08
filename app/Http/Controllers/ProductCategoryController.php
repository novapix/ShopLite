<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ProductCategoryController extends Controller
{

    public function index(): Response | RedirectResponse {
//        if(!Auth::check()) {
//            return redirect()->route('login');
//        }
//        $user = Auth::user()->load('role');
//        $roleName = $user->roles->role;
//
//        if($roleName == 'admin' || $roleName == 'superadmin'){
//        return Inertia::render('admin/category/index', ['categories' => $categories]);
//        }
        $categories = ProductCategory::all();
        return Inertia::render('admin/category/index', ['categories' => $categories]);
    }

    public function create(): Response | RedirectResponse {
//        if(!Auth::check()){
//            return redirect()->route('login');
//        }
//        $user = Auth::user()->load('role');
//        $roleName = $user->roles->role;

//        if($roleName == 'admin' || $roleName == 'superadmin'){
            return Inertia::render('admin/category/create');
//        }
//        abort(401,'Unauthorized');
    }

    /** @noinspection PhpTernaryExpressionCanBeReplacedWithConditionInspection */
    public function store(Request $request): RedirectResponse {
        $request->merge([
            'status' => $request->has('status') ? $request->boolean('status') : true,
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);


        ProductCategory::create($validated);

        return redirect()->route('admin.category.index')
            ->with('flash.success', 'Category created successfully!');
    }

}
