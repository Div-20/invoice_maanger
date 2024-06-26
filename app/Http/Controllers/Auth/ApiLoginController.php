<?php

namespace App\Http\Controllers\Auth;

use App\Classes\WriteToFile;
use App\Helpers\SiteConstants;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiLoginController extends Controller
{

    /**
     * Save user model
     *  */
    private $aUser;

    private $logPath;

    public function __construct()
    {
        $this->logPath = base_path('storage/logs/login_log.txt');
    }

    private function createToken()
    {
        return time() . bin2hex(openssl_random_pseudo_bytes(30));
    }

    /**
     * login for user
     * @param  \Illuminate\Http\Request  $request
     * @param string $u_id
     * @param string $reg_token
     * @param string $mobile
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ], [
                'email.required' => 'Mobile Or Email Is required',
                'password.required' => 'Password is required',
            ]);
            if (!empty($validator->errors()->messages())) {
                foreach ($validator->errors()->messages() as $key => $errorMessage) {
                    return response()->json(['status' => false, 'message' => $errorMessage[0]], Response::HTTP_BAD_REQUEST);
                }
            }
            $credentials = $request->only('password', 'email');

            $this->aUser = User::checkUserStatus($credentials['email']);
            if (!$this->aUser) {
                return response()->json(['status' => false, 'message' => 'Invalid login details'], Response::HTTP_BAD_REQUEST);
            }
            if (!Hash::check($credentials['password'], $this->aUser->password)) {
                return response()->json(['status' => false, 'message' => 'Invalid Password.'], Response::HTTP_BAD_REQUEST);
            }
            if ($this->aUser) {
                $token = $this->aUser->createToken(SiteConstants::API_TOKEN_CONST)->plainTextToken;
                return response()->json([
                    'status' => true,
                    'token' => $token,
                    'user' => new UserResource($this->aUser),
                    'message' => 'Login successfully.',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Incorrect Login details, Try again.',
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Throwable $th) {
            WriteToFile::logMessage($this->logPath, 'Error to login ' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong, Try again.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /** Signup
     * @param string $email
     * @param string $password
     * @return array
     */
    public function signup(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'referral' => 'string',
                'name' => 'required|string',
                'email' => 'required|unique:users|email',
                'mobile' => 'required|unique:users|digits:10',
                'password' => 'required|string|min:6',
                'password_confirm' => 'required|same:password',
            ]);

            if (!empty($validator->errors()->messages())) {
                foreach ($validator->errors()->messages() as $key => $errorMessage) {
                    return response()->json(['status' => false, 'message' => $errorMessage[0]], Response::HTTP_BAD_REQUEST);
                }
            }

            $aData = $request->only('email', 'password', 'mobile', 'name', 'referral');
            if (isset($aData['referral']) && $aData['referral']) {
                if (!User::checkUserStatus($aData['referral'], 'unique_id')) {
                    return response()->json(['status' => false, 'message' => 'Invalid referral code.'], Response::HTTP_BAD_REQUEST);
                }
            }
            $aData['password'] = Hash::make($aData['password']);

            $this->aUser = User::create($aData);
            if ($this->aUser) {
                $this->aUser->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Registered successfully Login Now.',
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Error to save login details.',
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Throwable $th) {
            WriteToFile::logMessage($this->logPath, 'Error to signup ' . $th->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json([
            'status' => true,
            'message' => 'logout Successfully.',
        ], Response::HTTP_OK);
    }
}
