<?php
// api/odecTy.php

header('Content-Type: application/json');
include '../db.php';

// Získání parametrů
$zakaznikId = isset($_GET['zakaznikId']) ? intval($_GET['zakaznikId']) : null;
$nemovitostId = isset($_GET['nemovitostId']) ? intval($_GET['nemovitostId']) : null;

// Příprava SQL dotazu
$sql = "SELECT * FROM OdecTy WHERE 1=1";
if ($zakaznikId) {
    $sql .= " AND Meridlo_ID IN (SELECT ID FROM Meridla WHERE Nemovitost_ID IN (SELECT ID FROM Nemovitosti WHERE Zakaznik_ID = $zakaznikId))";
}
if ($nemovitostId) {
    $sql .= " AND Meridlo_ID IN (SELECT ID FROM Meridla WHERE Nemovitost_ID = $nemovitostId)";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $odecTy = [];
    while ($row = $result->fetch_assoc()) {
        $odecTy[] = $row;
    }
    echo json_encode($odecTy);
} else {
    echo json_encode(["error" => "Odečty nenalezeny."]);
}

$conn->close();
?>