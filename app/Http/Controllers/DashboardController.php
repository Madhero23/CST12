<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Quotation;
use App\Models\Product;
use App\Models\Customer;
use App\Models\AlertLog;
use App\Models\CustomerInteraction;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();
        
        $stats = [
            'total_products' => Product::count(),
            'pending_inquiries' => \App\Models\Inquiry::where('status', 'new')->count(),
            'completed_today' => Sale::whereDate('created_at', $today)->count(),
            'total_revenue' => Sale::where('Status', 'Completed')->sum('Total_Amount_PHP'),
            'total_customers' => Customer::count(),
            'low_stock_count' => \App\Models\Inventory::where('Current_Stock', '<=', DB::raw('COALESCE((SELECT Min_Stock_Level FROM products WHERE products.Product_ID = inventories.Product_ID), 10)'))->count(),
            'overdue_invoices' => Sale::where('Due_Date', '<', $today)->whereIn('Status', ['Pending', 'Partial'])->count(),
            'active_quotations' => Quotation::whereIn('Status', ['Pending', 'Sent'])->count(),
        ];
        
        // Fetch recent activities from AlertLog (System Events)
        $recentActivities = AlertLog::latest()
            ->limit(10)
            ->get()
            ->map(function($log) {
                return [
                    'title' => $log->Subject,
                    'detail' => $log->Message,
                    'time' => $log->created_at->diffForHumans(),
                    'type' => $log->Alert_Type // e.g., 'Inventory', 'Finance', 'System'
                ];
            });
            
        // Fetch upcoming follow-ups
        $upcomingFollowUps = CustomerInteraction::whereNotNull('Follow_Up_Date')
            ->where('Follow_Up_Date', '>=', $today)
            ->with('customer')
            ->orderBy('Follow_Up_Date', 'asc')
            ->limit(5)
            ->get();
            
        // For the Pipeline view (Quotations)
        $quotePipeline = Quotation::whereIn('Status', ['Draft', 'Pending', 'Sent'])
            ->with('customer')
            ->latest()
            ->limit(10)
            ->get();
            
        return view('dashboard.admin', compact('stats', 'recentActivities', 'upcomingFollowUps', 'quotePipeline'));
    }
}
