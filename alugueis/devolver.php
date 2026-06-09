<?php
require '../conexao.php';
$id = $_GET['id'];
$livro = $_GET['livro'];

try{

$pdo->prepare("UPDATE alugueis SET devolvido = 1 WHERE id = :id")
->execute(['id' => $id]);
$pdo->prepare("UPDATE livros SET disponivel = 1 WHERE id = :livro")
->execute([':livro' => $livro]);
echo "<script>
alert('Livro devolvido com sucesso!');
window.location= 'listar.php'; 
</script>";

}catch (PDOException $e){
echo "Erro: " . $e->getMessage();

}

?>