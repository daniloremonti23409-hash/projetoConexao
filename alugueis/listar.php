<?php

require '../conexao.php';
$sql = "SELECT
            a.id,   -- ID do aluguel
            u.nome   AS usuarios, -- Nome do usuário que alugou o livro
            l.titulo AS livros, -- Título do livro alugado
            a.data_aluguel, -- Data em que o livro foi alugado
            a.data_devolucao, -- Data limite para devolução
            a.devolvido,  -- Status da devolução (0 = não devolvido / 1 = devolvido)
            a.id_livro -- ID do livro alugado
        FROM alugueis a
        JOIN usuarios u ON a.id_usuario = u.id -- Relaciona a tabela alugueis com usuarios
        JOIN livros l   ON a.id_livro   = l.id -- Relaciona a tabela alugueis com livros
        ORDER BY a.id DESC"; /*Ordena os registros do mais recente para o mais antigo*/
$stmt = $pdo->query($sql);
$alugueis = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define o conjunto de caracteres para português -->
    <meta charset="UTF-8">
 
    <!-- Título exibido na aba do navegador -->
    <title>Lista de Aluguéis</title>
 
    <!-- Importa o arquivo CSS responsável pelo layout -->
    <link rel="stylesheet" href="../style.css">
</head>
 
<body>
 
<!-- Container principal da página -->
<div class="lista-container">
 
    <!-- Título principal -->
    <h1>Lista de Aluguéis</h1>
 
    <!-- Botão para voltar ao painel principal -->
    <a href="../painel.php" class="btn-voltar">Voltar para o Painel</a>
 
    <!-- Tabela responsável por exibir os dados -->
    <table class="tabela-usuarios">
 
        <!-- Cabeçalho da tabela -->
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Livro</th>
                <th>Alugado em</th>
                <th>Devolver até</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
 
        <!-- Corpo da tabela -->
        <tbody>
 
        <!-- Laço foreach que percorre o array de aluguéis -->
        <?php foreach($alugueis as $a): ?>
            <tr>
 
                <!-- Exibe o ID do aluguel -->
                <td><?= $a['id'] ?></td>
 
                <!-- Exibe o nome do usuário -->
                <td><?= $a['usuarios'] ?></td>
 
                <!-- Exibe o título do livro -->
                <td><?= $a['livros'] ?></td>
 
                <!-- Formata a data do aluguel para o padrão brasileiro -->
                <td><?= date('d/m/Y', strtotime($a['data_aluguel'])) ?></td>
 
                <!-- Formata a data da devolução -->
                <td><?= date('d/m/Y', strtotime($a['data_devolucao'])) ?></td>
 
                <!-- Exibe o status do aluguel -->
                <td>
                <!-- Operador ternario -  Se devolvido for verdadeiro
                 mostrar Devolvido senao Alugado-->
                    <?= $a['devolvido'] ? 'Devolvido' : 'Alugado' ?>
                </td>
 
                <!-- Coluna de ações -->
                <td>
 
                    <!-- Verifica se o livro ainda não foi devolvido -->
                     <!-- Se nao foi devolvido vai mostrar o botao devolver -->
                     
                    <?php if (!$a['devolvido']): ?>
 
                        <!-- Link para acionar a devolução
                         Serve para enviar as informacoes do ID do aluguel e o ID do livro-->
                        <a class="btn-editar"
                       
                           href="devolver.php?id=<?= $a['id'] ?>&livro=<?= $a['id_livro'] ?>">
                           Devolver
                        </a>
 
                    <?php else: ?>
                        <!-- Caso já tenha sido devolvido, exibe apenas um traço -->
                        -
                    <?php endif; ?>
 
                </td>
 
            </tr>
        <?php endforeach; ?>
 
        </tbody>
 
    </table>
 
</div>
 
</body>
</html>