@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>داشبورد فروش روزانه </h2>
        <div style="text-align: center; margin-bottom:7px;padding: 10px; background-color: rgba(31, 157, 110, 0.6);color: #ffffff">
            <!-- Shamsi Date using Verta -->
            <p>{{ \Verta::now()->format('%d %B %Y') }}</p>

            <!-- Real-time Shamsi Time using JavaScript -->
            <p> <span id="time">{{ \Verta::now()->format('H:i:s') }}</span></p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card p-3">
                    <h4>مجموع فروش امروز: {{ number_format($totalRevenue) }} تومان</h4>
                    <p>تعداد کل محصولات فروخته‌شده: {{ number_format($totalQuantity) }} عدد</p>
                    <p>مجموع تخفیف‌های اعمال‌شده: {{ number_format($totalDiscount) }} تومان</p>
                    <p>فروش نهایی پس از تخفیف: {{ number_format($finalRevenue) }} تومان</p>
                    <p>سود خالص روزانه پس از تخفیف: :... تومان</p>
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



        <h4 class="mt-4">فاکتورهای امروز</h4>
        <div class="row">
            @foreach ($invoices as $invoice)
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <strong>فاکتور #{{ $invoice->id }}</strong> -
                            تاریخ:
                            {{ \Verta::instance($invoice->created_at)->format('Y/m/d H:i') }}
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($invoice->sales as $sale)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>{{ $sale->product->name }} - تعداد: {{ $sale->quantity }}</span>
                                        <span>{{ number_format($sale->total_price) }} تومان</span>
                                    </li>
                                @endforeach
                            </ul>
                            <hr>
                            <p>جمع کل: <strong>{{ number_format($invoice->total_price) }} تومان</strong></p>
                            <p>تخفیف: <strong>{{ number_format($invoice->discount) }} تومان</strong></p>
                            <p>قیمت نهایی: <strong>{{ number_format($invoice->final_price) }} تومان</strong></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Invoice Pagination -->
        <div class="pagination-container mt-4">
            <nav aria-label="Invoices page navigation">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    @if ($invoices->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">قبلی</a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $invoices->previousPageUrl() . '&invoice_page=' . $invoices->currentPage() - 1 }}">قبلی</a>
                        </li>
                    @endif

                    <!-- Page Number Links -->
                    @foreach ($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
                        <li class="page-item {{ $invoices->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url . '&invoice_page=' . $page }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <!-- Next Button -->
                    @if ($invoices->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $invoices->nextPageUrl() . '&invoice_page=' . $invoices->currentPage() + 1 }}">بعدی</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-disabled="true">بعدی</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        // Function to update the time every second
        function updateTime() {
            const now = new Date();
            const time = now.toLocaleTimeString('fa-IR'); // Persian locale for time
            document.getElementById('time').textContent = time;
        }

        setInterval(updateTime, 1000); // Update the time every second
    </script>
@endsection
