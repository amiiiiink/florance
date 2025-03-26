@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>داشبورد فروش روزانه</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card p-3">
                    <h4>مجموع فروش امروز: {{ number_format($totalRevenue) }} تومان</h4>
                </div>
            </div>

            @if ($bestSellingProduct)
                <div class="col-md-6">
                    <div class="card p-3">
                        <h4>پرفروش‌ترین محصول: {{ $bestSellingProduct->product->name }} ({{ $bestSellingProduct->total_quantity }} عدد)</h4>
                    </div>
                </div>
            @endif
        </div>

        <h3 class="mt-4">لیست فروش‌های امروز</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>محصول</th>
                <th>تعداد</th>
                <th>مبلغ کل</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($salesToday as $sale)
                <tr>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->total_price) }} تومان</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
