<?php

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    require_once 'weltz_dbconnect.php';
?>

    <div class="container mt-5 vh-100">
        <div class="row mb-4 border-bottom border-danger">
            <div class="col-md-9">
                <h1 class="fs-1">Notifications</h1>
            </div>
        </div>
        <ul class="nav nav-tabs mb-3" id="notifTabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="unread-tab" data-bs-toggle="tab" href="#unread" role="tab">Unread</a></li>
            <li class="nav-item"><a class="nav-link" id="read-tab" data-bs-toggle="tab" href="#read" role="tab">Read</a></li>
        </ul>
        <div class="tab-content" id="notifTabsContent">
            <?php
            foreach ([9 => 'unread', 8 => 'read'] as $status => $tab) {
            ?>
                <div class="tab-pane fade <?php echo $status == 9 ? ' show active' : '' ?>" id="<?php echo $tab ?>" role="tabpanel">
                    <?php
                    $selectNotifsSQL = "SELECT notifID, notifName, notifMessage, notifType, createdAt FROM notifs_tbl WHERE userID = '$userID' AND statusID = '$status' ORDER BY notifID DESC";
                    $notifsSQLResult = $conn->query($selectNotifsSQL);

                    if ($notifsSQLResult->num_rows > 0) {
                        while ($row = $notifsSQLResult->fetch_assoc()) {
                    ?>
                            <div class="alert alert-secondary" role="alert">
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <strong><?php echo htmlspecialchars($row['notifName']) ?></strong> <?php echo htmlspecialchars($row['notifMessage']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <small><?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($row['createdAt']))) ?></small>
                                        </div>
                                    </div>
                                    <div class="col text-end">
                                        <a href="?page=userProfile&tab=userOrders" class="btn btn-primary view-notif" data-notif-id="<?php echo $row['notifID']; ?>">View</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-secondary" role="alert">No notifications available.</div>
                    <?php
                    }
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
<?php
    $conn->close();
}
