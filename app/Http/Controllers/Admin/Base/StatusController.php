<?php

namespace App\Http\Controllers\Admin\Base;

use App\Common\CommonAdminView;
use App\Http\Controllers\Controller;
use App\Http\Requests\Base\StatusRequest;
use App\Models\Base\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(CommonAdminView::getStatusListView(), [
            'statuses' => Status::orderBy("id","desc")->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(CommonAdminView::getStatusEditOrCreateView());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusRequest $request)
    {
        try {
            $status = Status::create($request->validated());
            return redirect()->route('')->with('success', 'Status created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create status: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        return view(CommonAdminView::getStatusShowView(),[
            'status' => Status::findOrFail($status->id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        return view(CommonAdminView::getStatusEditOrCreateView(),[
            'status' => Status::findOrFail($status->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StatusRequest $request, Status $status)
    {
        try {
            $existingStatus = Status::findOrFail($status->id);
            $existingStatus->update($request->validated());
            return redirect()->back()->with('success', 'Status updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to update status: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        try {
            // Ensure related records are deleted before deleting the status
            $existingStatus = Status::findOrFail($status->id);

            // Example: Delete related records (adjust relationships as needed)
            $existingStatus->relatedModel()->delete();

            $existingStatus->delete();
        return redirect()->back()->with('success', 'Status deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete status: ' . $e->getMessage()]);
        }
    }
}
