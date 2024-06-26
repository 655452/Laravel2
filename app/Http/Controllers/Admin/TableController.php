<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\TableRequest;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class TableController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'tables';

        $this->middleware(['permission:tables'])->only('index');
        $this->middleware(['permission:tables_create'])->only('create', 'store');
        $this->middleware(['permission:tables_edit'])->only('edit', 'update');
        $this->middleware(['permission:tables_delete'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->getTable($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        return view('admin.table.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TableRequest $request)
    {
        $table           = new Table;
        $table->name     = $request->name;
        $table->capacity = $request->capacity;
        $table->status   = $request->status;
        $table->restaurant_id     = $request->restaurant_id;
        $table->save();

        return redirect(route('admin.tables.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['table'] = Table::findOrFail($id);
        $this->data['restaurants'] = Restaurant::where(['status' => Status::ACTIVE])->get();
        return view('admin.table.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TableRequest $request, $id)
    {
        $table           = Table::findOrFail($id);
        $table->name     = $request->name;
        $table->capacity = $request->capacity;
        $table->restaurant_id     = $request->restaurant_id;
        $table->status   = $request->status;
        $table->save();
        return redirect(route('admin.tables.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Table::findOrFail($id)->delete();
        return redirect(route('admin.tables.index'))->withSuccess('The Data Deleted Successfully');
    }

    private function getTable($request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            $queryArray['status'] = Status::ACTIVE;
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }
            $tables = [];
            if (auth()->user()->myrole == 3 && auth()->user()->restaurant){
                $queryArray['restaurant_id'] =auth()->user()->restaurant->id;
                $tables = Table::where($queryArray)->descending()->select();
            }elseif(auth()->user()->myrole != 3){
                $tables = Table::where($queryArray)->descending()->select();
            }

            $i = 0;
            return Datatables::of($tables)
                ->addColumn('action', function ($table) {
                    $retAction = '';

                    if (auth()->user()->can('tables_edit')) {
                        $retAction .= '<a href="' . route('admin.tables.edit', $table) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('tables_delete')) {
                        $retAction .= '<form  id="detete-'.$table->id.'" class="float-left pl-2" action="' . route('admin.tables.destroy', $table) . '" method="POST">' . method_field('DELETE') . csrf_field() .
                        '<button type="button" data-id="'.$table->id.'"
                        class="btn btn-sm btn-icon btn-danger delete confirm-delete"  data-toggle="modal" data-target="#exampleModal" title="Delete">
                        <i class="fa fa-trash"></i>
                        </button> </form>';
                    }
                    return $retAction;
                })
                ->editColumn('restaurant_id', function ($table) {
                    return Str::limit(optional($table->restaurant)->name ?? null, 30);
                })
                ->editColumn('status', function ($table) {
                    return ($table->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
                })
                ->editColumn('id', function ($table) use (&$i) {
                    return ++$i;
                })
                ->make(true);
        }
        return view('admin.table.index', $this->data);
    }
}
