
@extends('layouts.app')

@section('content')
<h2>{{ __('Car Owners') }}</h2>

@can('create', App\Models\Owner::class)
    <a href="{{ route('owners.create') }}" class="btn btn-success mb-3">{{ __('Add Owner') }}</a>
@endcan

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <tr>
            <th>{{ __('ID') }}</th>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Surname') }}</th>
            @if(auth()->user()->isAdmin())
                <th>{{ __('Agent') }}</th>
            @endif
            <th>{{ __('Actions') }}</th>
        </tr>
        @foreach($owners as $owner)
        <tr>
            <td>{{ $owner->id }}</td>
            <td>{{ $owner->name }}</td>
            <td>{{ $owner->surname }}</td>
            @if(auth()->user()->isAdmin())
                <td>{{ $owner->user?->name ?? '—' }}</td>
            @endif
            <td>
                <a href="{{ route('owners.show', $owner) }}" class="btn btn-info btn-sm">{{ __('View') }}</a>

                @can('update', $owner)
                    <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                @endcan

                @can('delete', $owner)
                    <form action="{{ route('owners.destroy', $owner) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                    </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
