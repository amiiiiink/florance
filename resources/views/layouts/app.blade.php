<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'نرم‌افزار سوپرمارکت')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-family: Vazirmatn, sans-serif;
        }
        /* For mobile devices (below 768px) */
        @media (max-width: 768px) {
            .product-select {
                width: 100% !important; /* Make the select take up the full width on mobile */
            }
        }
    </style>
</head>
<body dir="rtl">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">سوپرمارکت فلورانس</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">داشبورد</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('purchase_invoices.create') }}">آپلود فاکتور های خرید</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products.create') }}">ثبت  خرید</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('sales.create') }}">ثبت فروش</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('expenses.index') }}">سر رسید بدهی ها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">ویزیتور ها</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
{{--<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>--}}
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

@yield('scripts')
</body>
</html>

