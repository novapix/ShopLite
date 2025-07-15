<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Log;

class RolesController extends Controller
{
    public function index(): Response {
        $roles = Roles::all();
        return Inertia::render('admin/roles/index', ['roles' => $roles]);
    }
    public function create(): Response {
        return Inertia::render('admin/roles/create');
    }
}
