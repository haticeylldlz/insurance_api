@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('Add Car') }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" novalidata>
        @csrf
        <div class="mb-3">
            <label for="reg_number" class="form-label">{{ __('Registration Number') }}</label>
            <input type="text" name="reg_number" id="reg_number" value="{{ old('reg_number') }}"
                   class="form-control @error('reg_number') is-invalid @enderror"
                   placeholder="{{ __('Registration Number') }}" autocomplete="off" maxlength="32">
            @error('reg_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label">{{ __('Brand') }}</label>
            <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                   class="form-control @error('brand') is-invalid @enderror"
                   placeholder="{{ __('Brand') }}" autocomplete="off">
            @error('brand')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">{{ __('Model') }}</label>
            <input type="text" name="model" id="model" value="{{ old('model') }}"
                   class="form-control @error('model') is-invalid @enderror"
                   placeholder="{{ __('Model') }}" autocomplete="off">
            @error('model')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
           <label class="form-label">{{ __('Car Photos') }}</label>
             <input type="file" name="photos[]" multiple
                class="form-control @error('photos.*') is-invalid @enderror">

            @error('photos.*')
                 <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="owner_id" class="form-label">{{ __('Owner') }}</label>
            <select name="owner_id" id="owner_id" class="form-select @error('owner_id') is-invalid @enderror">
                <option value="">{{ __('Select Owner') }}</option>
                @foreach($owners as $owner)
                    <option value="{{ $owner->id }}" @selected(old('owner_id', request('owner_id')) == $owner->id)>
                        {{ $owner->name }} {{ $owner->surname }}
                    </option>
                @endforeach
            </select>
            @error('owner_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
    </form>
</div>
@endsection
