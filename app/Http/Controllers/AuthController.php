<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerificationCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

class AuthController extends Controller
{
public function register(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.,;:])[A-Za-z\d@$!%*?&.,;:]{8,}$/'
        ],
    ], [
        'password.regex' => 'La contraseña debe tener al menos una mayúscula, una minúscula, un número y un carácter especial.',
    ]);

    $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'rol' => 'Usuario'
    ]);

    $code = rand(100000, 999999);

    EmailVerificationCode::create([
        'user_id' => $user->id,
        'code' => $code,
        'expires_at' => now()->addMinutes(3),
    ]);

    // Enviar correo HTML con estilo personalizado
    $htmlContent = "
    <div style='font-family: Arial, sans-serif; text-align: center; background-color: #ffffff; padding: 20px;'>
        <div style='max-width: 500px; margin: auto; background: #ffffff; padding: 20px; border-radius: 10px; border: 2px solid #0047AB;'>
            <h2 style='color: #0047AB;'>🔐 Código de Verificación</h2>
            <p style='font-size: 16px; color: #0047AB;'>¡Hola! Gracias por registrarte en <strong>Modelo Unad</strong>. Para continuar, usa el siguiente código de verificación:</p>
            <div style='font-size: 24px; font-weight: bold; color: #ffffff; background: #0047AB; padding: 10px; display: inline-block; border-radius: 5px; margin: 10px 0;'>
                $code
            </div>
            <p style='font-size: 14px; color: #0047AB;'>Este código expirará en 3 minutos.</p>
            <hr style='border: none; border-top: 1px solid #0047AB; margin: 20px 0;'>
            <p style='font-size: 12px; color: #0047AB;'>Si no solicitaste este código, puedes ignorar este mensaje.</p>
        </div>
    </div>";

    Mail::send([], [], function ($message) use ($request, $htmlContent) {
        $message->to($request->email)
                ->subject('🔐 Código de Verificación - Modelo Unad')
                ->setBody($htmlContent, 'text/html');
    });

    return response()->json(['message' => 'Usuario creado. Código enviado.']);
}

public function verify(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required|digits:6',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user) return response()->json(['error' => 'Usuario no encontrado'], 404);

    $verification = EmailVerificationCode::where('user_id', $user->id)
        ->where('code', $request->code)
        ->where('expires_at', '>=', now())
        ->latest()
        ->first();

    if (!$verification) {
        return response()->json(['error' => 'Código inválido o expirado'], 400);
    }

    $user->email_verified_at = now();
    $user->save();

    return response()->json(['message' => 'Correo verificado.']);
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Credenciales inválidas'], 401);
    }

    if (!$user->email_verified_at) {
        return response()->json(['error' => 'Correo no verificado'], 403);
    }

    // Crear token con Sanctum
    $token = $user->createToken('auth_token')->plainTextToken;

    // Retornar también rol, id y email para que Unity actúe según el rol
    return response()->json([
        'success' => true,
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'rol' => $user->rol
        ]
    ]);
}
}
