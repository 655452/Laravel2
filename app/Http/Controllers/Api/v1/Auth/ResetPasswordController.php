<?php
namespace App\Http\Controllers\Api\v1\Auth;

use App\Models\ResetCodePassword;
use App\Models\User; 
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
class ResetPasswordController extends Controller
{
    /**
     * Change the password (Setp 3)
     *
     * @param  mixed $request
     * @return void
     */
    public function __invoke(ResetPasswordRequest $request)
    {
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset->isExpire()) {
            return $this->jsonResponse(null, trans('passwords.code_is_expire'), 422);
        }

        $user = User::firstWhere('email', $passwordReset->email);
        Log::info('Password reset successfully for user: ' . $user->password);
        Log::info('Password reset successfully for user: ' . bcrypt($request->password));

          // Log the update process
        Log::info('Updating password for user: ' . $user->email);

        // Update the user's password
// Update the user's password correctly
        $user->update(['password' => Hash::make($request->password)]);

        // Option 2: Without a primary key
         ResetCodePassword::where('code', $request->code)
                         ->where('email', $passwordReset->email)
                         ->delete();
        // Delete the reset code entry
        Log::info('Password reset successfully for user: ' . $user->email);
        return $this->jsonResponse(null, trans('site.password_has_been_successfully_reset'), 200);
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