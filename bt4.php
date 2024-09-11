<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body> 

<?php
$dbh = mysqli_connect('localhost', 'root', '123456', 'in4');

if (!$dbh) {
    die("Unable to connect to MySQL: " . mysqli_connect_error());
}

$sql_stmt = "SELECT * FROM my_contacts";
$result = mysqli_query($dbh, $sql_stmt);

if (!$result) {
    die("Database access failed: " . mysqli_error($dbh));
}

$rows = mysqli_num_rows($result);
if ($rows) {
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        echo 'ID: ' . $row['id'] . '<br>';
        echo 'Full Names: ' . $row['full_names'] . '<br>';
        echo 'Gender: ' . $row['gender'] . '<br>';
        echo 'Contact No: ' . $row['contact_no'] . '<br>';
        echo 'Email: ' . $row['email'] . '<br>';
        echo 'City: ' . $row['city'] . '<br>';
        echo 'Country: ' . $row['country'] . '<br><br>';
    }
}


$name = "Mai Anh";
$gender = "Nữ";
$contact_no = "0123456789";
$email = "manhne14424@gmail.com";
$city = "Hà Nội";
$country = "Việt Nam";

$sql_insert = "INSERT INTO my_contacts (full_names, gender, contact_no, email, city, country) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($dbh, $sql_insert);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($dbh));
}

mysqli_stmt_bind_param($stmt, "ssssss", $name, $gender, $contact_no, $email, $city, $country);

if (mysqli_stmt_execute($stmt)) {
    echo "Đã thêm dữ liệu thành công!<br>";
} else {
    echo "Lỗi thêm dữ liệu: " . mysqli_stmt_error($stmt) . "<br>";
}


$id_to_delete = 6;

$sql_delete = "DELETE FROM my_contacts WHERE id = ?";

$stmt = mysqli_prepare($dbh, $sql_delete);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($dbh));
}

mysqli_stmt_bind_param($stmt, "i", $id_to_delete);

if (mysqli_stmt_execute($stmt)) {
    echo "Đã xóa dữ liệu thành công!<br>";
} else {
    echo "Lỗi xóa dữ liệu: " . mysqli_stmt_error($stmt) . "<br>";
}


$id_to_update = 4;
$name = "manh.uwu";
$gender = "bia đia";
$contact_no = "0234567891";
$email = "tmu22d192007@gmail.com";
$city = "Hà Tey";
$country = "Việt Nam";

$sql_update = "UPDATE my_contacts SET full_names = ?, gender = ?, contact_no = ?, email = ?, city = ?, country = ? WHERE id = ?";

$stmt = mysqli_prepare($dbh, $sql_update);
if (!$stmt) {
    die("Prepare failed: " . mysqli_error($dbh));
}

mysqli_stmt_bind_param($stmt, "ssssssi", $name, $gender, $contact_no, $email, $city, $country, $id_to_update);

if (mysqli_stmt_execute($stmt)) {
    echo "Đã cập nhật dữ liệu thành công!<br>";
} else {
    echo "Lỗi cập nhật dữ liệu: " . mysqli_stmt_error($stmt) . "<br>";
}

mysqli_stmt_close($stmt);
mysqli_close($dbh);


$conn = new PDO("mysql:host=localhost;dbname=in4", "root", "123456");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$name = "mai anh";
$gender = "nam";
$contact_no = "0123456789";
$email = "manhuwu@gmail.com";
$city = "Quảng Ninh";
$country = "Vietnam";

$stmt = $conn->prepare('INSERT INTO my_contacts (full_names, gender, contact_no, email, city, country) VALUES (?, ?, ?, ?, ?, ?)');

$stmt->execute([$name, $gender, $contact_no, $email, $city, $country]);
$stmt->bindParam(1,$name);
$stmt->bindParam(2,$gender);
$stmt->bindParam(3,$contact_no);
$stmt->bindParam(4,$email);
$stmt->bindParam(5,$city);
$stmt->bindParam(6,$country);


$stmt_fetch = $conn->prepare('SELECT * from my_contacts');

$stmt_fetch->setFetchMode(PDO::FETCH_ASSOC);
$stmt_fetch->execute(array());

$stmt = $conn->prepare('DELETE FROM my_contacts WHERE ID = ?');
$id = 2;
$stmt->execute([$id]);

$id = 3;
$name = "manh.uwu";
$email = "manh.uwu@gmail.com";
$city = "Hải Phòng";

$stmt = $conn->prepare('UPDATE my_contacts SET full_names = ?, email = ?, city = ? WHERE id = ?');

$stmt->execute([$name, $email, $city, $id]);
while($row = $stmt_fetch->fetch()) {
    echo 'ID: ' . $row['id'] . '<br>';
    echo 'Full Names: ' . $row['full_names'] . '<br>';
    echo 'Gender: ' . $row['gender'] . '<br>';
    echo 'Contact No: ' . $row['contact_no'] . '<br>';
    echo 'Email: ' . $row['email'] . '<br>';
    echo 'City: ' . $row['city'] . '<br>';
    echo 'Country: ' . $row['country'] . '<br><br>';
}

mysqli_close($dbh);
?>

</body>
</html>