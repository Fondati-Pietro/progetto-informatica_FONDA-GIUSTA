<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';
$search = $_GET['search'] ?? '';
$stmt = $conn->prepare("SELECT prodotti.*, immagini_prodotti.immagine_url FROM prodotti LEFT JOIN immagini_prodotti ON prodotti.id = immagini_prodotti.prodotto_id WHERE prodotti.nome LIKE ?");
$stmt->execute(["%$search%"]);
$prodotti = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <title>Negozio</title>
</head>
<body>
    <h1>Benvenuto, <?php echo $_SESSION['user']; ?>!</h1>
    <form method="get">
        <input type="text" name="search" placeholder="Cerca un prodotto">
        <button type="submit">Cerca</button>
    </form>
    <div class="row">
        <?php foreach ($prodotti as $prodotto): ?>
            <div class="col-md-4 mb-4">
                <div class="card" style="width: 18rem;">
                    <?php if ($prodotto['immagine_url']): ?>
                        <img src="<?php echo htmlspecialchars($prodotto['immagine_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($prodotto['nome']); ?>">
                    <?php else: ?>
                        <img src="path/to/default-image.jpg" class="card-img-top" alt="Immagine non disponibile">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($prodotto['nome']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($prodotto['descrizione']); ?></p>
                        <p class="card-text">Prezzo: <?php echo $prodotto['prezzo']; ?>€</p>
                        <a href="#" class="btn btn-primary">Dettagli</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>