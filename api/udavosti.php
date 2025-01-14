<?php
// api/udavosti.php

header('Content-Type: application/json');
include '../db.php';

// Zpracování POST požadavku pro nastavení události
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $zakaznikId = intval($_POST['zakaznikId']);
    $typUdalosti = $_POST['typUdalosti'];
    $hodnota = floatval($_POST['hodnota']);
    $aktivni = isset($_POST['aktivni']) ? 1 : 0;

    // Vložení nové události do databáze
    $sql = "INSERT INTO Udalosti (Zakaznik_ID, TypUdalosti, Hodnota, Aktivni) VALUES ($zakaznikId, '$typUdalosti', $hodnota, $aktivni)";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Událost byla úspěšně nastavena."]);
    } else {
        echo json_encode(["error" => "Chyba při nastavování události."]);
    }
} else {
    echo json_encode(["error" => "Neplatný požadavek."]);
}

$conn->close();

?>
<?php
// api/udavosti.php (pokračování)

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $zakaznikId = intval($_GET['zakaznikId']);

    // Získání událostí pro daného zákazníka
    $sql = "SELECT * FROM Udalosti WHERE Zakaznik_ID = $zakaznikId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $udalosti = [];
        while ($row = $result->fetch_assoc()) {
            $udalosti[] = $row;
        }
        echo json_encode($udalosti);
    } else {
        echo json_encode(["error" => "Žádné události nenalezeny."]);
    }
}
?>