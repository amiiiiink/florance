@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">مدیریت محصولات</h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('products.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="جستجوی محصول..."
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary" style="border-radius: 12px;">جستجو</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ردیف</th>
                <th>نام محصول</th>
                <th>واحد خرید</th>
                <th>تعداد</th>
                <th>تعداد در هر واحد</th>
                <th>قیمت خرید(تومان)</th>
                <th>قیمت فروش(تومان)</th>

            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ toPersianNumbers(($products->currentPage() - 1) * $products->perPage() + $loop->iteration) }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        @if ($product->purchase_unit == 'carton')
                            {{ 'کارتُن' }}
                        @elseif ($product->purchase_unit == 'package')
                            {{ 'بسته' }}
                        @elseif ($product->purchase_unit == 'single')
                            {{ ' دانه ای' }}
                        @elseif ($product->purchase_unit == 'box')
                            {{ 'جعبه' }}
                        @else
                            {{ $product->purchase_unit }}
                        @endif
                    </td>
                    <td>{{ toPersianNumbers($product->stock_quantity) }}</td>
                    <td>{{ toPersianNumbers($product->unit_per_purchase) }}</td>

                    <td>{{ toPersianNumbers(number_format($product->purchase_price)) }}</td>
                    <td>{{ toPersianNumbers(number_format($product->sale_price)) }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $products->appends(['search' => request('search')])->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
