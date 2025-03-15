<?php
require_once 'weltz_dbconnect.php';

$logsSQL = "SELECT * FROM audit_logs";

$logsSQLResult = $conn->query($logsSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <h1>Audit Logs Table</h1>
</div>

<div class="container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Update ID</th>
                <th>User</th>
                <th>Action Type</th>
                <th>Table Name</th>
                <th>Record ID</th>
                <th>Old Value</th>
                <th>New Value</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($logsSQLResult->num_rows > 0) {
                while ($row = $logsSQLResult->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['auditID'] ?></td>
                        <td><?php echo $row['userID'] ?></td>
                        <td><?php echo $row['actionType'] ?></td>
                        <td><?php echo $row['tableName'] ?></td>
                        <td><?php echo $row['recordID'] ?></td>
                        <td><?php echo $row['oldValues'] ?></td>
                        <td><?php echo $row['newValues'] ?></td>
                        <td><?php echo $row['updatedAt'] ?></td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <h1 class="text-center">No updates found</h1>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
?>