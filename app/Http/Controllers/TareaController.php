<?php

namespace App\Http\Controllers;  

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TareaController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la lista de tareas
        $tareas = DB::connection('mysql_pruebas')->table('tareas')
            ->leftJoin('proyectos', 'tareas.proyecto_id', '=', 'proyectos.id')
            ->leftJoin('users', 'tareas.user_id', '=', 'users.id')
            ->select('tareas.*', 'proyectos.proyecto', 'users.name as user_name')
            ->get();

        $proyectos = DB::connection('mysql_pruebas')->table('proyectos')->get();

        $users = DB::connection('mysql_pruebas')->table('users')->get();



        return view('tareas.index', ['tareas' => $tareas, 'proyectos' => $proyectos, 'users' => $users]);
    }

    public function store(Request $request)
    {

        // Lógica para guardar una nueva tarea
        $datos = $request->validate([
            'tarea' => 'required|string|max:100',
            'proyecto_id' => 'nullable|exists:proyectos,id',
        ]);

        $completada = $request->boolean('completada');

        DB::connection('mysql_pruebas')->table('tareas')->insert([
            'tarea' => $datos['tarea'],
            'proyecto_id' => $datos['proyecto_id'] ?? null,
            'completada' => $completada,
            // El dueño lo decide el servidor, nunca el formulario: así nadie
            // puede crear una tarea a nombre de otro usuario manipulando la
            // petición (aunque sea un campo "hidden" en el HTML).
            'user_id' => auth()->id(),
        ]);

        return redirect('/tareas');
    }

    public function edit($id)
    {
        // Lógica para mostrar el formulario de edición de una tarea
        $tarea = DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->first();

        // Nadie debería ni siquiera VER el formulario de una tarea ajena,
        // no solo que falle al guardar — por eso la comprobación va aquí
        // también, no solo en update().
        if ($tarea->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta tarea.');
        }

        $proyecto = DB::connection('mysql_pruebas')->table('proyectos')->where('id', $tarea->proyecto_id)->first();
        $proyectos = DB::connection('mysql_pruebas')->table('proyectos')->get();

        return view ('tareas.edit', ['tarea' => $tarea, 'proyecto' => $proyecto, 'proyectos' => $proyectos]);
    }

    public function update(Request $request, $id)
    {
        $tarea = DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->first();

        if ($tarea->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para editar esta tarea.');
        }

        // Lógica para actualizar una tarea existente
        $datos = $request->validate([
            "tarea" => 'required|string|max:100',
            "proyecto_id" => 'nullable|exists:proyectos,id',
        ]);

        $completada = $request->boolean('completada');

        DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->update([
            "tarea" => $datos['tarea'],
            "proyecto_id" => $datos['proyecto_id'] ?? null,
            "completada" => $completada,
        ]);

        return redirect('/tareas');
    }

    public function destroy($id)
    {
        $tarea = DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->first();

        if ($tarea->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta tarea.');
        }

        DB::connection('mysql_pruebas')->table('tareas')->where('id', $id)->delete();

        return redirect('/tareas');
    }
}
