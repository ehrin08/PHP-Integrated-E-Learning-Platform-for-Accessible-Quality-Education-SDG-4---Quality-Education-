<?php
include_once 'dbConnection.php';  // Include the database connection class
include_once 'b-crud.php';  // Include the CRUD class

// Create a new database connection
$database = new databaseConn();
$db = $database->connect();

if (!isset($_GET['material_id']) || empty($_GET['material_id'])) {
    header("Location: upload.php?error=missing_id");
    exit;
}

$material_id = (int)$_GET['material_id'];  // Ensure material_id is an integer
$crud = new Crud($db);

// Fetch the current file details (excluding the BLOB content if not needed)
$file = $crud->getFile($material_id);

if (!$file) {
    header("Location: upload.php?error=file_not_found");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Uploaded File</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav>
        <h3>EmpowerEd</h3>
    </nav>
    <div class="container">
        <h3 class="text-center mt-5 mb-1">Edit Uploaded File</h3>
        <p class="text-center mt-1 mb-4">Click update after changing any information.</p>
        <form action="b-edit.php?material_id=<?php echo $material_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control" 
                    value="<?php echo htmlspecialchars($file['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="document">Replace File (optional):</label>
                <input type="file" name="document" id="document" class="form-control" accept=".pdf">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="upload.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
