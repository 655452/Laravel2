<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Models\QrCode as QrModel;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Sopamo\LaravelFilepond\Filepond;

class QrCodeController extends BackendController
{
    /**
     * restaurantController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Qr Builder';

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param Filepond $filepond
     */
    public function index(Filepond $filepond)
    {
        
   
        if (auth()->user()->myrole == 3) {
            if (auth()->user()->restaurant) {
                $restaurant = auth()->user()->restaurant;
                $image = QrCode::size(480)
                    ->format('png')
                    ->margin(1)
                    ->encoding('UTF-8');

                if (isset($restaurant->qrCode)) {
                    if (isset($restaurant->qrCode->color)) {
                        $colors = explode(",", $restaurant->qrCode->color);
                    } else {
                        $colors = [0, 0, 0];
                    }

                    if (isset($restaurant->qrCode->background_color)) {
                        $bgColors = explode(",", $restaurant->qrCode->background_color);
                    } else {
                        $bgColors = [255, 255, 255];
                    }

                    $image = $image
                        ->style(isset($restaurant->qrCode->style) ? $restaurant->qrCode->style : 'square')
                        ->eye(isset($restaurant->qrCode->eye_style) ? $restaurant->qrCode->eye_style : 'square')
                        ->color(intval($colors[0]), intval($colors[1]), intval($colors[2]))
                        ->backgroundColor(intval($bgColors[0]), intval($bgColors[1]), intval($bgColors[2]));

                    if ($restaurant->qrCode->mode == 'logo' && !blank($restaurant->qrCode->qrcode_logo)) {
                        $path  = $filepond->getPathFromServerId($restaurant->qrCode->qrcode_logo);
                        $image = $image->merge($path, .2, true);
                    }

                } else {
                    $qrCode                = new QrModel();
                    $qrCode->restaurant_id = $restaurant->id;
                    $qrCode->save();

                    return redirect(route('admin.qr-code.index'));
                }

                $image = $image->generate(route('restaurant.show', $restaurant->slug));
                
                return view('admin.qr-code.index')->with(['restaurant' => auth()->user()->restaurant, 'qrCode' => base64_encode($image)]);
            }
            else{
                return redirect(route('admin.restaurants.index'));
            }
        }
       
        return view('errors.403');
    }

    /**
     * @param Request $request
     * @param Filepond $filepond
     * @return mixed
     */
    public function store(Request $request)
    {
        if (auth()->user()->myrole == 3) {
            if (auth()->user()->restaurant) {
                $restaurant = auth()->user()->restaurant;

                $restaurant->qrCode->style            = $request->get('style');
                $restaurant->qrCode->eye_style        = $request->get('eye_style');
                $restaurant->qrCode->color            = $request->get('color');
                $restaurant->qrCode->background_color = $request->get('background_color');
                $restaurant->qrCode->mode             = $request->get('mode');

                if ($request->get('mode') == 'logo') {
                    if ($request->has('file') && $request->get('file') != null) {
                        $restaurant->qrCode->qrcode_logo = $request->input('file');
                    }
                } else {
                    $restaurant->qrCode->qrcode_logo = null;
                }

                $restaurant->qrCode->save();
            }
        }

        return redirect(route('admin.qr-code.index'));
    }

    public function preview(Request $request, Filepond $filepond)
    {

        if (auth()->user()->myrole == 3) {
            if (auth()->user()->restaurant) {
                $restaurant = auth()->user()->restaurant;

                if ($request->has('color')) {
                    $colors = explode(",", $request->get('color'));
                } else {
                    $colors = [255, 255, 255];
                }

                if ($request->has('background_color')) {
                    $bgColors = explode(",", $request->get('background_color'));
                } else {
                    $bgColors = [0, 0, 0];
                }

                $image = QrCode::size(480)
                    ->format('png')
                    ->margin(1)
                    ->style($request->get('style'))
                    ->eye($request->get('eye_style'))
                    ->color(intval($colors[0]), intval($colors[1]), intval($colors[2]))
                    ->backgroundColor(intval($bgColors[0]), intval($bgColors[1]), intval($bgColors[2]))
                    ->encoding('UTF-8');

                if ($request->get('mode') == 'logo') {
                    if ($request->has('file')) {
                        $picture = $request->input('file');
                        $path    = $filepond->getPathFromServerId($picture);
                        $image   = $image->merge($path, .2, true);
                    } elseif (!blank($restaurant->qrCode->qrcode_logo)) {
                        $path  = $filepond->getPathFromServerId($restaurant->qrCode->qrcode_logo);
                        $image = $image->merge($path, .2, true);
                    }
                }

                $image = $image->generate(route('restaurant.show', auth()->user()->restaurant->slug));

                return response(base64_encode($image))->header('Content-type', 'image/png');
            }
        }

        return false;
    }

}
