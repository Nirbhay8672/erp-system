<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/images/favicon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('/images/favicon.png') }}">

    <meta name="description" content="ERP System">  
    <meta name="author" content="ERP">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="url" content="{{ url('/') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('/font/cssa882.css') }}?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link href="{{ asset('/css/icons/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('/css/icons/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('/font/iconcc0c.css') }}?family=Material+Icons+Round" rel="stylesheet">

    <link id="pagestyle" href="{{ asset('/css/app.css') }}?v=3.0.6" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('/css/custom.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('/font/css/all.min.css') }}" rel="stylesheet" />

    @inertiaHead

    <style>
        .async-hide {
            opacity: 0 !important
        }

        .required::after {
            content: ' *';
            color: red;
        }
    </style>
</head>

<body class="g-sidenav-show  bg-gray-200">

    @inertia

    @vite('resources/js/app.js')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('/js/popper.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/perfect-scrollbar.min.js') }}"></script> 
    <script src="{{ asset('/js/smooth-scrollbar.min.js') }}"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
</body>
</html>
