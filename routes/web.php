<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para la configuración inicial (solo disponible en entorno local)
Route::get('/setup', function () {
    // Verifica si la aplicación está en el entorno local
    if (config('app.env') !== 'local') {

        // Responde con error 403 si no es local
        abort(403, 'Unauthorized action.');
    }

    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password',
    ];
    // Intenta autenticar al usuario con las credenciales
    if (!Auth::attempt($credentials)) {
        // Si la autenticación falla, crea un nuevo usuario administrador
        $user = new \App\Models\User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();
    }

    // Si la autenticación tiene éxito
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        // Genera tres tokens para el usuario con diferentes permisos
        $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
        $updateToken = $user->createToken('update-token', ['create', 'update']);
        $basicToken = $user->createToken('basic-token');
        return [
            'admin' => $adminToken->plainTextToken,
            'update' => $updateToken->plainTextToken,
            'basic' => $basicToken->plainTextToken,
        ];
    }
});
