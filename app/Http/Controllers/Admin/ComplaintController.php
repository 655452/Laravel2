<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Bank;
use App\Models\Report;
use App\Models\Restaurant;
use App\Enums\ReportStatus;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Requests\BankRequest;
use App\Http\Services\ComplaintService;
use App\Notifications\OrderReportResponse;
use App\Http\Controllers\BackendController;

class ComplaintController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Complaints';
        $this->middleware(['permission:complaints']);
    }

    public function index()
    {
        return view('admin.complaint.index', $this->data);
    }


    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('admin.complaint.view', compact('report'));
    }

    public function destroy($id)
    {
        Report::findOrFail($id)->delete();
        return redirect(route('admin.complaints.index'))->withSuccess('The data deleted successfully.');
    }

    public function getComplaint(Request $request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
                $reports = Report::where($queryArray)->latest()->get();
            } else {
                $reports = Report::where($queryArray)->latest()->get();
            }

            $i = 0;
            return Datatables::of($reports)
                ->addColumn('action', function ($report) {
                    $retAction = '';
                    if (auth()->user()->can('complaints')) {
                        $retAction .= '<a href="' . route('admin.complaints.show', $report->id) . '" class="btn btn-sm btn-icon ml-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }
                    if (auth()->user()->can('complaints')) {
                        $retAction .= '<form  id="detete-'.$report->id.'" class="float-left pl-2" action="' .
                        route('admin.complaints.destroy', $report) . '" method="POST">' . method_field('DELETE') .
                         csrf_field() . '<button type="button" data-id="'.$report->id.'"
                         class="btn btn-sm btn-icon btn-danger delete confirm-delete"
                           data-toggle="modal" data-target="#exampleModal" title="Delete">
                            <i class="fa fa-trash"></i> </button> </form>';
                    }
                    return $retAction;
                })
                ->editColumn('id', function ($bank) use (&$i) {
                    return ++$i;
                })

                ->editColumn('order_code', function ($report) {
                    return $report->order->order_code;
                })

                ->editColumn('user_name', function ($report) {
                    return $report->user->name;
                })

                ->editColumn('status', function ($report) {
                    $drop = '';
                    $dropActive = false;
                    $activeStatus = 'Change Status';
                    foreach (trans("report_statuses") as $key => $status) {
                        if ($report->status == $key) {
                            $activeStatus = $status;
                        }

                        if ($report->status != ReportStatus::PENDING) {
                            $dropActive = false;
                        } else {
                            $drop .= '<a class="dropdown-item gray-color mb-1" href="' . route('admin.complaint.change-status', [$report->id, $key]) . '" >' . $status . '</a>';
                            $dropActive = true;
                        }
                    }
                    if ($dropActive) {
                        return '<div class="dropdown">
                    <button class="btn report-btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                            . $activeStatus
                            . '</button>
                  <div class="dropdown-menu report-dropdown" aria-labelledby="dropdownMenuButton">' . $drop . '</div></div>';
                    } else {
                        return '<span class="badge ' . ($report->status == ReportStatus::REFUND ? 'badge-success' : 'badge-danger') . '">' . $activeStatus . '</span>';
                    }
                })

                ->escapeColumns([])
                ->make(true);
        }
    }

    public function changeStatus($id, $status)
    {
        $report = app(ComplaintService::class)->changeStatus($id, $status);
        if ($report) {
            try {
                $report->order->user->notify(new OrderReportResponse($report->order,$report->status));
                return redirect()->route('admin.complaints.index')->withSuccess('The Status Change successfully!');
            } catch (\Exception $e) {
            }
        }else{
            return view('errors.404');
        }
    }
}
