<?php
require_once 'header.php';

// Fetch party data for editing
$code = $_GET['code'] ?? null;
$party = null;

if ($code) {
    $stmt = $conn->prepare("SELECT * FROM parties WHERE code = ?");
    $stmt->bind_param("i", $code);
    $stmt->execute();
    $result = $stmt->get_result();
    $party = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $proprietor = $_POST['proprietor'];
    $cell = $_POST['cell'];
    $area = $_POST['area'];
    $status = $_POST['status'];

    // Corrected bind_param - removed the extra 's' and matched the parameters
    $stmt = $conn->prepare("UPDATE parties SET name=?, address=?, proprietor=?, cell=?, area=?, status=?, updated_at=NOW() WHERE code=?");
    $stmt->bind_param("sssisss", $name, $address, $proprietor, $cell, $area, $status, $code);

    if ($stmt->execute()) {
        echo "<script>alert('Party updated successfully'); window.location.href='party.php';</script>";
    } else {
        echo "<script>alert('Error updating party');</script>";
    }
}

if (!$party) {
    echo "<script>alert('Party not found'); window.location.href='party.php';</script>";
    exit();
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Party</h4>
                </div>
                <div class="card-body">
                    <form action="edit_party.php" method="POST">
                        <input type="hidden" name="code" value="<?php echo $party['code']; ?>">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="code" class="form-label">Party Code</label>
                                <input type="number" class="form-control" id="code" name="code" value="<?php echo $party['code']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Party Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $party['name']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $party['address']; ?></textarea>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="proprietor" class="form-label">Proprietor</label>
                                <input type="text" class="form-control" id="proprietor" name="proprietor" value="<?php echo $party['proprietor']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="cell" class="form-label">Cell Number</label>
                                <input type="number" class="form-control" id="cell" name="cell" value="<?php echo $party['cell']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="area" class="form-label">Area</label>
                                <input type="text" class="form-control" id="area" name="area" value="<?php echo $party['area']; ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" <?php echo $party['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo $party['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="party.php" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Party</button>
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