@extends('layouts.app')

@section('title', 'افزودن بازدیدکننده جدید')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-primary">افزودن ویزیتور جدید</h2>

        <form action="{{ route('visitors.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">نام شرکت</label>
                <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror"
                       value="{{ old('company_name') }}">
                @error('company_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">نام ویزیتور</label>
                <input type="text" name="visitor_name" class="form-control @error('visitor_name') is-invalid @enderror"
                       value="{{ old('visitor_name') }}">
                @error('visitor_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">شماره تماس ویزیتور</label>
                <input type="text" name="visitor_number" class="form-control @error('visitor_number') is-invalid @enderror"
                       value="{{ old('visitor_number') }}">
                @error('visitor_number')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">توضیحات</label>
                <textarea class="form-control @error('description') is-invalid @enderror"
                          id="description"
                          name="description"
                          rows="3">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">ثبت ویزیتور</button>
        </form>
    </div>
@endsection
