<?php

function calculateFinalScore($aluno) {
    $media_final = ($aluno['atitudinal'] * 0.10) + ($aluno['mensal'] * 0.30) + ($aluno['bimestral'] * 0.50);
    return $media_final;
}

function findTopFiveStudents($alunos) {
    usort($alunos, function($a, $b) {
        return calculateFinalScore($b) - calculateFinalScore($a);
    });
    return array_slice($alunos, 0, 5);
}

function validarCadastro($usuario) {
    global $alunos;

    if (strlen($usuario['nome']) < 5 || preg_match('/[0-9]/', $usuario['nome'])) {
        return false;
    }
    if (!filter_var($usuario['email'], FILTER_VALIDATE_EMAIL) || in_array($usuario['email'], array_column($alunos, 'email'))) {
        return false;
    }
    if (strlen($usuario['senha']) < 8 || strlen($usuario['senha']) > 16 || $usuario['senha'] !== $usuario['confirmacao_senha']) {
        return false;
    }
    return true;
}

$alunos = [
    [
        'nome' => 'João',
        'atitudinal' => 7.0,
        'mensal' => 8.0,
        'bimestral' => 9.0
    ],
    [
        'nome' => 'Maria',
        'atitudinal' => 8.0,
        'mensal' => 9.0,
        'bimestral' => 10.0
    ],
    [
        'nome' => 'José',
        'atitudinal' => 6.0,
        'mensal' => 7.0,
        'bimestral' => 8.0
    ],
    [
        'nome' => 'Pedro',
        'atitudinal' => 4.0,
        'mensal' => 3.0,
        'bimestral' => 0.0
    ],
    [
        'nome' => 'Eduardo',
        'atitudinal' => 7.0,
        'mensal' => 5.0,
        'bimestral' => 6.0
    ]
];

$usuario = [
    'nome' => 'João',
    'email' => 'joao@email.com',
    'senha' => '12345678',
    'confirmacao_senha' => '12345678'
];

echo "Média final de João: " . calculateFinalScore($alunos[0]) . "\n";

echo "Top 5 alunos com maiores médias finais:\n";
$top_alunos = findTopFiveStudents($alunos);
foreach ($top_alunos as $aluno) {
    echo $aluno['nome'] . ": " . calculateFinalScore($aluno) . "\n";
}

echo "Cadastro válido? " . (validarCadastro($usuario) ? "Sim" : "Não") . "\n";

?>