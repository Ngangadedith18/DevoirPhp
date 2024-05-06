<?php
    require_once "DbConnect.php";

// Connexion a la base de donnees
$db = new DbConnect();
$conn = $db->connect();

// Verification de soumission du formulaire
if(isset($_POST['UserSave'])) {
    $lastName = $_POST['LastName'];
    $firstName = $_POST['FirstName'];
    $phone = $_POST['Phone'];
    $city = $_POST['City'];
    $address = $_POST['Address'];

    $stmt = $conn->prepare("INSERT INTO UserTable (LastName, FirstName, Phone, City, Address) VALUES (:lastName, :firstName, :phone, :city, :address)");
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':address', $address);

    
    $stmt->execute();
}

// Affichage des contacts
$stmt = $conn->query("SELECT * FROM usertable");
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<Doctype html>
<html>
<head>
	<meta chavset="utf-8">
    <title>Formulaire UserContact</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<form method="post" action="">
        <h2>Formulaire</h2>
        <label for="LastName">LastName:</label>
        <input type="text" name="LastName" required><br>
        <label for="FirstName">FirstName:</label>
        <input type="text" name="FirstName" required><br>
        <label for="phone">Phone:</label>
        <input type="text" name="Phone" required><br>
        <label for="phone">City:</label>
        <input type="text" name="City" required><br>
        <label for="city">Address:</label>
        <input type="text" name="Address" required><br>
        <input type="submit" value="UserSave" name="UserSave">
        <input type="submit" value="ShowContact" name="ShowContact">
</form>

<h1>Tableau de tous les contacts</h1>
<table class="tb">
    <tr>
        <th>Id</th>
        <th>LastName</th>
        <th>FirstName</th>
        <th>Phone</th>
        <th>City</th>
        <th>Address</th>
    </tr>
    <?php foreach($contacts as $contact): ?>
        <tr>
            <td><?= $contact['Id'] ?></td>
            <td><?= $contact['LastName'] ?></td>
            <td><?= $contact['FirstName'] ?></td>
            <td><?= $contact['Phone'] ?></td>
            <td><?= $contact['City'] ?></td>
            <td><?= $contact['Address'] ?></td>
        </tr>
        <?php endforeach; ?>
</table>

</body>
</html>