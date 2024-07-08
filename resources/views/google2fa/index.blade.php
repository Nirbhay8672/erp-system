<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ERP System">
    <meta name="author" content="ERP">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="url" content="{{ url('/') }}" />

    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" />

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/bootstrap5.min.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <main class="d-flex w-100 login-page-container">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="card">
                            <div class="card-body">

                                @if($errors->any())
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <strong>{{$errors->first()}}</strong>
                                    </div>
                                </div>
                                @endif

                                <div class="m-sm-3">
                                    <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group">
                                            <p class="text-center">Please enter the <strong>OTP</strong> generated on
                                                your Authenticator
                                                App. <br> Ensure
                                                you submit the current one because it refreshes every 30 seconds.</p>
                                            <label for="one_time_password" class="col-md-4 control-label">One Time
                                                Password</label>

                                            <div class="col">
                                                <input id="one_time_password" type="number" class="form-control"
                                                    name="one_time_password" required autofocus>
                                            </div>
                                        </div>

                                        <div class="form-group text-center">
                                            <div class="col mt-3">
                                                <button type="submit" class="btn btn-primary">
                                                    Login
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>