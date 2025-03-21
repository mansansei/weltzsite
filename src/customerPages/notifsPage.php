<?php

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];

    require_once 'weltz_dbconnect.php';

    $selectNotifsSQL = "SELECT notifName, notifMessage, statusID, createdAt FROM notifs_tbl WHERE userID = '$userID' ORDER BY notifID DESC";
    $result = $conn->query($selectNotifsSQL);
?>
    <div class="container mt-5">
        <h2 class="mb-4">Notifications</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $notifType = "alert-info"; // Default to info

                if ($row['notifName'] == "Order Placed") {
                    $notifType = "alert-success";
                } elseif ($row['notifName'] == "Error") {
                    $notifType = "alert-danger";
                } elseif ($row['notifName'] == "Warning") {
                    $notifType = "alert-warning";
                }
        ?>
                <div class="alert <?php echo $notifType ?>" role="alert">
                    <div class="row">
                        <div class="col">
                            <h3><strong> <?php echo htmlspecialchars($row['notifName']) ?></strong></h3><h5><?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($row['createdAt']))); ?></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p><?php echo htmlspecialchars($row['notifMessage']) ?></p>
                        </div>
                        <div class="col text-end">
                            <button class="btn btn-primary">View</button>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="alert alert-secondary" role="alert">No notifications available.</div>';
        <?php
        }
        ?>
    </div>';
<?php
    $conn->close();
}
