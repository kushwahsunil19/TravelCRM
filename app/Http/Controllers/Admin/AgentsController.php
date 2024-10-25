<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent; // Make sure to include the correct model

class AgentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Agent::query(); // Updated to use Agent model

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        if ($request->filled('state')) {
            $query->where('state', 'like', '%' . $request->state . '%');
        }
        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        $agents = $query->get();
        return view('admin.agents.agents', compact('agents'));
    }

    public function create()
    {
        return view('admin.agents.add-agent');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
            'email' => 'required|email|unique:agents',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $agent = new Agent($request->all());

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $fileName);
            $agent->image = $fileName;
        }

        $agent->save();
        $agentDetails = Agent::latest()->get();
        return response()->json(['status' => true, 'data' => $agentDetails, 'message' => 'Agent details added successfully']);
    }

    public function show(Agent $agent)
    {
        return view('admin.agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return response()->json(['status' => true, 'data' => $agent, 'message' => 'Agent details retrieved successfully']);
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|numeric|digits_between:10,15|regex:/^(?:\+?\d{1,3})?\d{10,15}$/',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $agent->update($request->all());

        if ($request->hasFile('image')) {
            if ($agent->image && file_exists(public_path('profile/' . $agent->image))) {
                unlink(public_path('profile/' . $agent->image));
            }

            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile'), $fileName);
            $agent->image = $fileName;
        }

        $agent->save();
        return response()->json(['status' => true, 'data' => $agent, 'message' => 'Agent details updated successfully']);
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent deleted successfully.');
    }
}
