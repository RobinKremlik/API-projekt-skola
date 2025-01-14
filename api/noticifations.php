<?php
// api/notifications.php

header('Content-Type: application/json');
include '../db.php';

// Registrace PUSH notifikací
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'register') {
        $zakaznikId = intval($_POST['zakaznikId']);
        $deviceToken = $_POST['deviceToken'];

        // Uložení tokenu do databáze (předpokládáme, že máte tabulku pro tokeny)
        $sql = "INSERT INTO NotificationTokens (Zakaznik_ID, DeviceToken) VALUES ($zakaznikId, '$deviceToken')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(["message" => "Registrace pro PUSH notifikace byla úspěšná."]);
        } else {
            echo json_encode(["error" => "Chyba při registraci."]);
        }
    } elseif ($_POST['action'] === 'send') {
        $message = $_POST['message'];
        $zakaznikId = intval($_POST['zakaznikId']);

        // Zde byste měli implementovat logiku pro odesílání notifikací
        // Například pomocí Firebase Cloud Messaging (FCM) nebo jiného systému

        echo json_encode(["message" => "Notifikace byla úspěšně odeslána."]);
    }
} else {
    echo json_encode(["error" => "Neplatný požadavek."]);
}

$conn->close();
?>