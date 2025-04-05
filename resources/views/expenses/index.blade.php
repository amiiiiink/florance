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
                <th>ردیف</th>
                <th>نام هزینه</th>
                <th>نوع بدهی</th>
                <th>توضیحات</th>
                <th>مبلغ</th>
                <th>تاریخ</th>
                <th>وضعیت</th>
                <th>اقدامات</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ toPersianNumbers($loop->iteration) }}</td>
                    <td>{{ $expense->name }}</td>
                    <td>
                        @if($expense->type == "cash")
                            {{ 'نقدی' }}
                        @elseif($expense->type == "check")
                            {{ 'چک' }}
                        @endif
                    </td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ toPersianNumbers(number_format($expense->amount)) }} تومان</td>
                    <td>{{ toPersianNumbers(\Verta::instance($expense->date)->format('Y/m/d')) }}</td>
                    <td>
                        @if($expense->status == "new")
                            <span class="badge bg-primary">جدید</span>
                        @elseif($expense->status == "payed")
                            <span class="badge bg-success">پرداخت شده</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="delete-form" data-name="{{ $expense->name }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" style="font-size: 12px; padding: 3px 6px;">حذف</button>
                        </form>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.querySelectorAll('.delete-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // جلوگیری از ارسال فرم

                    const expenseName = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: `هزینه «${expenseName}» حذف خواهد شد!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'بله، حذف شود',
                        cancelButtonText: 'لغو',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        </script>

@endsection
