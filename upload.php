<?php
// upload.php

// Cílový adresář pro nahrané soubory
$targetDir = "uploads/";
$targetFile = $targetDir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Kontrola, zda je soubor skutečně Excel
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        echo "Soubor je platný - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Soubor není platný.";
        $uploadOk = 0;
    }
}

// Kontrola, zda soubor již existuje
if (file_exists($targetFile)) {
    echo "Omlouváme se, soubor již existuje.";
    $uploadOk = 0;
}

// Kontrola velikosti souboru (max 5MB)
if ($_FILES["file"]["size"] > 5000000) {
    echo "Omlouváme se, soubor je příliš velký.";
    $uploadOk = 0;
}

// Povolené formáty souborů
if ($fileType != "xlsx") {
    echo "Omlouváme se, pouze soubory .xlsx jsou povoleny.";
    $uploadOk = 0;
}

// Kontrola, zda $uploadOk je nastaveno na 0 (chyba)
if ($uploadOk == 0) {
    echo "Omlouváme se, soubor nebyl nahrán.";
// Pokud je vše v pořádku, pokusíme se nahrát soubor
} else {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
        echo "Soubor ". htmlspecialchars(basename($_FILES["file"]["name"])) . " byl úspěšně nahrán.";
        // Zde můžete přidat kód pro zpracování souboru a aktualizaci databáze
    } else {
        echo "Omlouváme se, došlo k chybě při nahrávání souboru.";
    }
}
?>