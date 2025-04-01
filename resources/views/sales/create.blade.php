@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>ثبت فاکتور فروش جدید</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div id="product-container">
                <div class="product-box p-3 mb-3 border rounded">
                    <label>محصول</label>
                    <select name="product_id[]" class="form-control product-select" id="product-select">
                        <option value="">انتخاب محصول...</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">
                                {{ $product->name }} ({{ $product->sale_price }} تومان)
                            </option>
                        @endforeach
                    </select>

                    <label class="mt-2">تعداد</label>
                    <input type="number" name="quantity[]" class="form-control quantity" min="1" value="1">

                    <label class="mt-2">قیمت</label>
                    <input type="text" name="price[]" class="form-control price" readonly>

                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-row">حذف</button>
                </div>
            </div>

            <button type="button" id="add-row" class="btn btn-success">افزودن محصول جدید</button>

            <div class="mt-4">
                <label>تخفیف (تومان)</label>
                <input type="number" name="discount" id="discount" class="form-control" min="0" value="0">
            </div>

            <div class="mt-4 border p-3 rounded bg-light">
                <h4>جمع کل</h4>
                <p>تعداد کل: <span id="total-quantity">0</span></p>
                <p>مجموع قیمت: <span id="total-price">0</span> تومان</p>
                <p>مبلغ نهایی: <span id="final-price">0</span> تومان</p>
            </div>

            <button type="submit" class="btn btn-primary mt-3">ثبت فروش</button>
        </form>
    </div>
@endsection

@section('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#product-select').select2({
                placeholder: "محصول موردنظر را جستجو کنید...",
                allowClear: true
            });
            function calculateTotals() {
                let totalQuantity = 0;
                let totalPrice = 0;

                $('.product-box').each(function () {
                    let quantity = parseInt($(this).find('.quantity').val()) || 0;
                    let price = parseFloat($(this).find('.product-select option:selected').data('price')) || 0;
                    totalQuantity += quantity;
                    totalPrice += price * quantity;
                });

                let discount = parseFloat($('#discount').val()) || 0;
                let finalPrice = Math.max(totalPrice - discount, 0);

                $('#total-quantity').text(totalQuantity.toLocaleString());
                $('#total-price').text(totalPrice.toLocaleString());
                $('#final-price').text(finalPrice.toLocaleString());
            }

            $(document).on('change', '.product-select', function () {
                let price = $(this).find(':selected').data('price') || 0;
                $(this).closest('.product-box').find('.price').val(price);
                calculateTotals();
            });

            $(document).on('input', '.quantity', function () {
                calculateTotals();
            });

            $('#add-row').click(function () {
                let newRow = `
                    <div class="product-box p-3 mb-3 border rounded">
                        <label>محصول</label>
                        <select name="product_id[]" class="form-control product-select">
                            <option value="">انتخاب محصول...</option>
                            @foreach ($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">
                                {{ $product->name }} ({{ $product->sale_price }} تومان)
                            </option>
                            @endforeach
                </select>

                <label class="mt-2">تعداد</label>
                <input type="number" name="quantity[]" class="form-control quantity" min="1" value="1">

                <label class="mt-2">قیمت</label>
                <input type="text" name="price[]" class="form-control price" readonly>

                <button type="button" class="btn btn-danger btn-sm mt-2 remove-row">حذف</button>
            </div>
`;
                $('#product-container').append(newRow);
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('.product-box').remove();
                calculateTotals();
            });

            $('#discount').on('input', function () {
                calculateTotals();
            });
        });
    </script>
@endsection
