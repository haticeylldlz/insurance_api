<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CarApiController extends Controller
{
    public function index()
    {
        $cars = Car::with('owner')->get();

        return response()->json([
            'status' => true,
            'data' => $cars,
        ]);
    }

    public function show($id)
    {
        $car = Car::with('owner')->find($id);

        if (! $car) {
            return response()->json([
                'status' => false,
                'message' => 'Car not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $car,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reg_number' => ['required', 'string', 'max:32', Rule::unique('cars', 'reg_number')],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'owner_id' => ['required', 'integer', 'exists:owners,id'],
        ]);

        $car = Car::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Car created',
            'data' => $car->load('owner'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $car = Car::find($id);

        if (! $car) {
            return response()->json([
                'status' => false,
                'message' => 'Car not found',
            ], 404);
        }

        $validated = $request->validate([
            'reg_number' => ['required', 'string', 'max:32', Rule::unique('cars', 'reg_number')->ignore($car->id)],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'owner_id' => ['required', 'integer', 'exists:owners,id'],
        ]);

        $car->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Car updated',
            'data' => $car->fresh()->load('owner'),
        ]);
    }

    public function destroy($id)
    {
        $car = Car::find($id);

        if (! $car) {
            return response()->json([
                'status' => false,
                'message' => 'Car not found',
            ], 404);
        }

        $car->delete();

        return response()->json([
            'status' => true,
            'message' => 'Car deleted',
        ]);
    }
}
