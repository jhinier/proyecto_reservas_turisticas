<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VerificarEmprendimientoActivo
 *
 * @package App\Http\Middleware
 */
class VerificarEmprendimientoActivo
{
    /**
     * @param \Illuminate\Http\Request $request La petición HTTP actual.
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next El siguiente middleware o destino de la petición.
     * @return \Symfony\Component\HttpFoundation\Response Redirección o la respuesta de la petición original.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // 1. Verifica  que el usuario tenga un emprendimiento vinculado
        if (!$user || !$user->emprendimiento) {
            return redirect('/')->with('notify', [
                'type' => 'danger',
                'title' => 'Acceso Denegado',
                'message' => 'No tienes un emprendimiento asignado.'
            ]);
        }

        // 2. Verificamos si el estado es 'inactivo' (0 o false)
        if (!$user->emprendimiento->estado) {
            
            // Opcional: Cerrar sesión para que no ande por ahí
            Auth::logout(); 

            return redirect()->route('login')->withErrors([
                'email' => 'Tu sesión fue cerrada porque el emprendimiento pasó a inactivo. Contacta soporte.'
            ]);
        }

        // Si todo está bien (estado 1), lo deja pasar a la ruta que pidió
        return $next($request);
    }
}