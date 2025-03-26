@extends('layouts.app')

@section('title', 'ویرایش محصول')

@section('content')
    <div class="container">
        <h2 class="mb-4">ویرایش محصول</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">نام محصول</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <button type="submit" class="btn btn-warning">ویرایش</button>
        </form>
    </div>
@endsection
