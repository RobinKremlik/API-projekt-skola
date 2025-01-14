<?php
// index.php

// Základní směrování pro API
if (isset($_GET['api'])) {
    switch ($_GET['api']) {
        case 'odecTy':
            include 'api/odecTy.php';
            break;
        case 'notifications':
            include 'api/notifications.php';
            break;
        default:
            echo json_encode(["error" => "Neplatný API endpoint."]);
            break;
   