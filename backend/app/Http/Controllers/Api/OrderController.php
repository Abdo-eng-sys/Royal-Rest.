<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Fetches all orders with related user and menu item details for the Admin/Dashboard
        $orders = Order::with(['user', 'orderItems.menuItem'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.special_instructions' => 'nullable|string|max:255',
            'delivery_address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $totalAmount = 0;
        $orderItems = [];
        $firstItemName = ""; // To store the first meal name

        foreach ($request->items as $index => $item) {
            $menuItem = MenuItem::findOrFail($item['menu_item_id']);
            
            // Capture the name of the first item for the 'order_name' column
            if ($index === 0) {
                $firstItemName = $menuItem->name;
            }

            $totalPrice = $menuItem->price * $item['quantity'];
            $totalAmount += $totalPrice;

            $orderItems[] = [
                'menu_item_id' => $item['menu_item_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $menuItem->price,
                'total_price' => $totalPrice,
                'special_instructions' => $item['special_instructions'] ?? null,
            ];
        }

        // Calculate tax and final total
        $taxAmount = $totalAmount * 0.08;
        $grandTotal = $totalAmount + $taxAmount;

        // Create the order name (e.g., "Lobster Ravioli + 1 more")
        $itemCount = count($request->items);
        $orderDisplayName = ($itemCount > 1) 
            ? $firstItemName . " + " . ($itemCount - 1) . " more" 
            : $firstItemName;

        // Create the Order record
        $order = Order::create([
            'user_id' => $request->user()->id,
            'customer_name' => $request->user()->name,
            'order_name' => $orderDisplayName, // Fixed undefined variable
            'order_number' => 'SH-' . strtoupper(Str::random(8)),
            'total_amount' => $grandTotal,
            'total_price' => $grandTotal,      // Fixed undefined variable
            'tax_amount' => $taxAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'delivery_address' => $request->delivery_address ?? 'No address provided',
            'phone' => $request->phone,
            'notes' => $request->notes,
        ]);

        // Create the Order Items
        foreach ($orderItems as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }

        // Load relationships before returning to React
        $order->load('user', 'orderItems.menuItem');

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()
            ->with('orderItems.menuItem')
            ->findOrFail($id);
            
        return response()->json($order);
    }
}