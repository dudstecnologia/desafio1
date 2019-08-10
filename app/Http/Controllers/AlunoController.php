<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;
use App\Aluno;
use App\Curso;

class AlunoController extends Controller
{
    public function index() {

        $cursos = $this->getCursos();

        $alunos = $this->getAlunos();
        
        return view('aluno', compact('cursos'), compact('alunos'));
    }

    public function select($id) {

        try {
            $id = decrypt($id);

            $cursos = $this->getCursos();

            $aluno = Aluno::find($id);

            $aluno->id_encrypt = encrypt($aluno->id_aluno);

            foreach ($cursos as $c) {
                if($c->id_curso == $aluno['id_curso']) {
                    $aluno->id_curso_encrypt = $c->id_encrypt;
                }
            }

            return view('aluno', compact('cursos'), compact('aluno'));
            
        } catch(\Exception $erro) {
                
            return back()->with('error', 'Ops! Ocorreu um erro ao selecionar');
        }
    }

    public function store(Request $request) {

        if(!$this->validaForm($request))
            return back()->with('alert', 'Ops! Os campos Nome e Data de Nascimento são obrigatórios');

        try {

            $aluno = new Aluno();

            $aluno->nome            = $request->nome;
            $aluno->data_nascimento = $request->data_nascimento;
            $aluno->logradouro      = $request->logradouro;
            $aluno->numero          = $request->numero;
            $aluno->bairro          = $request->bairro;
            $aluno->cidade          = $request->cidade;
            $aluno->estado          = $request->estado;
            $aluno->data_criacao    = date('Y-m-d');
            $aluno->cep             = $request->cep;
            $aluno->id_curso        = decrypt($request->id_curso);
            
            $aluno->save();

            return back()->with('success', 'Aluno salvo com sucesso');

        } catch(\Exception $erro) {

            return back()->with('error', 'Ops! Ocorreu um erro ao salvar');
        }
    }

    public function update(Request $request, $id) {

        if(!$this->validaForm($request))
            return back()->with('alert', 'Ops! Os campos Nome e Data de Nascimento são obrigatórios');

        try {
            
            $id = decrypt($id);

            $aluno = Aluno::find($id);

            $aluno->nome            = $request->nome;
            $aluno->data_nascimento = $request->data_nascimento;
            $aluno->logradouro      = $request->logradouro;
            $aluno->numero          = $request->numero;
            $aluno->bairro          = $request->bairro;
            $aluno->cidade          = $request->cidade;
            $aluno->estado          = $request->estado;
            $aluno->cep             = $request->cep;
            $aluno->id_curso        = decrypt($request->id_curso);

            $aluno->save();

            return redirect('/')->with('success', 'Aluno atualizado com sucesso');
            
        } catch(\Exception $erro) {

            return redirect('/')->with('error', 'Ops! Ocorreu um erro ao atualizar');
        }

    }

    public function delete($id) {

        try {
            $id = decrypt($id);

            $aluno = Aluno::find($id);

            $aluno->delete();

            return redirect('/')->with('success', 'Aluno excluído com sucesso');

        } catch(\Exception $erro) {

            return redirect('/')->with('error', 'Ops! Ocorreu um erro ao excluir');
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

    public function relatorio() {

        $alunos = $this->getAlunos();

        return PDF::loadView('relatorio', compact('alunos'))
            ->download('Relatorio.pdf');
    }

    private function getAlunos() {

        $alunos = DB::table('aluno')
            ->join('curso', 'curso.id_curso', '=', 'aluno.id_curso')
            ->join('professor', 'professor.id_professor', '=', 'curso.id_professor')
            ->select('aluno.id_aluno', 'aluno.nome as nome_aluno', 'aluno.data_criacao', 'aluno.data_nascimento', 'curso.nome as nome_curso', 'professor.nome as nome_professor')
            ->paginate(10);

        foreach($alunos as $a) {
            $a->id_encrypt = encrypt($a->id_aluno);
            $a->data_nascimento = date('d/m/Y', strtotime($a->data_nascimento));
            $a->data_criacao    = date('d/m/Y', strtotime($a->data_criacao));
        }

        return $alunos;
    }

    private function getCursos() {

        $cursos = Curso::all('id_curso', 'nome');

        foreach($cursos as $c) {
            $c->id_encrypt = encrypt($c->id_curso);
        }

        return $cursos;
    }
}
