@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">مدیریت محصولات</h2>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>نام محصول</th>
                <th>قیمت خرید</th>
                <th>قیمت فروش</th>
                <th>واحد خرید</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->purchase_price }}</td>
                    <td>{{ $product->sale_price }}</td>
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
