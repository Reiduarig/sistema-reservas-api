<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\DataTransferObjects\RegisterUserData;
use App\DataTransferObjects\LoginUserData;
use App\Actions\Auth\RegisterUserAction;
use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Registrar un nuevo usuario.
     */
    public function register(RegisterRequest $request, RegisterUserAction $action): JsonResponse
    {
       
       $data = new RegisterUserData(
            name: $request->string('name')->toString(),
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );

        $user = $action->execute($data);

        // Crear token de autenticación
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token,
        ], 201);
    }

    /**
     * Inicio de sesión de usuario.
     */
    public function login(LoginRequest $request, LoginUserAction $action): JsonResponse
    {
        $data = new LoginUserData(
            email: $request->string('email')->toString(),
            password: $request->string('password')->toString(),
        );

        $token = $action->execute($data);

        return response()->json([
            'token' => $token,
        ]);
    }

    /**
     * Cerrar sesión del usuario autenticado.
     */
    public function logout(Request $request, LogoutUserAction $action): Response
    {
       
        $action->execute($request->user());

        return response()->noContent();
    }
}
