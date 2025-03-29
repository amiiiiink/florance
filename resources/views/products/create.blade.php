@extends('layouts.app')

@section('title', 'افزودن محصول جدید')

@section('content')
    <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>افزودن محصول جدید به انبار</h2>
                <a href="{{ route('products.index') }}" class="btn btn-primary">لیست محصولات</a>
            </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">نام محصول</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" >
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <div class="mb-3">
                <label class="form-label">واحد خرید</label>
                <select name="purchase_unit" class="form-control @error('purchase_unit') is-invalid @enderror">
                    <option>...</option>
                    <option value="carton" {{ old('purchase_unit') == 'carton' ? 'selected' : '' }}>کارتن</option>
                    <option value="box" {{ old('purchase_unit') == 'box' ? 'selected' : '' }}>باکس</option>
                    <option value="package" {{ old('purchase_unit') == 'package' ? 'selected' : '' }}>بسته</option>
                    <option value="single" {{ old('purchase_unit') == 'single' ? 'selected' : '' }}>دانه‌ای</option>
                </select>

                @error('purchase_unit')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">تعداد</label>
                <input type="text" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" value="{{ old('stock_quantity') }}" >
                @error('stock_quantity')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>



            <div class="mb-3">
                <label class="form-label">تعداد در هر واحد</label>
                <input type="text" name="items_per_unit" class="form-control @error('items_per_unit') is-invalid @enderror" value="{{ old('items_per_unit') }}" >
                @error('items_per_unit')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">قیمت خرید</label>
                <input type="text" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" placeholder="مثلا ۱۰۰۰ تومان" >
                @error('purchase_price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label"> قیمت فروش هر واحد</label>
                <input type="text" name="sale_price" class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}" placeholder="مثلا ۱۰۰۰ تومان">
                @error('sale_price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">افزودن</button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function formatNumberInput(input) {
                input.addEventListener("input", function () {
                    let value = input.value.replace(/,/g, ''); // حذف کاماهای قبلی
                    if (!isNaN(value) && value !== "") {
                        input.value = Number(value).toLocaleString('en-US');
                    }
                });
            }

            formatNumberInput(document.querySelector('input[name="purchase_price"]'));
            formatNumberInput(document.querySelector('input[name="sale_price"]'));
        });
    </script>

@endsection
