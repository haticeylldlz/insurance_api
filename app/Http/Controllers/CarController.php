<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Car::class, 'car');
    }

    public function index()
    {
        $cars = auth()->user()->isAdmin()
            ? Car::with('owner')->get()
            : Car::with('owner')->whereHas('owner', fn ($query) => $query->where('user_id', auth()->id()))->get();

        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $owners = $this->accessibleOwners();

        return view('cars.create', compact('owners'));
    }

    public function store(StoreCarRequest $request)
    {
        $car = Car::create($request->validated());

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('cars', 'public');

                $car->photos()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('cars.index');
    }

    public function edit(Car $car)
    {
        $car->load('photos');
        $owners = $this->accessibleOwners();

        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $validated = $request->validated();
        $car->update($validated);

        if (! empty($validated['delete_photo_ids'])) {
            $photosToDelete = $car->photos()->whereIn('id', $validated['delete_photo_ids'])->get();

            foreach ($photosToDelete as $photo) {
                Storage::disk('public')->delete($photo->path);
                $photo->delete();
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('cars', 'public');

                $car->photos()->create([
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('cars.index');
    }

    public function destroy(Car $car)
    {
        foreach ($car->photos as $photo) {
            Storage::disk('public')->delete($photo->path);
        }

        $car->delete();

        return redirect()->route('cars.index');
    }

    public function show(Car $car)
    {
        $car->load(['owner', 'photos']);

        return view('cars.show', compact('car'));
    }

    private function accessibleOwners()
    {
        return auth()->user()->isAdmin()
            ? Owner::orderBy('name')->get()
            : auth()->user()->owners()->orderBy('name')->get();
    }
}
