<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TareasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $usuario = Auth::user();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }
            // Obtener las tareas del usuario autenticado
            $tareas = Tarea::where('id_usuario', $usuario->id_usuario)
                ->with(['usuario','notificacion'])
                ->orderBy('fecha_creacion','desc')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Tareas encontradas correctamente',
                'data' => $tareas
            ],200);

        }catch(\Exception $e){
            return response()->json(['error' => 'Error al obtener las tareas: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:100',
            'fecha_limite' => 'required|date',
            'hora_limite' => 'required',
        ]);

        try {
            $usuario = Auth::user();

            $tarea = Tarea::create([
                'id_usuario' => $usuario->id_usuario,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'categoria' => $request->categoria,
                'fecha_limite' => $request->fecha_limite,
                'hora_limite' => $request->hora_limite,
                'completada' => false,
                'fecha_creacion' => now(),
            ]);

            return response()->json(['success' => true, 'data' => $tarea], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear tarea: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al crear la tarea.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tarea = Tarea::find($id);
        if (!$tarea) {
            return response()->json(['error' => 'Tarea no encontrada'], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tarea encontrada correctamente',
            'data' => $tarea
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:100',
            'fecha_limite' => 'required|date',
            'hora_limite' => 'required',
            'completada' => 'required|boolean'
        ]);

        $tarea = Tarea::find($id);
        if (!$tarea) {
            return response()->json(['success' => false, 'message' => 'Tarea no encontrada'], 404);
        }

        $tarea->update($request->all());

        return response()->json(['success' => true, 'data' => $tarea],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tarea = Tarea::find($id);
        if (!$tarea) {
            return response()->json(['success' => false, 'message' => 'Tarea no encontrada'], 404);
        }

        $tarea->delete();

        return response()->json(['success' => true, 'message' => 'Tarea eliminada con éxito']);
    }

    public function buscar(Request $request){
        try {
             $usuario = Auth::user();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no autenticado'], 401);
            }

            $query = Tarea::where('id_usuario', $usuario->id_usuario)
                ->with(['usuario', 'notificacion']);

            // Filtro por título (sin whereRaw)
            if ($request->filled('titulo')) {
                $query->where('titulo', 'LIKE', '%' . $request->titulo . '%');
            }

            // Filtro por fecha
            if ($request->filled('fecha_limite')) {
                $query->whereDate('fecha_limite', $request->fecha_limite);
            }

            $tareas = $query->orderBy('fecha_creacion', 'desc')->get();

            if ($tareas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontraron tareas que coincidan con los filtros proporcionados.'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tareas encontradas correctamente',
                'data' => $tareas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al buscar tareas: ' . $e->getMessage()
            ], 500);
        }
    }
}
