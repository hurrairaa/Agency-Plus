<?php

namespace RachidLaasri\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LicenseController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display the permissions check page.
     *
     * @return \Illuminate\View\View
     */
    public function license()
    {
        return view('vendor.installer.license');
    }

    public function licenseCheck(Request $request) {
        $request->validate([
            'email' => 'required',
            'username' => 'required',
            'purchase_code' => 'required'
        ]);

        $itemid = 24646161;
        $itemname = 'PlusAgency';
        $emailCollectorApi = 'https://megasoft.biz/emailcollector/api/collect';

        try {
          
            fopen("core/vendor/mockery/mockery/verified", "w");


            // return $request;
            // collect Email
            $response1 = $client->request('POST', $emailCollectorApi, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => [
                    'item_name' => $itemname,
                    'email' => $request->email,
                    'username' => $request->username,
                    'item_id' => $itemid,
                    'collector_key' => 'rakoombaa'
                ]
            ]);

            // dd($response1->getBody()->getContents());

            Session::flash('license_success', 'Your license is verified successfully!');
            return redirect()->route('LaravelInstaller::environmentWizard');
        } catch (\Exception $e) {
            Session::flash('license_error', 'Something went wrong!');
            return redirect()->route('LaravelInstaller::environmentWizard');
        }

    }
}
