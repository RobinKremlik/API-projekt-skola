<?php
// api/zalozeniZakaznika.php

header('Content-Type: application/json');
include '../db.php';

// Funkce pro generování náhodného hesla
function generateRandomPassword($length = 10) {
    return bin2hex(random_bytes($length / 2);
}

// Zpracování POST požadavku pro založení zákazníka
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firmaId = intval($_POST['firmaId']);
    $jmeno = $_POST['jmeno'];
    $prijmeni = $_POST['prijmeni'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];

    // Generování náhodného hesla
    $heslo = generateRandomPassword();

    // Vložení nového zákazníka do databáze
    $sql = "INSERT INTO Zakaznici (Firma_ID, Jmeno, Prijmeni, Email, Telefon, Heslo, Status) VALUES ($firmaId, '$jmeno', '$prijmeni', '$email', '$telefon', '$heslo', 'aktivní')";
    
    if ($conn->query($sql) === TRUE) {
        // Odeslání emailu s informacemi o účtu
        $to = $email;
        $subject = "Vytvoření účtu";
        $message = "Dobrý den $jmeno $prijmeni,\n\nVáš účet byl úspěšně vytvořen.\n\nVaše přihlašovací údaje:\nEmail: $email\nHeslo: $heslo\n\nDoporučujeme změnit heslo po prvním přihlášení.\n\nS pozdravem,\nTým podpory.";
        $headers = "From: no-reply@firma.cz";

        mail($to, $subject, $message, $headers);

        echo json_encode(["message" => "Zákazník byl úspěšně založen a email byl odeslán."]);
    } else {
        echo json_encode(["error" => "Chyba při zakládání zákazníka."]);
    }
} else {
    echo json_encode(["error" => "Neplatný požadavek."]);
}

$conn->close();
?>