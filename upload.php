<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}


require_once 'b_crud.php';


$crud = new crud();

$username = $_SESSION['username'];
$accountId = $crud->getAccountIdByUsername($username);

if ($accountId) {
    $files = $crud->readFile($accountId);
} else {
    $files = [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Document</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="script.js"></script>
</head>

<body>
    <nav>
        <a href="home.php">
            <h3>EmpowerEd</h3>
        </a>
    </nav>
    <div class="front">
        <h3 style="padding: 40px;">Upload File</h3>
        <form id="uploadForm" onsubmit="handleFileUpload(event)">
            <input type="file" name="document" class="form-control" required accept=".pdf">
            <br>
            <input type="text" name="title" id="title" placeholder="Title" required class="form-control">
            <button type="submit" class="btns-h">Submit</button>
        </form>
        <br>
        <h3 style="padding: 20px;">Uploaded Files by you</h3>
        <div style="padding:20px">
            <div class="table">
                <table id="userTable" class="display">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Preview</th>
                            <th>Contributor</th>
                            <th>Upload Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file): ?>
                            <tr id="fileRow<?php echo $file['material_id']; ?>">
                                <td><?php echo htmlspecialchars($file['title']); ?></td>
                                <td><a href="viewFile.php?material_id=<?php echo $file['material_id']; ?>">View</a></td>
                                <td><?php echo htmlspecialchars($file['contributor'] ?? 'Unknown'); ?></td>
                                <td><?php echo htmlspecialchars($file['upload_date'] ?? 'N/A'); ?></td>
                                <td>
                                    <a href="edit.php?material_id=<?php echo $file['material_id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteFile(<?php echo $file['material_id']; ?>)" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>