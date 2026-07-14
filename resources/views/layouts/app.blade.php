<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMS Server</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">



<style>
body{
    background:#f4efe8;
    font-family: Arial, sans-serif;
    color:#2b211c;
}

.navbar{
    background:#fffaf3!important;
    border:1px solid #e6d8c8;
    border-radius:16px;
    margin-top:20px;
    padding:14px 18px;
    box-shadow:0 8px 25px rgba(55,35,20,.10);
}

.navbar-brand{
    color:#2b120d!important;
    font-weight:800;
    font-size:22px;
}

.navbar .nav-link{
    color:#4b352b!important;
    font-weight:600;
}

.navbar .nav-link:hover{
    color:#9b2f23!important;
}

.navbar-text{
    color:#6f5648!important;
    font-weight:600;
}

.container{
    background:#fffaf3;
    color:#2b211c;
    margin-top:28px;
    padding:28px;
    border-radius:20px;
    box-shadow:0 12px 35px rgba(55,35,20,.12);
    border:1px solid #eadccb;
}

h1,h2,h3{
    color:#2b120d;
    font-weight:800;
}

.form-control,
select.form-control{
    border-radius:10px;
    border:1px solid #d8c5b4;
    background:#fff;
    color:#2b211c;
    padding:10px 13px;
}

.btn-primary{
    background:#8f2d22;
    border-color:#8f2d22;
    border-radius:10px;
    font-weight:700;
}

.btn-primary:hover{
    background:#6f2119;
    border-color:#6f2119;
}

.btn-success{
    background:#3f6f3f;
    border-color:#3f6f3f;
    border-radius:10px;
    font-weight:700;
}

.btn-secondary{
    background:#6d625b;
    border-color:#6d625b;
    border-radius:10px;
    font-weight:700;
}

table{
    background:#fff;
    border-radius:14px;
    overflow:hidden;
}

table thead th{
    background:#2b120d!important;
    color:#fff!important;
    border-color:#3a1a13!important;
    padding:13px!important;
}

table tbody tr:nth-child(even){
    background:#faf3eb;
}

table tbody tr:hover{
    background:#f4dfc7;
}

table td{
    vertical-align:middle;
    font-size:14px;
    padding:11px!important;
    border-color:#eadccb!important;
}

.pagination .page-link{
    color:#8f2d22;
}

.pagination .active .page-link{
    background:#8f2d22;
    border-color:#8f2d22;
}
</style>



    <style>
        @media (max-width: 991.98px) {
            .navbar-collapse {
                position: fixed;
                top: 56px; /* Adjust this value based on your navbar height */
                left: -100%;
                padding-left: 15px;
                padding-right: 15px;
                padding-bottom: 15px;
                width: 75%;
                height: 100%;
                background-color: #f8f9fa;
                transition: all 0.3s ease-in-out;
                z-index: 1000;
            }

            .navbar-collapse.show {
                left: 0;
            }

            body.menu-open {
                overflow: hidden;
            }

            .navbar-toggler {
                z-index: 1001;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">ADMS Server</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('devices.index') }}">Device</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('devices.Attendance') }}">Attendance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('devices.DeviceLog') }}">Device Log</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('devices.FingerLog') }}">Finger Log</a>
                    </li>
		    </li>
                        <a class="nav-link" href="/device-users">Device Users</a>
                    </li>
<li class="nav-item">
    <a class="nav-link" href="/attendance-report">Attendance Report</a>
</li>
                </ul>
            </div>
            <span class="navbar-text d-none d-lg-block">
                {{ now() }}
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.navbar-toggler').on('click', function() {
                $('body').toggleClass('menu-open');
            });

            $('.nav-link').on('click', function() {
                if ($(window).width() < 992) {
                    $('.navbar-collapse').removeClass('show');
                    $('body').removeClass('menu-open');
                }
            });
        });
    </script>
</body>
</html>
