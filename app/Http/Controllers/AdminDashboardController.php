<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\ProductCategory;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    public function index(): Response {
        $user = auth()->user();
        $userRole = $user->roles->role ?? null;

        // available to all admins
        $stats = [
            'total_categories' => ProductCategory::count(),
            'total_brands' => Brand::count(),
            'total_customers' => Customer::count(),
        ];

        //superadmin-specific stats
        if ($userRole === 'superadmin') {
            $stats['total_users'] = User::count();
            $stats['total_roles'] = Roles::count();
            $stats['total_admins'] = User::whereHas('roles', function($query) {
                $query->where('role', 'admin');
            })->count();
        }

        //recent activity data
        $recentData = [
            'recent_categories' => ProductCategory::latest()->take(5)->get(),
            'recent_brands' => Brand::latest()->take(5)->get(),
            'recent_customers' => Customer::latest()->take(5)->get(),
        ];

        if ($userRole === 'superadmin') {
            $recentData['recent_users'] = User::with('roles')->latest()->take(5)->get();
        }

        return Inertia::render('admin/dashboard', [
            'stats' => $stats,
            'recentData' => $recentData,
            'userRole' => $userRole,
        ]);
    }
}
