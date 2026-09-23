<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Turbo Laravel CRUD</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(
                135deg,
                #eef2f7,
                #d9e4f5
            );

            min-height: 100vh;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 35px;
            border-radius: 14px;

            box-shadow:
                0 15px 40px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #2d3748;
        }

        h2 {
            color: #1f2937;
        }

        .btn {
            display: inline-block;

            padding: 10px 16px;

            border: none;

            border-radius: 8px;

            cursor: pointer;

            text-decoration: none;

            color: white;

            font-weight: 600;

            font-size: 14px;

            transition: .3s;
        }

        .btn-primary {
            background: #4f46e5;
        }

        .btn-primary:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #ef4444;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-warning {
            background: #f59e0b;
        }

        .btn-warning:hover {
            background: #d97706;
        }

        .btn-secondary {
            background: #64748b;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        label {
            display: block;

            font-weight: 600;

            color: #374151;

            margin-bottom: 6px;
        }

        input,
        textarea,
        select {
            width: 100%;

            padding: 12px;

            margin-top: 4px;

            margin-bottom: 18px;

            border: 1px solid #e5e7eb;

            border-radius: 8px;

            font-size: 15px;

            background: white;
        }

        input:focus,
        textarea:focus,
        select:focus {

            outline: none;

            border-color: #4f46e5;

            box-shadow:
                0 0 0 3px rgba(79, 70, 229, .15);
        }

        textarea {
            min-height: 120px;

            resize: vertical;
        }

        .card {
            background: #f9fafb;

            border-radius: 12px;

            padding: 18px;

            margin-bottom: 15px;

            border: 1px solid #eee;

            transition: .3s;
        }

        .card:hover {
            transform: translateY(-3px);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            color: #111827;

            margin-bottom: 6px;
        }

        .card p {
            color: #6b7280;

            margin-bottom: 12px;

            line-height: 1.6;
        }

        .top-bar {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 20px;

            gap: 15px;
        }

        hr {
            border: none;

            border-top: 1px solid #eee;

            margin: 20px 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        .search-panel {
            background: #f8fafc;

            border: 1px solid #e2e8f0;

            padding: 20px;

            border-radius: 12px;

            margin-bottom: 20px;
        }

        .filter-grid {
            display: grid;

            grid-template-columns:
                2fr
                1fr
                1fr
                auto;

            gap: 12px;

            align-items: end;
        }

        .filter-grid input,
        .filter-grid select {
            margin-bottom: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        .stats-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 15px;
        }

        .stat-card {
            background: #f8fafc;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            padding: 20px;

            display: flex;

            align-items: center;

            gap: 15px;
        }

        .stat-icon {
            font-size: 28px;
        }

        .stat-label {
            color: #64748b;

            font-size: 13px;

            font-weight: 600;
        }

        .stat-number {
            font-size: 28px;

            font-weight: 700;

            color: #111827;

            margin-top: 4px;
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        .dashboard-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;
        }

        .dashboard-subtitle {
            color: #64748b;

            margin-top: 5px;
        }

        .dashboard-section {
            margin-top: 25px;
        }

        .section-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 15px;
        }

        .latest-post {
            background: #f8fafc;

            border: 1px solid #e2e8f0;

            padding: 20px;

            border-radius: 12px;

            display: flex;

            justify-content: space-between;

            gap: 20px;
        }

        .latest-post h3 {
            margin-bottom: 8px;

            color: #111827;
        }

        .latest-post p {
            color: #64748b;

            margin-bottom: 8px;
        }

        .activity-item {
            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 15px;

            border-bottom: 1px solid #e5e7eb;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-time {
            color: #94a3b8;

            font-size: 13px;

            margin-top: 4px;
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        .status-badge {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 999px;

            font-size: 12px;

            font-weight: 700;
        }

        .status-published {
            background: #dcfce7;

            color: #166534;
        }

        .status-draft {
            background: #fef3c7;

            color: #92400e;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        .pagination-wrapper {
            margin-top: 25px;

            display: flex;

            justify-content: center;
        }

        .pagination {
            display: flex;

            gap: 6px;

            align-items: center;
        }

        .pagination a,
        .pagination span {
            display: inline-block;

            padding: 8px 12px;

            border: 1px solid #e2e8f0;

            border-radius: 7px;

            text-decoration: none;

            color: #374151;

            background: white;

            font-size: 14px;
        }

        .pagination .active {
            background: #4f46e5;

            color: white;

            border-color: #4f46e5;
        }

        /*
        |--------------------------------------------------------------------------
        | Alerts
        |--------------------------------------------------------------------------
        */

        .alert {
            padding: 14px 18px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-weight: 600;
        }

        .alert-success {
            background: #dcfce7;

            color: #166534;

            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;

            color: #991b1b;

            border: 1px solid #fecaca;
        }

        .validation-errors {
            background: #fee2e2;

            color: #991b1b;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 20px;
        }

        .validation-errors ul {
            padding-left: 20px;
        }

        .empty-state {
            padding: 30px;

            text-align: center;

            color: #64748b;

            background: #f8fafc;

            border-radius: 10px;
        }

        .result-count {
            color: #64748b;

            font-size: 14px;

            margin-bottom: 15px;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 800px) {

            body {
                padding: 15px;
            }

            .container {
                padding: 20px;
            }

            .stats-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-header,
            .top-bar {
                flex-direction: column;

                align-items: stretch;
            }

        }

        @media (max-width: 500px) {

            .stats-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <h1>⚡ Turbo Laravel CRUD</h1>

    <div id="turbo-notification"></div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-error">
            {{ session('error') }}
        </div>

    @endif

    @if($errors->any())

        <div class="validation-errors">

            <strong>
                Please fix the following errors:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    @yield('content')

</div>

</body>

</html>