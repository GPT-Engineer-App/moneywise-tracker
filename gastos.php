<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $tipo = 'gasto';
    $conta_id = 1; // Exemplo, deve ser dinâmico
    $categoria_nome = $_POST['categoria_nome'];

    $sql = "INSERT INTO transacao (descricao, valor, data, tipo, conta_id, categoria_nome) VALUES ('$descricao', '$valor', '$data', '$tipo', '$conta_id', '$categoria_nome')";
    if ($conn->query($sql) === TRUE) {
        echo "Gasto adicionado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Gastos</h1>
        <form method="POST">
            <input type="text" name="descricao" placeholder="Descrição" required>
            <input type="number" name="valor" placeholder="Valor" required>
            <input type="date" name="data" required>
            <input type="text" name="categoria_nome" placeholder="Categoria" required>
            <button type="submit">Adicionar Gasto</button>
        </form>
        <div class="gastos-list">
            <h2>Lista de Gastos</h2>
            <?php
            $sql = "SELECT * FROM transacao WHERE tipo='gasto'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='gasto-item'>";
                    echo "<p>Descrição: " . $row['descricao'] . "</p>";
                    echo "<p>Valor: " . $row['valor'] . "</p>";
                    echo "<p>Data: " . $row['data'] . "</p>";
                    echo "<p>Categoria: " . $row['categoria_nome'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "Nenhum gasto encontrado.";
            }
            ?>
        </div>
    </div>
</body>
</html>