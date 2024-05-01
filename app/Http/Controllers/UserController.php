<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\SignInRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    /**
     * @return JsonResponse  
     */
    public function index()
    {
        try {
            $users = User::all();

            return response()->json([
                'error' => false,
                'message' => 'Usuários recuperados com sucesso.',
                'data' => $users
            ]);
        } catch (Exception $ex) {
            return [
                'error' => true,
                'message' => $ex->getMessage()
            ];
        }
    }
    
    /**
     * @param String $id
     * @return JsonResponse  
     */
    public function show($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            return response()->json([
                'error' => false,
                'message' => 'Usuário recuperado com sucesso.',
                'posts' => $user->post,
                'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->only([
                'name', 
                'email', 
                'password', 
                'is_admin'
            ]);

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            return response()->json([
                'error' => false,
                'message' => 'Usuário criado com sucesso.',
                'token' => $user
                    ->createToken('Register_token')
                    ->plainTextToken,
                'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param SignInRequest $request
     * @return JsonResponse
     */
    public function signIn(SignInRequest $request): JsonResponse
    {
        try {
            $data = $request->only(['email', 'password']);

            if (Auth::attempt($data)) {
                $user = Auth::user();
            }

            return response()->json([
                'error' => false,
                'message' => 'Usuário logado com sucesso.',
                'token' => $user
                    ->createToken('Login_token')
                    ->plainTextToken,
                'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function validateToken(Request $request)
    {
        info($request);
        // try {
        //     $token = DB::table('personal_access_tokens')
        //         ->where('name', 'Login_token')
        //         ->orderBy('id', 'desc')
        //         ->limit(1)
        //         ->get();

        //     // info($token->all());

        //     $tokenable_id = $token->all();

        //     info($tokenable_id['tokenable_id']);

    
        //     $user = User::findOrFail($token['tokenable_id']);
        //     info($user);

        //     return response()->json([
        //         'error' => false,
        //         'message' => 'Token validado com sucesso.',
        //         'data' => $user
        //     ]);
        // } catch (Exception $ex) {
        //     return response()->json([
        //         'error' => true,
        //         'message' => $ex->getMessage()
        //     ]);
        // }
    }
    
    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function update(CreateUserRequest $request): JsonResponse
    {
        try {
            $data = $request->only([
                'name', 
                'email', 
                'password', 
                'is_admin'
            ]);
            
            $data['password'] = Hash::make($data['password']);

            $user = User::findOrFail($request->id);

            $user->update($data);
            $user->save();

            return response()->json([
                'error' => false,
                'message' => 'Usuário atualizado com sucesso.',
                'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse  
     */
    public function updatePassword(Request $request): JsonResponse
    {
        try {   
            $newPassword = Hash::make($request->newPassword);

            $user = DB::table('users')
                ->where('id', $request->id)
                ->update(['password' => $newPassword]);

            return response()->json([
                'error' => false,
                'message' => 'Senha atualizada com sucesso.',
                'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }

    /**
     * @param String $id
     * @return JsonResponse  
     */
    public function remove($id): JsonResponse
    {
        try {
            $user = User::where(["id" => $id])->delete();

            return response()->json([
                'error' => false,
                'message' => 'Usuário deletado com sucesso.',
                'data' => $user
            ]);
        } catch (Exception $ex) {
            return response()->json([
                'error' => true,
                'message' => $ex->getMessage()
            ]);
        }
    }
}
