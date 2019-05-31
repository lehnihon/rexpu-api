<?php
namespace App\Http\Controllers;
use Validator;
use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController 
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60*24, // Expiration time
            'name' => $user->name,
            'role' => $user->role
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, "@fsF3%678GLie534*kfsI");
    } 
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate(User $user) {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
        // Check Active
        $user = User::where('accepted', '1')->first();
        if (!$user) {
            return response()->json([
                'error' => 'Usuário desaprovado.'
            ], 400);
        }
        // Check Active
        $user = User::where('active', '1')->first();
        if (!$user) {
            return response()->json([
                'error' => 'Usuário inativo'
            ], 400);
        }
        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the 
            // below respose for now.
            return response()->json([
                'error' => 'Email não existe.'
            ], 400);
        }
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }

    public function refresh() {
        $token = $this->request->bearerToken();
        $credentials = JWT::decode($token, "@fsF3%678GLie534*kfsI", ['HS256']);
        $user = User::find($credentials->sub)->where('active','1')->first();
        return response()->json([
            'token' => $this->jwt($user)
        ], 200);
    }
}