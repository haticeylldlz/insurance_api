@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $owner->name }} {{ $owner->surname }}</h2>

    @can('update', $owner)
        <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning mb-2">{{ __('Edit Owner') }}</a>
    @endcan

    @can('delete', $owner)
        <form action="{{ route('owners.destroy', $owner) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger mb-2">{{ __('Delete Owner') }}</button>
        </form>
    @endcan

    <h3>{{ __('Cars') }}</h3>

    @if($cars->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>{{ __('Registration Number') }}</th>
                    <th>{{ __('Brand') }}</th>
                    <th>{{ __('Model') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                <tr>
                    <td>{{ $car->reg_number }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>
                        <a href="{{ route('cars.show', $car) }}" class="btn btn-info btn-sm">{{ __('View') }}</a>

                        @can('update', $car)
                            <a href="{{ route('cars.edit', $car) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                        @endcan

                        @can('delete', $car)
                            <form action="{{ route('cars.destroy', $car) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <p>{{ __('No cars for this owner yet.') }}</p>
    @endif

    @can('create', App\Models\Car::class)
        <a href="{{ route('cars.create', ['owner_id' => $owner->id]) }}" class="btn btn-success mt-2">{{ __('Add Car') }}</a>
    @endcan

    <a href="{{ route('owners.index') }}" class="btn btn-primary mt-3">{{ __('Back to Owners') }}</a>
</div>
@endsection
