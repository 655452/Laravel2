<?php
namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\ResetCodePassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CodeCheckRequest;
use Illuminate\Support\Facades\Log;
class CodeCheckController extends Controller
{
    /**
     * Check if the code is exist and vaild one (Setp 2)
     *
     * @param  mixed $request
     * @return void
     */
    public function __invoke(CodeCheckRequest $request)
    {
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset->isExpire()) {
            return $this->jsonResponse(null, trans('passwords.code_is_expire'), 422);
        }

          Log::info('Code is valid: ' . $request->code);
        return $this->jsonResponse(trans('passwords.code_is_valid'), ['code' => $passwordReset->code], 200);
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