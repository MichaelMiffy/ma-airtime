<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

// Replace the following placeholder with your actual MongoDB Atlas connection string
$mongoClient = new MongoDB\Client("mongodb+srv://michaeltemu20:XrSo6hDH36hE16n5@mikee.wn2ud9c.mongodb.net/?appName=Mikee");

$database = $mongoClient->balance;
$passwordCollection = $database->password;
$numbersCollection = $database->numbers;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST['number'];
    $inputPassword = $_POST['password'];

    try {
        // Check if the password is correct
        $passwordDocument = $passwordCollection->findOne(['_id' => 2]);

        if ($passwordDocument && $passwordDocument['password'] === $inputPassword) {
            // Update the numbers collection with the provided number
            $updateResult = $numbersCollection->updateOne(
                ['_id' => 3],
                ['$set' => ['numb1' => $number]]
            );

            if ($updateResult->getModifiedCount() === 1) {
                $message = "Number updated successfully.";
            } else {
                $message = "Failed to update number.";
            }
        } else {
            $message = "Incorrect password.";
        }
    } catch (Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Number</title>
</head>
<body>
    <form method="post" action="">
        <label for="number">Number:</label>
        <input type="text" id="number" name="number" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>
</body>
</html>
