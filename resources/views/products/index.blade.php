@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">مدیریت محصولات</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ردیف</th>
                <th>نام محصول</th>
                <th>قیمت خرید(تومان)</th>
                <th>قیمت فروش(تومان)</th>
                <th>واحد خرید</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ toPersianNumbers(number_format($product->purchase_price)) }}</td>
                    <td>{{ toPersianNumbers(number_format($product->sale_price)) }}</td>
                    <td>
                        @if ($product->purchase_unit == 'carton')
                            {{ 'کارتُن' }}
                        @elseif ($product->purchase_unit == 'package')
                            {{ 'بسته' }}
                        @elseif ($product->purchase_unit == 'single')
                            {{ 'تک' }}
                        @elseif ($product->purchase_unit == 'box')
                            {{ 'جعبه' }}
                        @else
                            {{ $product->purchase_unit }} <!-- Default fallback if the unit doesn't match any of the above -->
                        @endif
                    </td>


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
