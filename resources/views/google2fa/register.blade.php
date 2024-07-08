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
                        <div class="text-center mt-4">
                            <h1 class="h2 text-white">Set up Google Authenticator</h1>
                        </div>

                        <div class="card">
                            <div class="card-body text-center">
                                <div class="m-sm-3">
                                    <p>Set up your two factor authentication by scanning the barcode below.
                                        Alternatively, you can use
                                        the code <strong>{{ $secret }}</strong></p>
                                    <div>
                                        {!! $QR_Image !!}
                                    </div>
                                    <p>You must set up your Google Authenticator app before continuing. You will be
                                        unable to login
                                        otherwise</p>
                                    <div>
                                        <a href="{{ route('complete.registration') }}" class="btn btn-primary">Complete
                                            Registration</a>
                                    </div>
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