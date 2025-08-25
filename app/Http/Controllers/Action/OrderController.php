<?php

namespace App\Http\Controllers\Admin\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\OrderRequest;
use App\Models\Action\Order;
use App\Models\Sel\Discount;
use App\Models\Sel\Product\Product;
use App\Models\Users\Customer;
use App\Models\Action\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Common\CommonAdminView;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // charger relations importantes pour affichage
        $orders = Order::with(['customer', 'delivery', 'discount', 'products'])->orderByDesc('created_at')->paginate(15);

        return view(CommonAdminView::getOrderListView(), [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // données nécessaires pour le formulaire (customers, deliveries, discounts, products)
        $customers = Customer::orderBy('name')->get();
        $deliveries = Delivery::orderBy('name')->get();
        $discounts = Discount::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view(CommonAdminView::getOrderFormView(), compact('customers', 'deliveries', 'discounts', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->only([
                'reference',
                'delivery_id',
                'customer_id',
                'order_status',
                'status_id',
                'payment_method',
                'discount_id',
                'total_product',
                'price_total',
                'tax',
                'cash_paid',
                'label_url'
            ]);

            $order = Order::create($data);

            // attacher produits si fournis
            $attach = [];
            if ($request->has('products') && is_array($request->products)) {
                foreach ($request->products as $p) {
                    // $p doit contenir id, quantity, unit_price, discount_percent
                    if (!isset($p['id'])) continue;
                    $attach[$p['id']] = [
                        'quantity' => $p['quantity'] ?? 1,
                        'unit_price' => $p['unit_price'] ?? 0,
                        'discount_percent' => $p['discount_percent'] ?? 0,
                    ];
                }
                if (!empty($attach)) {
                    $order->products()->attach($attach);
                }
            }

            DB::commit();

            // Ajuster le nom de route selon votre configuration
            return redirect()->route('admin.action.orders.index')
                ->with('success', 'Commande créée avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order store error: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors('Erreur lors de la création de la commande : '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'delivery', 'discount', 'products']);
        return view(CommonAdminView::getOrderShowView(), compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load(['products']);
        $customers = Customer::orderBy('name')->get();
        $deliveries = Delivery::orderBy('name')->get();
        $discounts = Discount::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view(CommonAdminView::getOrderFormView(), compact('order', 'customers', 'deliveries', 'discounts', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, Order $order)
    {
        try {
            DB::beginTransaction();

            $data = $request->only([
                'reference',
                'delivery_id',
                'customer_id',
                'order_status',
                'status_id',
                'payment_method',
                'discount_id',
                'total_product',
                'price_total',
                'tax',
                'cash_paid',
                'label_url'
            ]);

            $order->update($data);

            // sync produits : si tableau fourni, on synchronise, sinon on laisse tel quel
            if ($request->has('products') && is_array($request->products)) {
                $sync = [];
                foreach ($request->products as $p) {
                    if (!isset($p['id'])) continue;
                    $sync[$p['id']] = [
                        'quantity' => $p['quantity'] ?? 1,
                        'unit_price' => $p['unit_price'] ?? 0,
                        'discount_percent' => $p['discount_percent'] ?? 0,
                    ];
                }
                $order->products()->sync($sync);
            }

            DB::commit();

            return redirect()->route('admin.action.orders.index')->with('success', 'Commande mise à jour.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order update error: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors('Erreur lors de la mise à jour : '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();

            // détacher produits puis supprimer
            $order->products()->detach();
            $order->delete();

            DB::commit();

            return redirect()->route('admin.action.orders.index')->with('success', 'Commande supprimée.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order destroy error: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors('Impossible de supprimer la commande : '.$e->getMessage());
        }
    }
}
