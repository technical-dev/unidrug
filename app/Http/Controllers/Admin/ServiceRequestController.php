<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceRequest::latest();

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($status = $request->status) {
            $query->where('status', $status);
        }

        if ($type = $request->type) {
            $query->where('service_type', $type);
        }

        $requests = $query->paginate(25)->withQueryString();
        return view('admin.service-requests.index', compact('requests'));
    }

    public function updateStatus(ServiceRequest $serviceRequest, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,completed',
        ]);

        $serviceRequest->update($validated);
        return redirect()->route('admin.service-requests.index')->with('success', 'Status updated.');
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        $serviceRequest->delete();
        return redirect()->route('admin.service-requests.index')->with('success', 'Service request deleted.');
    }
}
