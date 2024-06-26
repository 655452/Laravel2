<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\User;

use App\Enums\UserRole;
use App\Models\Restaurant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Enums\NotificationType;
use App\Models\PushNotification;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\BackendController;
use App\Http\Requests\PushNotificationRequest;
use App\Http\Services\PushNotificationService;

class PushNotificationController extends BackendController
{
    protected $pushNotification;
    public function __construct(PushNotificationService $pushNotificationService)
    {

        parent::__construct();
        $this->data['siteTitle'] = 'Push Notifications';
        $this->pushNotification = $pushNotificationService;

        $this->middleware(['permission:push-notification'])->only('index');
        $this->middleware(['permission:push-notification_create'])->only('create', 'store');
        $this->middleware(['permission:push-notification_delete'])->only('destroy');
    }

    public function index()
    {
        return view('admin.push-notification.index');
    }

    public function create()
    {
        $role                       = Role::find(UserRole::CUSTOMER);
        $this->data['customers']    = User::role($role->name)->latest()->get();
        $this->data['restaturants'] = Restaurant::where(['status'=>Status::ACTIVE,'current_status'=>Status::ACTIVE])->orderBy('id', 'desc')->get();

        return view('admin.push-notification.create', $this->data);
    }

    public function store(PushNotificationRequest $request)
    {
        $topicName = '';

        $notification = new PushNotification;
        $notification->title = $request->title;
        $notification->description = strip_tags($request->description);
        $notification->customer_id = $request->customer_id ? $request->customer_id : null;
        $notification->restaurant_id = $request->restaurant_id ? $request->restaurant_id : null;

        if ($request->customer_id == 0) {
            $notification->type = NotificationType::ALL;
        } else {
            $user = User::findOrFail($request->customer_id);
            $topicName = $user->email;
            $notification->type = NotificationType::SINGLE;
        }

        $notification->save();

        //Store Image Media Libraty Spati
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $notification->addMediaFromRequest('image')->toMediaCollection('pushNotifications');
        }

        try {
            $this->pushNotification->sendPushNotification($notification, $topicName);
        } catch (\Exception $exception) {
        }
        return redirect(route('admin.push-notification.index'))->withSuccess('The Data Inserted Successfully');
    }

    public function destroy($id)
    {
        PushNotification::findOrFail($id)->delete();
        return redirect(route('admin.push-notification.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getNotification()
    {

        if (request()->ajax()) {
            $restaurant_id = auth()->user()->restaurant->id ?? 0;

            if ($restaurant_id) {
                $notifications = PushNotification::where(['restaurant_id' => $restaurant_id])->orderBy('id', 'desc')->get();
            } else {
                $notifications = PushNotification::orderBy('id', 'desc')->get();
            }

            $i = 0;
            return Datatables::of($notifications)
                ->addColumn('action', function ($notification) {
                    $retAction = '';

                    if (auth()->user()->can('push-notification_delete')) {
                    $retAction .= '<form  id="detete-'.$notification->id.'"  class="float-left pl-2" action="' . route('admin.push-notification.destroy', $notification) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                    '<button type="button" data-id="'.$notification->id.'"
                    class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                    <i class="fa fa-trash"></i>
                    </button> </form>';
                    }
                    return $retAction;
                })
                ->editColumn('title', function ($notification) {
                    return Str::limit(strip_tags($notification->title), 50);
                })
                ->editColumn('description', function ($notification) {
                    return Str::limit(strip_tags($notification->description), 50);
                })
                ->editColumn('type', function ($notification) {
                    return ($notification->type == 5 ? trans('notification_type.' . NotificationType::SINGLE) : trans('notification_type.' . NotificationType::ALL));
                })
                ->editColumn('id', function ($notification) use (&$i) {
                    return ++$i;
                })

                ->rawColumns(['action', 'description'])
                ->make(true);
        }
    }
}
