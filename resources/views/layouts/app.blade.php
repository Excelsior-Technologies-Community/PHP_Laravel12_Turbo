<!DOCTYPE html>
<html>
<head>
    <title>Turbo Laravel CRUD</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>

        /* ===== RESET ===== */
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body{
            background:linear-gradient(135deg,#eef2f7,#d9e4f5);
            min-height:100vh;
            padding:40px;
        }

        /* ===== CONTAINER ===== */
        .container{
            max-width:900px;
            margin:auto;
            background:#fff;
            padding:35px;
            border-radius:14px;
            box-shadow:0 15px 40px rgba(0,0,0,0.08);
        }

        h1{
            text-align:center;
            margin-bottom:25px;
            color:#2d3748;
        }

        /* ===== BUTTONS ===== */
        .btn{
            padding:10px 16px;
            border:none;
            border-radius:8px;
            cursor:pointer;
            text-decoration:none;
            color:white;
            font-weight:600;
            font-size:14px;
            transition:.3s;
        }

        .btn-primary{
            background:#4f46e5;
        }

        .btn-primary:hover{
            background:#4338ca;
            transform:translateY(-1px);
        }

        .btn-danger{
            background:#ef4444;
        }

        .btn-danger:hover{
            background:#dc2626;
        }

        .btn-warning{
            background:#f59e0b;
        }

        .btn-warning:hover{
            background:#d97706;
        }

        /* ===== FORM ===== */
        label{
            font-weight:600;
            color:#374151;
        }

        input, textarea{
            width:100%;
            padding:12px;
            margin-top:8px;
            margin-bottom:18px;
            border:1px solid #e5e7eb;
            border-radius:8px;
            font-size:15px;
            transition:.2s;
        }

        input:focus, textarea:focus{
            outline:none;
            border-color:#4f46e5;
            box-shadow:0 0 0 3px rgba(79,70,229,.15);
        }

        /* ===== CARD ===== */
        .card{
            background:#f9fafb;
            border-radius:12px;
            padding:18px;
            margin-bottom:15px;
            border:1px solid #eee;
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-3px);
            box-shadow:0 10px 25px rgba(0,0,0,0.08);
        }

        .card h3{
            color:#111827;
            margin-bottom:6px;
        }

        .card p{
            color:#6b7280;
            margin-bottom:12px;
        }

        /* ===== HEADER ACTION ===== */
        .top-bar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:20px;
        }

        hr{
            border:none;
            border-top:1px solid #eee;
            margin:20px 0;
        }

    </style>

</head>

<body>

<div class="container">

    <h1> Turbo Laravel CRUD</h1>

    @yield('content')

</div>

</body>
</html>