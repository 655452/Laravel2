<?php

namespace App\Http\Controllers;

use App\Helpers\Curl;
use App\Helpers\Ip;
use App\Http\Requests\PurchaseCodeRequest;
use App\Libraries\RequestHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PurchaseCodeController extends Controller
{

    public function index()
    {
        return view('vendor.installer.purchase-code');
    }


    public function action(PurchaseCodeRequest $request)
    {
        // Check purchase code
        $purchase_code_data = $this->purchaseCodeChecker($request);

        if ($purchase_code_data->status == false) {
            return redirect()->back()->withInput($request->all())->withErrors($purchase_code_data->message);
        } else {
            Session::put('license_code', $request->get('purchase_code'));

        }

        return redirect()->route('LaravelInstaller::environment');
    }

    /**
     * @param Request $request
     * @return false|mixed|string
     */
    private function purchaseCodeChecker(Request $request)
    {

        try {
            $payload = [
                'license_code' => $request->get('purchase_code'),
                'product_id'   => config('installer.itemId'),
                'domain'       => domain(url('')),
                'purpose'      => 'install',
                'version'      => config('installer.item_version')
            ];


            $apiUrl = config('installer.licenseCodeCheckerUrl');
            $response = Http::post($apiUrl.'/api/check-installer-license',$payload);
            return RequestHandler::get_data($response);
        } catch( \Exception $exception ) {
            return (object)['status' => false, 'message' => $exception->getMessage()];
        }
    }

    public function licenseCodeActivate(Request $request)
    {

        $message = Session::get('license_code_error');
        return view('activate-license',compact('message'));
    }
}
