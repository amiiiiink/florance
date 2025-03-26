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
                <select name="product_id" class="form-control">
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
