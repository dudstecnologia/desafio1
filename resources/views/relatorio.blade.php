<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Relatorio</title>

        <link rel="stylesheet" href="{{ url('css/relatorio.css') }}">
    </head>
    <body>
        
        <h2>ALUNOS CADASTRADOS</h2>

        <table>
            <tr>
                <th>ALUNO</th>
                <th>CURSO</th>
                <th>PROFESSOR</th>
            </tr>

            @forelse($alunos as $a)
                <tr>
                    <td>{{ $a->nome_aluno }}</td>
                    <td>{{ $a->nome_curso }}</td>
                    <td>{{ $a->nome_professor }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Nenhum Aluno Cadastrado</td>
                </tr>
            @endforelse

        </table>
        
    </body>
</html>