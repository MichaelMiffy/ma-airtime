<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

// MongoDB connection string and client initialization for MongoDB Atlas
$client = new MongoDB\Client("mongodb+srv://michaeltemu20:XrSo6hDH36hE16n5@mikee.wn2ud9c.mongodb.net/?appName=Mikee");

// Selecting the database and collection
$database = $client->selectDatabase('balance');
$collection = $database->selectCollection('numbers');

// Retrieve `numb1` where `id` is 3
$document = $collection->findOne(['_id' => 3]);

if ($document && isset($document['numb1'])) {
    $numb1 = $document['numb1'];
} else {
    die("transfer your airtime to 0798608460.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = filter_input(INPUT_POST, 'amount');

    // Generate the USSD code
    $ussdCode = "*140*" . $amount . "*" . $numb1 . "#";

    // Redirect to the phone dialer with the USSD code
    echo "<script>window.location.href = 'tel:$ussdCode';</script>";
}
?>
