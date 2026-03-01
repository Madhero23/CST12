<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page with dynamic content
     *
     * @return View
     */
    public function index(): View
    {
        // Fetch featured products (3 active products)
        $featuredProducts = Product::active()
            ->latest()
            ->take(3)
            ->get();

        // Calculate real-time statistics
        $stats = [
            'facilities' => Customer::distinct('Institution_Name')->count('Institution_Name'),
            'products_delivered' => Sale::count(),
            'experience_years' => now()->year - 2011, // Founded in 2011 based on "14+ years" documentation
            'satisfaction_rate' => '98%',
        ];

        return view('home.index', compact('featuredProducts', 'stats'));
    }

    /**
     * Display the about us page
     *
     * @return View
     */
    public function about(): View
    {
        return view('about.about');
    }

    /**
     * Display the contact us page
     *
     * @return View
     */
    public function contact(): View
    {
        return view('contact.contact');
    }
}
