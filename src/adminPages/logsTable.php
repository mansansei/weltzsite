<?php
require_once 'weltz_dbconnect.php';

$logsSQL = "SELECT * FROM update_logs_tbl";

$logsSQLResult = $conn->query($logsSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <h1>Update Logs Table</h1>
</div>

<div class="container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Update ID</th>
                <th>Table Name</th>
                <th>ID of Updated Data</th>
                <th>Column Name</th>
                <th>Old Value</th>
                <th>New Value</th>
                <th>Changed by</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($logsSQLResult->num_rows > 0) {
                while ($row = $logsSQLResult->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['updID'] ?></td>
                        <td><?php echo $row['updTblName'] ?></td>
                        <td><?php echo $row['updRecordID'] ?></td>
                        <td><?php echo $row['updColName'] ?></td>
                        <td><?php echo $row['updOldValue'] ?></td>
                        <td><?php echo $row['updNewValue'] ?></td>
                        <td><?php echo $row['userID'] ?></td>
                        <td><?php echo $row['updatedAt'] ?></td>
                        <td>
                            <div class='d-grid gap-2'>
                                <button class='btn btn-warning'>Edit</button>
                                <button class='btn btn-danger'>Delete</button>
                            </div>
                        </td>
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