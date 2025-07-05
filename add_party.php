<?php
require_once 'header.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $proprietor = $_POST['proprietor'];
    $cell = $_POST['cell'];
    $area = $_POST['area'];
    $status = $_POST['status'];
    $created_by = $_SESSION['username'] ?? 'system'; // Assuming you have session for logged in user

    $stmt = $conn->prepare("INSERT INTO parties (code, name, address, proprietor, cell, area, status, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssisss", $code, $name, $address, $proprietor, $cell, $area, $status, $created_by);

    if ($stmt->execute()) {
        echo "<script>alert('Party added successfully'); window.location.href='party.php';</script>";
    } else {
        echo "<script>alert('Error adding party');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Party</h4>
                </div>
                <div class="card-body">
                    <form action="add_party.php" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="code" class="form-label">Party Code</label>
                                <input type="number" class="form-control" id="code" name="code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Party Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="proprietor" class="form-label">Proprietor</label>
                                <input type="text" class="form-control" id="proprietor" name="proprietor" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cell" class="form-label">Cell Number</label>
                                <input type="number" class="form-control" id="cell" name="cell" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" class="form-control" id="area" name="area" required>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="party.php" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Party</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>