<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Member;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'page_name' => 'Dashboard',
        ]);
    }


    // public function getPluginDetails()
    // {
    //     $client = new GuzzleHttpClient();

    //     try {
    //         $response = $client->post("$this->wpServerUrl/wp-json/jwt-auth/v1/token", [
    //             'form_params' => [
    //                 'username' => $this->username,
    //                 'password' => $this->password,
    //             ],
    //         ]);

    //         $body = $response->getBody();
    //         $data = json_decode($body, true);

    //         if (isset($data['token'])) {
    //             $response = Http::get("$this->wpServerUrl/wp-json/get-plugin-details/data");
    //             $body = $response->getBody();
    //             $data = json_decode($body, true);

    //             if($data) {
    //                 return $this->successResponse(message: "Plugin details fetch successfully.", data : $data);
    //             } else {
    //                 return $this->errorResponse(message: "Somthing went wrong please try again.");
    //             }
    //         }
            
    //     } catch (RequestException $e) {
    //         return $this->errorResponse(message: "Somthing went wrong please try again.");
    //     }
    // }

    // public function activeOrDeactive(Request $request)
    // {
    //     $client = new GuzzleHttpClient();

    //     try {
    //         $response = $client->post("$this->wpServerUrl/wp-json/jwt-auth/v1/token", [
    //             'form_params' => [
    //                 'username' => $this->username,
    //                 'password' => $this->password,
    //             ],
    //         ]);

    //         $body = $response->getBody();
    //         $data = json_decode($body, true);

    //         if (isset($data['token'])) {

    //             $response = Http::post("$this->wpServerUrl/wp-json/update-plugin-status/submit",[
    //                 'status' => $request->status
    //             ]);

    //             $body = $response->getBody();
    //             $data = json_decode($body, true);

    //             if($data['success']) {
    //                 $msg = $request->status == 1 ? 'Plugin active successfully.' : 'Plugin Deactivate successfully.';
    //                 return $this->successResponse(message: $msg);
    //             } else {
    //                 return $this->errorResponse(message: "Somthing went wrong please try again.");
    //             }
    //         }
            
    //     } catch (RequestException $e) {
    //         return $this->errorResponse(message: "Somthing went wrong please try again.");
    //     }
    // }

    // public function delete()
    // {
    //     $client = new GuzzleHttpClient();

    //     try {
    //         $response = $client->post("$this->wpServerUrl/wp-json/jwt-auth/v1/token", [
    //             'form_params' => [
    //                 'username' => $this->username,
    //                 'password' => $this->password,
    //             ],
    //         ]);

    //         $body = $response->getBody();
    //         $data = json_decode($body, true);

    //         if (isset($data['token'])) {
    //             $response = Http::get("$this->wpServerUrl/wp-json/delete/data");
    //             $body = $response->getBody();
    //             $data = json_decode($body, true);

    //             if($data) {
    //                 return $this->successResponse(message: "Plugin delete successfully.");
    //             } else {
    //                 return $this->errorResponse(message: "Somthing went wrong please try again.");
    //             }
    //         }
            
    //     } catch (RequestException $e) {
    //         return $this->errorResponse(message: "Somthing went wrong please try again.");
    //     }
    // }

    public function generateInvoice()
    {
        Mail::to('hathaliyank@gmail.com')->send(new InvoiceMail(['client_name' => 'nux']));

        return Inertia::render('Dashboard', [
            'page_name' => 'Dashboard',
        ]);
    }
}
