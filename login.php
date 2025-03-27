<?php 
session_start();
include 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUtente = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM utenti WHERE nomeUtente = ?");
    $stmt->execute([$nomeUtente]);
    $utente = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($utente && password_verify($password, $utente['password_hash'])) {
        $_SESSION['user'] = $utente['nomeUtente'];
        header("Location: negozio.php");
        exit();
    } else {
        echo "Credenziali errate!";
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>
 
  <form method="post">
    <div class="container">
        <input type="text" name="username" placeholder="Nome utente" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-login_register">Accedi</button>
    </div>
  </form>
 
</body>
</html>
