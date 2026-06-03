<?php

require '../conexao.php';
$usuarios = $pdo->query("SELECT id, nome FROM usuarios")->
fetchAll(PDO::FETCH_ASSOC);
$livros =$pdo->query("SELECT id, titulo FROM livros WHERE disponivel = 1")
->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER["REQUEST_METHOD"]==="POST"){
$id_usuario = $_POST['usuario'];
$id_livro = $_POST['livro'];
$data_aluguel = date('Y - m - d');
$data_devolucao = date('Y - m - d', strtotime ('+7 days'));
try{

$sql = "INSERT INTO alugueis
(id_usuario, id_livro, data_aluguel, data_devolucao, devolvido)
VALUES (:usuario,:livro,:aluguel,:devolucao,0)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
':usuario'=>$id_usuario,
':livro'=>$id_livro,
':alguel'=>$data_aluguel,
':devolucao'=>$data_devolucao

]);
$pdo->prepare("UPDATE livros SET disponivel = 0 WHERE id = :id")
->execute([':id'=>$id_livro]);
echo "<script>
alert('livro alugado com sucesso!');
window.location='listar.php';
</script>";
}catch(PDOException $e){
    $mensagem = "<p class = 'erro'>Erro: ".$e->getMessage()."</p>";
}

}

?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Define o conjunto de caracteres -->
    <meta charset="UTF-8">
 
    <!-- Título da página -->
    <title>Alugar Livro</title>
 
    <!-- Importa o arquivo CSS -->
    <link rel="stylesheet" href="../style.css">
</head>
 
<body>
 
<div class="container">
 
    <!-- Título principal -->
    <h1>Alugar Livro</h1>
 
    <!-- Exibe mensagem de erro, se existir -->
    <?= $mensagem ?? '' ?>
 
    <!-- Formulário que envia dados via método POST -->
    <form method="POST">
 
        <!-- Select para escolha do usuário -->
        <select name="usuario" required>
            <option value="">Selecione o Usuário</option>
 
            <!-- Laço foreach para listar usuários -->
            <?php foreach($usuarios as $u): ?>
                <option value="<?= $u['id'] ?>">
                    <?= $u['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
 
        <!-- Select para escolha do livro -->
        <select name="livro" required>
            <option value="">Selecione o Livro</option>
 
            <!-- Laço foreach para listar livros -->
            <?php foreach($livros as $l): ?>
                <option value="<?= $l['id'] ?>">
                    <?= $l['titulo'] ?>
                </option>
            <?php endforeach; ?>
        </select>
 
        <!-- Botão de envio -->
        <button type="submit">Alugar Livro</button>
 
        <!-- Link para voltar -->
        <a href="../painel.php" class="btn-voltar">Voltar</a>
 
    </form>
 
</div>
 
</body>
</html>