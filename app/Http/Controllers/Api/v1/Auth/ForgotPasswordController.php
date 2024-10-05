<?php
namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\ResetCodePassword;
use App\Mail\SendCodeResetPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    /**
     * Send random code to email of user to reset password (Setp 1)
     *
     * @param  mixed $request
     * @return void
     */
    public function __invoke(ForgotPasswordRequest $request)
    {
        ResetCodePassword::where('email', $request->email)->delete();

Log::info('Email sent successfully to ' . $request->data);
        $codeData = ResetCodePassword::create($request->data());

        Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));

        return $this->jsonResponse('Reset code sent successfully.', $codeData, 200);
    }


          /**
     * Helper method to return a JSON response.
     *
     * @param  string|null  $message
     * @param  mixed  $data
     * @param  int  $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($message, $data = null, $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}