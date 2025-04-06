@extends('layouts.app')

@section('title', 'لیست بازدیدکنندگان')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-primary">لیست ویزیتور ها</h2>

        <a href="{{ route('visitors.create') }}" class="btn btn-primary mb-3">افزودن ویزیتور جدید</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>نام شرکت</th>
                <th>نام بازدیدکننده</th>
                <th>شماره تماس</th>
                <th>توضیحات</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($visitors as $visitor)
                <tr>
                    <td>{{ $visitor->company_name }}</td>
                    <td>{{ $visitor->visitor_name }}</td>
                    <td>{{ $visitor->visitor_number }}</td>
                    <td>{{ $visitor->description }}</td>
                    <td>

                        <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('آیا مطمئن هستید؟')" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">هیچ بازدیدکننده‌ای ثبت نشده است.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
