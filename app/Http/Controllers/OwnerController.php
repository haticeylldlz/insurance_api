<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Owner;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Owner::class, 'owner');
    }

    public function index()
    {
        $owners = auth()->user()->isAdmin()
            ? Owner::with('user')->get()
            : auth()->user()->owners;

        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(StoreOwnerRequest $request)
    {
        $data = $request->validated();

        if (! auth()->user()->isAdmin()) {
            $data['user_id'] = auth()->id();
        }

        Owner::create($data);

        return redirect()->route('owners.index');
    }

    public function show(Owner $owner)
    {
        $cars = $owner->cars;

        return view('owners.show', compact('owner', 'cars'));
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(UpdateOwnerRequest $request, Owner $owner)
    {
        $owner->update($request->validated());

        return redirect()->route('owners.index');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()->route('owners.index');
    }
}
