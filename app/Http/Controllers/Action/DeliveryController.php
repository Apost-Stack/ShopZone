<?php

namespace App\Http\Controllers\Admin\Action;

use App\Http\Controllers\Controller;
use App\Http\Requests\Action\DeliveryRequest;
use App\Models\Action\Delivery;
use App\Models\Base\Province;
use App\Models\Base\Status;
use App\Models\Sel\Discount;
use App\Models\Users\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Common\CommonAdminView;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::with(['province', 'status', 'employee', 'discount'])
                        ->orderByDesc('created_at')
                        ->paginate(15);

        return view(CommonAdminView::getDeliveryListView(), [
            'deliveries' => $deliveries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $employees = Employee::orderBy('name')->get();
        $discounts = Discount::orderBy('name')->get();

        return view(CommonAdminView::getDeliveryFormView(), compact('provinces', 'statuses', 'employees', 'discounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->only([
                'name',
                'province_id',
                'address',
                'user_id',
                'description',
                'cost',
                'status_id',
                'employee_id',
                'discount_id'
            ]);

            $delivery = Delivery::create($data);

            DB::commit();

            return redirect()->route('admin.action.deliveries.index')
                ->with('success', 'Méthode de livraison créée avec succès.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delivery store error: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors('Erreur lors de la création : '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        $delivery->load(['province', 'status', 'employee', 'discount']);
        return view(CommonAdminView::getDeliveryShowView(), compact('delivery'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        $provinces = Province::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $employees = Employee::orderBy('name')->get();
        $discounts = Discount::orderBy('name')->get();

        return view(CommonAdminView::getDeliveryFormView(), compact('delivery', 'provinces', 'statuses', 'employees', 'discounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliveryRequest $request, Delivery $delivery)
    {
        try {
            DB::beginTransaction();

            $data = $request->only([
                'name',
                'province_id',
                'address',
                'user_id',
                'description',
                'cost',
                'status_id',
                'employee_id',
                'discount_id'
            ]);

            $delivery->update($data);

            DB::commit();

            return redirect()->route('admin.action.deliveries.index')
                ->with('success', 'Méthode de livraison mise à jour.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delivery update error: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withInput()->withErrors('Erreur lors de la mise à jour : '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        try {
            DB::beginTransaction();

            // si vous avez des relations à détacher, faites-le ici (ex: $delivery->orders()->detach();)
            $delivery->delete();

            DB::commit();

            return redirect()->route('admin.action.deliveries.index')
                ->with('success', 'Méthode de livraison supprimée.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Delivery destroy error: '.$e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors('Impossible de supprimer : '.$e->getMessage());
        }
    }
}
