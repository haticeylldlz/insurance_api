@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Add Owner') }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owners.store') }}" method="POST" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="{{ __('Name') }}" autocomplete="given-name" maxlength="30">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="surname" class="form-label">{{ __('Surname') }}</label>
            <input type="text" name="surname" id="surname" value="{{ old('surname') }}"
                   class="form-control @error('surname') is-invalid @enderror"
                   placeholder="{{ __('Surname') }}" autocomplete="family-name" maxlength="30">
            @error('surname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
    </form>
</div>
@endsection
