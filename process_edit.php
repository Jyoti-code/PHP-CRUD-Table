<?php
include('connection_db.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = mysqli_real_escape_string($con, $_POST['editId']);
    $model = mysqli_real_escape_string($con, $_POST['editModel']);
    $description = mysqli_real_escape_string($con, $_POST['editDescription']);
    $brand = mysqli_real_escape_string($con, $_POST['editBrand']);

    // Check if the 'editPicture' index exists in the $_FILES array and a new file is uploaded
    if (isset($_FILES['editPicture']['name']) && $_FILES['editPicture']['name'] !== '') {
        // Handle file upload
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["editPicture"]["name"]);
        move_uploaded_file($_FILES["editPicture"]["tmp_name"], $targetFile);
        $picture = $targetFile;
    } else {
        // Keep the existing file path
        $picture = mysqli_real_escape_string($con, $_POST['existingPicture']);
    }

    $price = mysqli_real_escape_string($con, $_POST['editPrice']);
    $quantity = mysqli_real_escape_string($con, $_POST['editQty']);
    $gst = mysqli_real_escape_string($con, $_POST['editGst']);
    $total = mysqli_real_escape_string($con, $_POST['editTotal']);

    // Update data in the database
    $updateQuery = "UPDATE crudoperation SET model='$model', description='$description', brand='$brand', picture='$picture', price='$price', quantity='$quantity', gst='$gst', total='$total' WHERE id=$id";
    $updateResult = mysqli_query($con, $updateQuery);

    if (!$updateResult) {
        echo "Failed to update data";
    }
}

// Retrieve data for the specified ID
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $editQuery = "SELECT * FROM crudoperation WHERE id = '$id'";
    $editResult = mysqli_query($con, $editQuery);
    $editData = mysqli_fetch_assoc($editResult);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Data</title>
    <?php include("link.php") ?>
</head>

<body>
    <div class="content-wrap">
        <div class="main">
            <div class="container-xl">
                <div class="card">
                    <div class="card-header">
                        <h1>Edit Data</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="editModel">Model</label>
                                    <input type="text" id="editModel" class="form-control" name="editModel"
                                        value="<?php echo $editData['model']; ?>" required><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="editDescription">Description</label>
                                    <input type="text" id="editDescription" class="form-control" name="editDescription"
                                        value="<?php echo $editData['description']; ?>" required><br>
                                </div>
                            </div>

                            <label for="editBrand">Brand</label>
                            <input type="text" id="editBrand" class="form-control" name="editBrand"
                                value="<?php echo $editData['brand']; ?>" required><br>

                            <label for="editPicture">Picture</label>
                            <input type="file" id="editPicture" class="form-control" name="editPicture"><br>

                            <!-- Hidden input to retain existing file path -->
                            <input type="hidden" name="existingPicture" value="<?php echo $editData['picture']; ?>">

                            <label for="editPrice">Price</label>
                            <input type="text" id="editPrice" class="form-control" name="editPrice"
                                value="<?php echo $editData['price']; ?>" required><br>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="editQty">Quantity</label>
                                    <input type="number" id="editQty" class="form-control" name="editQty"
                                        value="<?php echo $editData['quantity']; ?>" required><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="editGst">GST Value</label>
                                    <input type="text" id="editGst" class="form-control" name="editGst"
                                        value="<?php echo $editData['gst']; ?>" required><br>
                                </div>
                            </div>
                            <label for="editTotal">Total</label>
                            <input type="text" id="editTotal" class="form-control" name="editTotal"
                                value="<?php echo $editData['total']; ?>" required><br>

                            <input type="hidden" id="editId" class="form-control" name="editId"
                                value="<?php echo $editData['id']; ?>">
                            <input type="submit" class="btn btn-primary" value="Update">
                            <a href="task.php" class="btn btn-primary">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>