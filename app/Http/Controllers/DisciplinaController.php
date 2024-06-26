<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DisciplinaController extends Controller
{
    public function index()
    {
        return Inertia::render('Disciplina/Disciplina', [
            'disciplina' => Disciplina::all()
        ]);
    }

    public function create()
    {
        return Inertia::render('Disciplina/DisciplinaCreate');
    }

    public function edit($id)
    {
        $disciplina = Disciplina::findOrFail($id);
        return Inertia::render('Disciplina/DisciplinaEdit', [
            'disciplina' => $disciplina
        ]);
    }

    public function show($id)
    {
        $disciplina = Disciplina::find($id);
        return response()->json($disciplina);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|unique:disciplinas',
        ]);

        if ($validator->fails()) {
            return redirect('disciplina/create')
                ->withErrors($validator)
                ->withInput();
        }

        $disciplina = Disciplina::create($request->all());
        $disciplina = $disciplina->save();

        return redirect()->route('disciplina.index');
    }

    public function update(Request $request, Disciplina $disciplina)
    {
        $disciplina->update($request->all());
        return redirect()->route('disciplina.index');
    }

    public function destroy(Disciplina $disciplina)
    {
        $disciplina->delete();
        return response()->json(['message' => 'Disciplina deletada com sucesso']);
    }
}
