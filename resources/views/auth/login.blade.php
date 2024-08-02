<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="ERP System">
    <meta name="author" content="ERP">

    <title>Login | ERP</title>

    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/font/cssa882.css') }}?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <link id="pagestyle" href="{{ asset('/css/app.css') }}?v=3.0.6" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('/font/css/all.min.css') }}" rel="stylesheet" />
</head>

<body>
    <main class="main-content mt-0 ps">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&amp;ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;auto=format&amp;fit=crop&amp;w=1950&amp;q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1 text-center">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0" style="letter-spacing:2px;">ERP Login</h4>
                                    <small class="text-white text-center">Sign in to your account to continue</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" role="form" class="text-start">
                                @csrf
                                    <div class="input-group input-group-outline my-3">
                                        <input
                                            id="email"
                                            type="text"
                                            class="form-control @error('email') is-invalid @enderror"
                                            name="email"
                                            placeholder="Enter email address"
                                            value="{{ old('email') }}"
                                            autocomplete="email"
                                            autofocus
                                        >
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="input-group input-group-outline mb-3">
                                        <input
                                            id="password"
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="Enter password"
                                            autocomplete="current-password"
                                        >
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-check" style="padding-left: 0px !important;">
                                        <input class="form-check-input" type="checkbox" id="show_password"
                                            onclick="showHidePassword()" />
                                        <label class="form-check-label text-small" for="show_password">Show
                                            Password</label>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">{{ __('Login') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function showHidePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>
