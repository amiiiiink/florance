@extends('layouts.app')

@section('title', 'افزودن فاکتور جدید')

@section('content')
    <div class="">
        <h2>
            <a href="{{ route('purchase_invoices.index') }}" class="btn btn-success">لیست فاکتور ها</a>
        </h2>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">افزودن فاکتور جدید</div>
        <div class="card-body">
            <form action="{{ route('purchase_invoices.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">عنوان</label>
                    <input type="text" name="title" class="form-control" >
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">توضیحات</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>


                <div class="mb-3">
                    <label class="form-label">فایل فاکتور (اختیاری)</label>
                    <input type="file" name="file" class="form-control">
                </div>



                <button type="submit" class="btn btn-success">ثبت فاکتور</button>
                <a href="{{ route('purchase_invoices.index') }}" class="btn btn-secondary">بازگشت</a>
            </form>
        </div>
    </div>
@endsection
