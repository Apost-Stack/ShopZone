<?php

namespace App\Http\Controllers\Sel;

use App\Common\CommonAdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sel\DiscountRequest;
use App\Models\Sel\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Log::info('Fetching discount list.');
        $discounts = Discount::paginate(10);
        return view(CommonAdminView::getDiscountListView(), compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info('Displaying discount creation form.');
        return view(view: CommonAdminView::getDiscountEditOrCreateView());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request)
    {
        try {
            Log::info('Storing a new discount.', ['data' => $request->all()]);
            $validated = $request->validated();

            Discount::create($validated);

            Log::info('Discount created successfully.');
            return redirect()->route('discounts.index')
            ->with('success', 'Réduction créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Error creating discount: ' . $e->getMessage(), ['data' => $request->all()]);
            return redirect()->back()->with(['error' => 'Erreur lors de la création de la réduction.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        Log::info('Displaying discount details.', ['discount_id' => $discount->id]);
        return view(CommonAdminView::getDiscountShowView(), compact('discount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        Log::info('Displaying discount edit form.', ['discount_id' => $discount->id]);
        return view(CommonAdminView::getCategoryEditOrCreateView(), compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        try {
            Log::info('Updating discount.', ['discount_id' => $discount->id, 'data' => $request->all()]);
            $validated = $request->validated();

            $discount->update($validated);

            Log::info('Discount updated successfully.', ['discount_id' => $discount->id]);
            return redirect()->route('discounts.index')
            ->with('success', 'Réduction mise à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Error updating discount: ' . $e->getMessage(), ['discount_id' => $discount->id]);
            return redirect()->back()->with(['error' => 'Erreur lors de la mise à jour de la réduction.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        try {
            Log::info('Deleting discount.', ['discount_id' => $discount->id]);
            $discount->delete();
            Log::info('Discount deleted successfully.', ['discount_id' => $discount->id]);
            return redirect()->route('discounts.index')
                ->with('success', 'Réduction supprimée avec succès.');
        } catch(\Exception $e) {
            Log::error('Error deleting discount: ' . $e->getMessage(), ['discount_id' => $discount->id]);
            return redirect()->back()->with(['error' => 'Erreur lors de la suppression de la réduction.']);
        }
    }
}
