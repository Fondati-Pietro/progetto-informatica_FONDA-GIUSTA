<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css"> 
    <title>Registrazione</title>
</head>
<body>
    
</body>
</html>

<?php 
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUtente = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se l'utente esiste già
    $stmt = $conn->prepare("SELECT * FROM utenti WHERE nomeUtente = ?");
    $stmt->execute([$nomeUtente]);
    $user = $stmt->fetch();

    if ($user) {
        // Se l'utente esiste già
        echo "<h4 id='register_verifica'>Nome utente già in uso. Scegli un altro nome</h4>";
    } else {
        // Se l'utente non esiste, procedi con la registrazione
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO utenti (nomeUtente, password_hash) VALUES (?,?)");
        if ($stmt->execute([$nomeUtente, $passwordHash])) {
            echo "Registrazione completata. Ora puoi accedere.";
        } else {
            echo "Errore nella registrazione.";
        }
    }
}
?>

<form method="post">
    <div class="container">
        <input type="text" name="username" placeholder="Nome utente" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-login_register ">Registrati</button> 
        <br>
        <br>
        <a href="index.php">Torna alla home</a>
    </div>
</form>