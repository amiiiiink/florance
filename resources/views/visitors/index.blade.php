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
                        <form action="{{ route('visitors.destroy', $visitor->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // برای هر فرم حذف، SweetAlert رو اضافه کن
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault(); // جلوگیری از ارسال فرم به صورت پیش‌فرض

                    // استفاده از SweetAlert برای تایید حذف
                    Swal.fire({
                        title: 'آیا مطمئن هستید؟',
                        text: "این عمل قابل بازگشت نیست!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'بله، حذف کن!',
                        cancelButtonText: 'لغو'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // ارسال فرم در صورت تایید
                        }
                    });
                });
            });
        });
    </script>
@endsection

