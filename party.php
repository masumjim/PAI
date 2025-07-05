<?php
// Include configuration and header
require_once 'header.php';

// Handle delete action
if (isset($_GET['delete'])) {
    $code = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM parties WHERE code = ?");
    $stmt->bind_param("i", $code);
    if ($stmt->execute()) {
        echo "<script>alert('Party deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting party');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Party Management</h2>
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="add_party.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Party
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="partiesTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Proprietor</th>
                                <th>Cell</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM parties ORDER BY created_at DESC";
                            $result = $conn->query($query);
                            
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['code']}</td>
                                            <td>{$row['name']}</td>
                                            <td>{$row['proprietor']}</td>
                                            <td>{$row['cell']}</td>
                                            <td>{$row['area']}</td>
                                            <td><span class='badge " . ($row['status'] == 'Active' ? 'bg-success' : 'bg-secondary') . "'>{$row['status']}</span></td>
                                            <td>
                                                <a href='edit_party.php?code={$row['code']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                                                <a href='party.php?delete={$row['code']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this party?\")'><i class='fas fa-trash'></i></a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No parties found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
require_once 'footer.php';
?>