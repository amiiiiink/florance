@extends('layouts.app')

@section('title', 'لیست هزینه‌ها')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-primary">لیست هزینه‌ها</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('expenses.create') }}" class="btn btn-success mb-3">افزودن هزینه جدید</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>نام هزینه</th>
                <th>مبلغ</th>
                <th>تاریخ</th>
                <th>اقدامات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->name }}</td>
                    <td>{{ number_format($expense->amount) }} تومان</td>
                    <td>{{ $expense->date }}</td>
                    <td>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
