@extends('layouts.app')

@section('title', 'لیست فاکتورهای خرید')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h2>لیست فاکتورهای خرید</h2>
        <a href="{{ route('purchase_invoices.create') }}" class="btn btn-primary">افزودن فاکتور جدید</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <table class="table table-striped mt-3">
        <thead class="table-dark">
        <tr>
            <th>عنوان</th>
            <th>فایل</th>
            <th>وضعیت</th>
            <th>توضیحات</th>
            <th>تاریخ</th>
            <th>عملیات</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->title }}</td>
                <td>
                    @if($invoice->file_path)
                        <a href="{{ Storage::url($invoice->file_path) }}" class="btn btn-sm btn-success" target="_blank">دانلود</a>
                    @else
                        <span class="text-muted">ندارد</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $invoice->status == 'submitted' ? 'success' : ($invoice->status == 'new' ? 'warning' : 'danger') }}">
                        {{ $invoice->status == 'submitted' ? 'ثبت شده' : ($invoice->status == 'submitted' ? 'ثبت نشده' : 'ثبت نشده') }}
                    </span>
                </td>
                <td>{{ $invoice->description }}</td>
                <td>{{ \Hekmatinasser\Verta\Verta::instance($invoice->created_at)->format('%d %B %Y') }}</td>
                <td>
                    <button class="btn btn-sm btn-{{ $invoice->status == 'new' ? 'success' : ($invoice->status == 'new' ? 'warning' : 'danger') }} change-status"
                            data-id="{{ $invoice->id }}"
                            data-status="{{ $invoice->status }}">
                        {{ $invoice->status == 'new' ? 'ثبت شد' : 'ثبت نشده' }}
                    </button>

                    <form action="{{ route('purchase_invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('آیا مطمئن هستید؟')">حذف</button>
                    </form>
                </td>


            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $invoices->links('pagination::bootstrap-5') }}
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.change-status', function () {
            let invoiceId = $(this).data('id');
            let currentStatus = $(this).data('status');
            let newStatus = currentStatus === 'new' ? 'submitted' : 'new';

            $.ajax({
                url: '{{ route('purchase-invoices.change-status') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: invoiceId,
                    status: newStatus
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('مشکلی رخ داده است.');
                    }
                }
            });
        });
    </script>

@endsection
