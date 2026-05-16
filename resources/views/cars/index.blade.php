@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Cars') }}</h2>

    @can('create', App\Models\Car::class)
        <a href="{{ route('cars.create') }}" class="btn btn-success mb-3">{{ __('Add Car') }}</a>
    @endcan

    @if($cars->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Reg Number') }}</th>
                    <th>{{ __('Brand') }}</th>
                    <th>{{ __('Model') }}</th>
                    <th>{{ __('Owner') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cars as $car)
                <tr>
                    <td>{{ $car->id }}</td>
                    <td>{{ $car->reg_number }}</td>
                    <td>{{ $car->brand }}</td>
                    <td>{{ $car->model }}</td>
                    <td>{{ $car->owner->name ?? '' }} {{ $car->owner->surname ?? '' }}</td>
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
        <p>{{ __('No cars yet.') }}</p>
    @endif
</div>
@endsection
