<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AdministratorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class AdministratorController extends BackendController
{
    public function __construct()
    {
        $this->data['siteTitle'] = 'Administrator';

        $this->middleware(['permission:administrators'])->only('index');
        $this->middleware(['permission:administrators_create'])->only('create', 'store');
        $this->middleware(['permission:administrators_edit'])->only('edit', 'update');
        $this->middleware(['permission:administrators_delete'])->only('destroy');
        $this->middleware(['permission:administrators_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.administrators.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.administrators.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdministratorRequest $request)
    {
        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? generateUsername($request->email);
        $user->password   = Hash::make(request('password'));
        $user->phone      = $request->phone;
        $user->address    = $request->address;
        $user->status     = $request->status;
        $user->save();

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(1);
        $user->assignRole($role->name);

        return redirect(route('admin.administrators.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role               = Role::find(1);
        $this->data['user'] = User::role($role->name)->findOrFail($id);
        return view('admin.administrators.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find(1);
        $user = User::role($role->name)->findOrFail($id);

        if ($this->modifyPermission($user)) {
            $this->data['user'] = $user;
            return view('admin.administrators.edit', $this->data);
        }
        return redirect(route('admin.administrators.index'))->withError('You don\'t have permission to edit this data');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdministratorRequest $request, $id)
    {
        $role = Role::find(1);
        $user = User::role($role->name)->findOrFail($id);

        if ($this->modifyPermission($user)) {

            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->username   = $request->username ?? generateUsername($request->email);

            if ($request->password) {
                $user->password = Hash::make(request('password'));
            }

            $user->phone   = $request->phone;
            $user->address = $request->address;
            if ($user->id != 1) {
                $user->status = $request->status;
            } else {
                $user->status = UserStatus::ACTIVE;
            }
            $user->save();

            if (request()->file('image')) {
                $user->media()->delete();
                $user->addMedia(request()->file('image'))->toMediaCollection('user');
            }

            return redirect(route('admin.administrators.index'))->withSuccess('The Data Updated Successfully');
        }
        return redirect(route('admin.administrators.index'))->withError('You don\'t have permission to update this data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find(1);
        $user = User::role($role->name)->findOrFail($id);
        if ($this->deletePermission($user)) {
            $user->delete();
            return redirect(route('admin.administrators.index'))->withSuccess('The Data Deleted Successfully');
        }
        return redirect(route('admin.administrators.index'))->withError('You don\'t have permission to delete this data');
    }

    public function getAdministrators()
    {
        $role  = Role::find(1);
        $users = User::role($role->name)->latest()->select();

        $i = 0;
        return Datatables::of($users)
            ->addColumn('action', function ($user) {
                $retAction = '';
                if (auth()->user()->can('administrators_show')) {
                    $retAction .= '<a href="' . route('admin.administrators.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('administrators_edit') && $this->modifyPermission($user)) {
                    $retAction .= '<a href="' . route('admin.administrators.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                }

                if (auth()->user()->can('administrators_delete') && $this->deletePermission($user)) {
                    $retAction .= '<form  id="detete-'.$user->id.'"  class="float-left pl-2" action="' .
                     route('admin.administrators.destroy', $user) . '" method="POST">' . method_field('DELETE') .
                      csrf_field() . '<button type="button" data-id="'.$user->id.'"
                      class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                      <i class="fa fa-trash"></i>
                      </button>
                      </form>';
                }
                return $retAction;
            })
            ->addColumn('image', function ($user) {
                return '<figure class="avatar mr-2"><img src="' . $user->image . '" alt=""></figure>';
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('id', function ($user) use (&$i) {
                return ++$i;
            })
            ->escapeColumns([])
            ->make(true);
    }

    private function modifyPermission($user)
    {
        return ($user->id != 1) || (auth()->id() == 1);
    }

    private function deletePermission($user)
    {
        return ($user->id != 1) && (auth()->id() == 1);
    }
}
