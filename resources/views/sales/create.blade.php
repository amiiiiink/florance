@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>ثبت فروش جدید</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>محصول</label>
                <select id="product-select" name="product_id" class="form-control">
                    <option value="">انتخاب محصول...</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sale_price }} تومان)</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>تعداد</label>
                <input type="number" name="quantity" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">ثبت فروش</button>
        </form>
    </div>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#product-select').select2({
                placeholder: "محصول موردنظر را جستجو کنید...",
                allowClear: true
            });
        });
    </script>
@endsection
