@extends('layouts.app')

@section('title', 'لیست هزینه‌ها')

@section('content')
    <div class="container">

        @if($errors->all())
            <div class="invalid-feedback">{{ $errors->toJson() }}</div>
        @endif

        <h2 class="mb-4 text-primary">لیست هزینه‌ها</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('expenses.create') }}" class="btn btn-success mb-3">افزودن هزینه جدید</a>

        <!-- Make the table responsive by wrapping it inside a div with the class 'table-responsive' -->
        <div class="table-responsive">
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
                        <td>
                            <span
                                class="show-full-text"
                                data-full-text="{{ $expense->description }}"
                                style="cursor: pointer; color: blue; text-decoration: underline;"
                            >
                                {{ Str::limit($expense->description, 14) }}
                            </span>
                        </td>
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
                            @if($expense->status == "new")
                                <div class="d-flex gap-2">
                                    <!-- Upload File Button -->
                                    <button class="btn btn-warning btn-sm" style="font-size: 9px; color: #fff" data-bs-toggle="modal" data-bs-target="#uploadFileModal" data-expense-id="{{ $expense->id }}" data-expense-name="{{ $expense->name }}">
                                        آپلود رسید
                                    </button>

                                    <!-- Delete Form Button -->
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="delete-form" data-name="{{ $expense->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="font-size: 12px; padding: 3px 6px;">
                                            حذف
                                        </button>
                                    </form>
                                </div>

                            @endif
                            @if($expense->file_path)
                                <a href="{{ Storage::url($expense->file_path) }}" class="btn btn-sm btn-info" target="_blank">دانلود</a>
                            @endif

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for file upload -->
    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFileModalLabel">آپلود فایل برای هزینه</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="uploadFileForm" action="{{ route('expenses.updateStatusAndFile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <input type="hidden" name="expense_id" id="expense_id">
                        <div class="mb-3">
                            <label for="file" class="form-label">فایل</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".jpg,.jpeg,.png,.pdf">
                            @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">توضیحات</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3">
        {{ old('description', 'توضیحات پرداخت :') }}
    </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                        <button type="submit" class="btn btn-primary">آپلود</button>
                    </div>
                </form>
            </div>
        </div>
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

        // Set the expense id in the modal when the button is clicked
        var uploadFileModal = document.getElementById('uploadFileModal');
        uploadFileModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var expenseId = button.getAttribute('data-expense-id'); // Extract info from data-* attributes
            var expenseName = button.getAttribute('data-expense-name');

            var modalTitle = uploadFileModal.querySelector('.modal-title');
            var expenseInput = uploadFileModal.querySelector('#expense_id');
            expenseInput.value = expenseId;
        });

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.show-full-text').forEach(function (element) {
                element.addEventListener('click', function () {
                    const fullText = this.dataset.fullText;

                    Swal.fire({
                        title: 'توضیحات',
                        text: fullText,
                        icon: 'info',
                        confirmButtonText: 'بستن'
                    });
                });
            });
        });


    </script>
@endsection
