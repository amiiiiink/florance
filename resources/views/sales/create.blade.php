@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>ثبت فاکتور فروش جدید</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('sales.store') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>محصول</th>
                        <th>تعداد</th>
                        <th>قیمت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody id="product-rows">
                    <tr>
                        <td style="width: 60%;padding: 10px;">
                            <select name="product_id[]" class="form-control product-select">
                                <option value="">انتخاب محصول...</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">
                                        {{ $product->name }} ({{ $product->sale_price }} تومان)
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="quantity[]" class="form-control quantity" min="1" value="1"></td>
                        <td><input type="text" name="price[]" class="form-control price" ></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-row">حذف</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" id="add-row" class="btn btn-success">افزودن محصول جدید</button>

            <div id="dynamic-table" class="mt-4" style="display: none;">
                <h4>محصولات انتخاب شده</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>نام محصول</th>
                        <th>تعداد</th>
                        <th>قیمت</th>
                        <th>قیمت × تعداد</th>
                    </tr>
                    </thead>
                    <tbody id="dynamic-rows">
                    <!-- Dynamic product rows will be inserted here -->
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <label>تخفیف (تومان)</label>
                <input type="number" name="discount" id="discount" class="form-control" min="0" value="0">
            </div>

            <div class="mt-4">
                <h4>جمع کل</h4>
                <p>تعداد کل: <span id="total-quantity">0</span></p>
                <p>مجموع قیمت: <span id="total-price">0</span> تومان</p>
                <p>مبلغ نهایی: <span id="final-price">0</span> تومان</p>
            </div>

            <button type="submit" class="btn btn-primary">ثبت فروش</button>
        </form>
    </div>
@endsection

@section('scripts')
    <!-- Select2 Styles & Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            function initializeSelect2() {
                $('.product-select').select2({
                    placeholder: "محصول موردنظر را جستجو کنید...",
                    allowClear: true,
                    tags:true
                });
            }

            function calculateTotals() {
                let totalQuantity = 0;
                let totalPrice = 0;
                let dynamicRows = '';

                $('#product-rows tr').each(function () {
                    let quantity = parseInt($(this).find('.quantity').val()) || 0;
                    let price = parseFloat($(this).find('.product-select option:selected').data('price')) || 0;
                    totalQuantity += quantity;
                    let rowTotal = price * quantity;
                    totalPrice += rowTotal;

                    // Append dynamic table row with product details
                    let productName = $(this).find('.product-select option:selected').text().split(' (')[0]; // Get the product name
                    dynamicRows += `
                        <tr>
                            <td>${productName}</td>
                            <td>${quantity}</td>
                            <td>${price.toLocaleString()} تومان</td>
                            <td>${(rowTotal).toLocaleString()} تومان</td>
                        </tr>
                    `;
                });

                // Update the dynamic table
                $('#dynamic-rows').html(dynamicRows);

                // If there are products, show the result table
                if ($('#product-rows tr').length > 0) {
                    $('#dynamic-table').show();
                }

                // Calculate final price
                let discount = parseFloat($('#discount').val()) || 0;
                let finalPrice = Math.max(totalPrice - discount, 0); // Ensure no negative total

                // Update total fields
                $('#total-quantity').text(totalQuantity.toLocaleString());
                $('#total-price').text(totalPrice.toLocaleString());
                $('#final-price').text(finalPrice.toLocaleString());
            }

            // Initialize Select2 on first load
            initializeSelect2();

            // Update price field and recalculate totals when selecting a product
            $(document).on('change', '.product-select', function () {
                let price = $(this).find(':selected').data('price') || 0;
                let row = $(this).closest('tr');
                row.find('.price').val(price);
                calculateTotals();
            });

            // Recalculate totals when changing quantity
            $(document).on('input', '.quantity', function () {
                calculateTotals();
            });

            // Add new row
            $('#add-row').click(function () {
                let newRow = `
                    <tr>
                        <td>
                            <select name="product_id[]" class="form-control product-select">
                                <option value="">انتخاب محصول...</option>
                                @foreach ($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->sale_price }}">
                                        {{ $product->name }} ({{ $product->sale_price }} تومان)
                                    </option>
                                @endforeach
                </select>
            </td>
            <td><input type="number" name="quantity[]" class="form-control quantity" min="1" value="1"></td>
            <td><input type="text" name="price[]" class="form-control price" ></td>
            <td><button type="button" class="btn btn-danger remove-row">حذف</button></td>
        </tr>
`;
                $('#product-rows').append(newRow);
                initializeSelect2();
            });

            // Remove row and recalculate totals
            $(document).on('click', '.remove-row', function () {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            // Recalculate totals when discount changes
            $('#discount').on('input', function () {
                calculateTotals();
            });

            // Initial calculation
            calculateTotals();
        });
    </script>
@endsection
