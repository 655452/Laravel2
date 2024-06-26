<?php


namespace App\Http\Services;


use App\Models\Report;
use App\Enums\OrderStatus;
use App\Enums\ReportStatus;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;

class ComplaintService
{
    public $adminBalanceId = 1;
    public function changeStatus($id,$status)
    {
        $report         = Report::findOrFail($id);
        $report->status = $status;
        
        if ($report->order->payment_status == PaymentStatus::PAID ) {
            $refund = app(TransactionService::class)->refund($this->adminBalanceId, $report->order->user->balance_id, $report->order->total, $report->order->id);
            if ($refund->status) {
                $report->order->payment_status = PaymentStatus::UNPAID;
                $report->order->paid_amount    = 0;
                $report->order->status = OrderStatus::CANCEL;
            }
        }
        $report->save();
        return $report;
    }

    public function storeReport($request)
    {
        $report             = new Report();
        $report->order_id = $request->get('order_id');
        $report->description = $request->get('description');
        $report->status = ReportStatus::PENDING;
        $report->save();

        if (request()->file('image')) {
            $report->addMedia(request()->file('image'))->toMediaCollection('report');
        }

        return $report;
    }


}
