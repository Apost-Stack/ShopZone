<?php

namespace App\Http\Controllers\Admin\Base;

use App\Common\CommonAdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Base\ProvinceRequest;
use App\Models\Base\Province;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(CommonAdminView::getProvinceListView(), [
            'provinces' => Province::orderBy("id", "desc")->where("status_id", 1)->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * go to view
     */
    public function create()
    {
        return view(CommonAdminView::getProvinceEditOrCreateView());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProvinceRequest $request): RedirectResponse
    {
        $province = Province::create($request->validated());
        return redirect()->route('')->with('success', 'Province created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province): View | RedirectResponse
    {
        $provinceToShow = $this->getProvincesIfActiveOrNot($province);
        return view(CommonAdminView::getProvinceShowView(), [
            'province' => $provinceToShow,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province): View | RedirectResponse
    {
        $provinceToShow = $this->getProvincesIfActiveOrNot($province);
        return view(CommonAdminView::getProvinceEditOrCreateView(), [
            'province' => Province::findOrFail($province->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProvinceRequest $request, Province $province)
    {        
        try {
            $existingProvince = $this->getProvincesIfActiveOrNot($province);
            $existingProvince->update($request->validated());
            // Redirect to the appropriate route with a success message
            return redirect()->back()->with('success', 'Province updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update province: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        try {
            $existingProvince = $this->getProvincesIfActiveOrNot($province);
            $existingProvince->update(['status_id' => 2]);
            return redirect()->back()->with('success', 'Province status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update province status: ' . $e->getMessage()]);
        }
    }

    private function getProvincesIfActiveOrNot(Province $province): Province | RedirectResponse
    {
        $existingProvince = Province::findOrFail($province->id);
        if($existingProvince->status()->id !== 1) {
            return redirect()->back()->withErrors(['error' => 'Province not found or inactive.']);
        }
        return $existingProvince;
    }
}
