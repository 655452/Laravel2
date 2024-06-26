<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Setting;

class OtpSettingController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->data['siteTitle'] = 'Otp Setting';
        $this->middleware(['permission:setting'])->only('index', 'update');
    }

    public function all()
    {
        $types = Setting::all();
        return view('admin/setting/settings', compact('types'));
    }

    public function index()
    {
        $this->data['siteTitle'] = 'Setting';
        return view('admin/setting/index', $this->data);
    }

    public function update(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->validateArray(), [], $niceNames);
        Setting::set($settingArray);
        Setting::save();

        return redirect(route('admin.setting.all'))->withSuccess('Setting Updated Successfully');
    }

    private function validateArray()
    {
        return [
            'otp_type_checking' => 'required|string',
            'otp_digit_limit'   => 'required|numeric',
            'otp_expire_time'   => 'required|numeric|min:1|max:30',

        ];
    }
}
