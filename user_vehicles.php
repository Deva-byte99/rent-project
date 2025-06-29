<?php
include "db_connection.php";

$sql = "SELECT * FROM vehicles";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Vehicles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Available Vehicles</h2>
    <div class="row" >
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4">
                <div class="card" >
                    <img src="<?php echo $row['image']; ?>"  class="card-img-top" alt="Vehicle Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <p class="card-text">Price: ₹<?php echo $row['price']; ?></p>
                        <a  href="rent_form.html"<?php echo $row['id']; ?>  class="btn btn-primary">Rent Now</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
