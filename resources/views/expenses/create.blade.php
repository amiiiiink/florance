@extends('layouts.app')

@section('title', 'افزودن هزینه جدید')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-primary">افزودن هزینه جدید</h2>

        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">نام هزینه</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">مبلغ</label>
                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
                @error('amount')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">تاریخ</label>
                <input type="text" id="date-picker" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">افزودن</button>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- اضافه کردن استایل‌های تقویم شمسی -->
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">

    <!-- اضافه کردن اسکریپت‌های مورد نیاز -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#date-picker").persianDatepicker({
                format: "YYYY-MM-DD",
                autoClose: true,
                initialValue: false,
                calendarType: "persian",
                observer: true
            });
        });
    </script>
@endsection
