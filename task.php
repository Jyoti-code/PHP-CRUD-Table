<!doctype html>
<html lang="en">

<head>
    <title>Task-1</title>
    <?php include("link.php") ?>
</head>

<body>
    <div class="content-wrap">
        <div class="main">
            <div class="container-xxl">
                <!--Form Start-->
                <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-8 p-r-0 title-margin-right m-1">
                            <div class="page-header">
                                <div class="page-title">
                                    <h1>Customer-product</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section id="main-content" style="background-color: #fff;">
                        <div class="row">
                            <div class="col-md-12">
                                <table width="100%" class="table table-striped" border="1">
                                    <tr>
                                        <td width="9%"><label class="control-label" style="margin-top: 10px;">Customer
                                                Name</label></td>
                                        <td width="15%" colspan="3">
                                            <input type="text" class="form-control" name="name" placeholder="Customer name">
                                        </td>
                                        <td width="9%"><label class="control-label" style="margin-top: 10px;">MOB
                                                No.</label></td>
                                        <td colspan="3">
                                            <input type="tel" placeholder="Phone number" name="phone" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="10%">Model</td>
                                        <td width="14%">Description of Goods</td>
                                        <td width="12%">Brand</td>
                                        <td width="15%">Picture</td>
                                        <td width="9%">Price</td>
                                        <td width="9%">Qty</td>
                                        <td width="12%">GST Value</td>
                                        <td width="13%">Total </td>
                                    </tr>
                                    <tr>
                                        <td width="18%">
                                            <select class="form-control" name="model[]">
                                                <option value="Select">Select</option>
                                                <option value="p1">p1</option>
                                                <option value="p2">p2</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="description[]" class="form-control"></span></td>
                                        <td><input type="text" name="brand[]" class="form-control"></td>
                                        <td><input type="file" name="picture[]" class="form-control"></td>
                                        <td><input type="text" name="price[]" class="form-control"></td>
                                        <td><input type="number" name="quantity[]" class="form-control"></td>
                                        <td><select class="form-control" name="gst[]">
                                                <option value="Included">Included</option>
                                                <option value="Excluded">Excluded</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="total[]" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" style="text-align:left;"><button type="submit"
                                                class="btn btn-success" name="submit">Submit</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            </form>
            <section id="main-content" style="background-color: #fff;">
                <div class="container-xxl col-md-12">
                    <div class="row">
                    <h1>List</h1>
                        <table width="100%" class="table table-striped" border="1">
                            <tr>
                                <td width="10%">Model</td>
                                <td width="14%">Description</td>
                                <td width="12%">Brand</td>
                                <td width="15%">Picture</td>
                                <td width="9%">Price</td>
                                <td width="9%">Qty</td>
                                <td width="12%">GST Value</td>
                                <td width="13%">Total </td>
                                <td width="13%">Action </td>
                            </tr>

                            <?php
                                include('connection_db.php');
                                $query= "SELECT * FROM crudoperation";
                                $query_run=mysqli_query($con,$query);
                                if (mysqli_num_rows($query_run) > 0) {
                                    // Fetch data and display in a table
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['model'] . "</td>";
                                        echo "<td>" . $row['description'] . "</td>";
                                        echo "<td>" . $row['brand'] . "</td>";
                                        echo "<td><img src='" . $row['picture'] . "' alt='Product Image' style='max-width: 100px;'></td>";
                                        echo "<td>" . $row['price'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "<td>" . $row['gst'] . "</td>";
                                        echo "<td>" . $row['total'] . "</td>";
                                        echo "<td>
                                        <a href='process_edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                        <a href='?action=delete&id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                                      </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    // Display a message if there are no rows
                                    echo "<tr><td colspan='8'>No data available</td></tr>";
                                }

                            ?>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    </div>
</body>

</html>

<?php
include('connection_db.php');

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM crudoperation WHERE id = $id";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        echo "<script>alert('Data deleted successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete data');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($_POST['model'] as $key => $model) {
        $description = $_POST['description'][$key];
        $brand = $_POST['brand'][$key];
        
        if (isset($_FILES['picture']['name'][$key])) {
            // Handle file upload
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . basename($_FILES["picture"]["name"][$key]);
            move_uploaded_file($_FILES["picture"]["tmp_name"][$key], $targetFile);
        } else {
            $targetFile = ""; 
        }

        $price = $_POST['price'][$key];
        $quantity = $_POST['quantity'][$key];
        $gst = $_POST['gst'][$key];
        $total = $_POST['total'][$key];

        // Insert data into the database
        $sql = "INSERT INTO crudoperation (model, description, brand, picture, price, quantity, gst, total) VALUES ('$model', '$description', '$brand', '$targetFile', '$price', '$quantity', '$gst', '$total')";

        $res = mysqli_query($con, $sql);

        if ($res) {
            ?>
            <script>
                alert("Data inserted");
            </script>
            <?php
        }
        else{
            echo 'no connection';
        }
    }
}
?>



