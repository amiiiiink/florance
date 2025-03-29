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
                <th>موجودی</th>
                <th>واحد خرید</th>
                <th>فروش</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->purchase_price }}</td>
                    <td>{{ $product->sale_price }}</td>
                    <td>
                        @if ($product->unit == 'carton')
                            کارتُن
                        @elseif ($product->unit == 'package')
                            بسته
                        @elseif ($product->unit == 'single')
                            تک
                        @elseif ($product->unit == 'box')
                            جعبه
                        @else
                            {{ $product->unit }} <!-- Default fallback if the unit doesn't match any of the above -->
                        @endif
                    </td>

                    <td>{{ $product->purchase_unit }}</td>
                    <td>
                        <form method="POST" action="{{ route('sales.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" min="1" required>
                            <button type="submit" class="btn btn-primary btn-sm">فروش</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
