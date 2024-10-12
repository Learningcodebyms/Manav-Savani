<?php
include 'db.php';

$id = $_GET['id'];

$sql = "SELECT * FROM ad_book WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $ownername = $_POST['ownername'];
    $mobileno = $_POST['mobileno'];
    $deliveryaddress = $_POST['deliveryaddress'];

    // Validate mobile number: only 10 digits and starts with 7, 8, or 9
    if (preg_match("/^[789]\d{9}$/", $mobileno)) {
        $sql = "INSERT INTO user_book (id, ownername, mobileno, deliveryaddress, bikename, bikemodel, color) 
                VALUES ('$id', '$ownername', '$mobileno', '$deliveryaddress', '".$row['bikename']."', '".$row['bikemodel']."', '".$row['color']."')";

        if ($conn->query($sql) === TRUE) {
            // If the booking is successful, show an alert message
            echo "<script>alert('Booking Successfully Completed!'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<script>alert('Invalid mobile number! Please enter a 10-digit number starting with 7, 8, or 9.');</script>";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="addedit.css">
</head>
<body>
<form method="POST" action="" enctype="multipart/form-data" class="booking-form">
    <label for="bikename">Company Name :- </label>
    <input type="text" id="bikename" name="bikename" value="<?php echo $row['bikename']; ?>" readonly><br>

    <label for="bikemodel">Bike Model :- </label>
    <input type="text" id="bikemodel" name="bikemodel" value="<?php echo $row['bikemodel']; ?>" readonly><br>

    <label for="color">Color :- </label>
    <input type="text" id="color" name="color" value="<?php echo $row['color']; ?>" readonly><br>

    <label for="price">Price :- </label>
    <input type="number" id="price" name="price" value="<?php echo isset($row['price']) ? $row['price'] : ''; ?>" readonly><br>

    <label for="ownername">Owner Name :- </label>
    <input type="text" id="ownername" name="ownername" required><br>

    <label for="mobileno">Mobile No :- </label>
    <input type="number" id="mobileno" name="mobileno" required oninput="validateMobile()" maxlength="10"><br>

    <label for="deliveryaddress">Delivery Address :- </label>
    <textarea id="deliveryaddress" name="deliveryaddress" required></textarea><br>

    <button type="submit">BOOK</button>
</form>
<script>
// JavaScript validation for mobile number (10 digits starting with 7, 8, or 9)
function validateMobile() {
    var mobileInput = document.getElementById("mobileno");
    var mobileValue = mobileInput.value;

    // Ensure the number starts with 7, 8, or 9 and is 10 digits long
    if (!/^[789]\d{0,9}$/.test(mobileValue)) {
        alert("Invalid mobile number! Please enter a 10-digit mobile number starting with 7, 8, or 9.");
        mobileInput.value = mobileValue.slice(0, -1); // Remove the last invalid character
    }
}
</script>
</body>
</html>
