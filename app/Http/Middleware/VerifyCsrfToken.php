<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */

    // protected $except = [
    //     'http://127.0.0.1:8000/add-website',
    //     'https://phplaravel-1142719-4632540.cloudwaysapps.com/add-website',

    //     'http://127.0.0.1:8000/add-payment',
    //     'https://phplaravel-1142719-4632540.cloudwaysapps.com/add-payment',

    //     'http://127.0.0.1:8000/get-custom-key',
    //     'https://phplaravel-1142719-4632540.cloudwaysapps.com/get-custom-key',

    //     'http://127.0.0.1:8000/get-website-details',
    //     'https://phplaravel-1142719-4632540.cloudwaysapps.com/get-website-details',

    //     'http://127.0.0.1:8000/store-package-type',
    //     'http://127.0.0.1:8000/update-plugin-files',

    //     'http://127.0.0.1:8000/check-website-is-exist',
    //     'https://phplaravel-1142719-4632540.cloudwaysapps.com/check-website-is-exist',
    // ];
}