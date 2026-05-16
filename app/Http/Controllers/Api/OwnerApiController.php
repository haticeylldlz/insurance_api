<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Owner::all(),
        ]);
    }

    public function show($id)
    {
        $owner = Owner::find($id);

        if (! $owner) {
            return response()->json([
                'status' => false,
                'message' => 'Owner not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $owner,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'surname' => ['required', 'string', 'min:2', 'max:30'],
        ]);

        $owner = Owner::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Owner created',
            'data' => $owner,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $owner = Owner::find($id);

        if (! $owner) {
            return response()->json([
                'status' => false,
                'message' => 'Owner not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:30'],
            'surname' => ['required', 'string', 'min:2', 'max:30'],
        ]);

        $owner->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Owner updated',
            'data' => $owner->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $owner = Owner::find($id);

        if (! $owner) {
            return response()->json([
                'status' => false,
                'message' => 'Owner not found',
            ], 404);
        }

        $owner->delete();

        return response()->json([
            'status' => true,
            'message' => 'Owner deleted',
        ]);
    }
}
