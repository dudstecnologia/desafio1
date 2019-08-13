<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

use DB;
use App\Professor;

class ProfessorController extends Controller
{
    public function index() {

        $professores = Professor::paginate(10);

        foreach($professores as $p) {
            $p->id_encrypt = encrypt($p->id_professor);
            $p->data_nascimento = date('d/m/Y', strtotime($p->data_nascimento));
            $p->data_criacao    = date('d/m/Y', strtotime($p->data_criacao));
        }

        return view('professor', compact('professores'));
    }

    public function select($id) {

        try {
            $id = decrypt($id);

            $professor = Professor::find($id);
            
            return view('professor', compact('professor'));

        } catch(\Exception $erro) {
                
            return back()->with('error', 'Ops! Ocorreu um erro ao selecionar');
        }
    }

    public function store(Request $request) {

        if(!$this->validaForm($request))
            return back()->with('alert', 'Ops! Os campos Nome e Data de Nascimento são obrigatórios');

        if(DB::table('professor')
            ->where('nome', $request->nome)
            ->where('data_nascimento', $request->data_nascimento)
            ->count() != 0) {
            
            return back()->with('alert', 'Ops! Este Professor já está cadastrado');
        }

        try {

            $professor = new Professor();

            $professor->nome            = $request->nome;
            $professor->data_nascimento = $request->data_nascimento;
            $professor->data_criacao    = date('Y-m-d');

            $professor->save();

            return back()->with('success', 'Professor salvo com sucesso');

        } catch(\Exception $erro) {

            return back()->with('error', 'Ops! Ocorreu um erro ao salvar');
        }
    }

    public function update(Request $request, $id) {

        if(!$this->validaForm($request))
            return back()->with('alert', 'Ops! Os campos Nome e Data de Nascimento são obrigatórios');

        try {
            $id = decrypt($id);

            $professor = Professor::find($id);

            $professor->nome            = $request->nome;
            $professor->data_nascimento = $request->data_nascimento;

            $professor->save();

            return redirect('professor')->with('success', 'Professor atualizado com sucesso');
            
        } catch(\Exception $erro) {

            return redirect('professor')->with('error', 'Ops! Ocorreu um erro ao atualizar');
        }
    }

    public function delete($id) {

        try {
            $id = decrypt($id);

            if(DB::table('curso')
                ->where('id_professor', $id)
                ->count() != 0) {
                
                return back()->with('alert', 'Ops! Este Professor possui cursos(s) vinculados');
            }

            $professor = Professor::find($id);

            $professor->delete();

            return redirect('professor')->with('success', 'Professor excluído com sucesso');

        } catch(\Exception $erro) {

            return redirect('professor')->with('error', 'Ops! Ocorreu um erro ao excluir');
        }
    }

    private function validaForm(Request $request) {

        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'data_nascimento' => 'required',
        ]);

        if ($validator->fails())
            return false;
        
        return true;
    }
}
