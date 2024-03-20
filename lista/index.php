<?php
session_start();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['item']) && $_POST['item'] !== '') {
        $item = $_POST['item'];
        $_SESSION['lista_compras'][] = $item;
        setcookie('lista_compras', time()+20*24*60*60);
    }

    if (isset($_POST['excluir'])) {
        if (!empty($_POST['check'])) {
            foreach ($_POST['check'] as $key => $value) {
                if (isset($_SESSION['lista_compras'][$key])) {
                    unset($_SESSION['lista_compras'][$key]);
                    setcookie("lista_compras", "", time()-3600);
                }
            }
        }
    }

    if (isset($_POST['limpa_lista'])) {
        unset($_SESSION['lista_compras']);
        setcookie("lista_compras", "", time()-3600);
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Lista de compras</title>

    <div id="botao_limpar">
        <form action="index.php"method="post">
            <input type="submit" name="limpa_lista" value="Limpar toda a lista">
        </form>
    </div>
</head>

<body>
    <center>
        <h1>Lista de compras</h1>
    <div id="adicionar_item">
    <form action="index.php" method="post">
        <input type="text" name="item" placeholder="Digite o item">
        <input type="submit" value="Adicionar à lista">
    </form>
    </div>
    </center>

    <div id="caixa">
    <form action="index.php" method="post">
        <ul>
            <?php
            if (!empty($_SESSION['lista_compras'])) {
                foreach ($_SESSION['lista_compras'] as $key => $item) {
                    echo "<li>";
                    echo "<input type='checkbox' name='check[$key]' value='1'>";
                    echo "<label>$item</label>";
                    echo "</li>";
                }
            } else {
                echo "<li>Nenhum item na lista.</li>";
            }
            ?>
        </ul>
        <input type="submit" name="excluir" value="Excluir Itens Marcados">
    </form>
    </div>
</body>
</html>