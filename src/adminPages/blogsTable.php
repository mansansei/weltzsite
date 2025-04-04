<?php
require_once 'weltz_dbconnect.php';

$blogsSQL =
    "SELECT
        b.blogID, 
        CONCAT(u.userFname, ' ', u.userLname) AS userFullName, 
        b.blogIMG, 
        b.blogTitle, 
        b.blogDesc, 
        b.createdAt, 
        b.updatedAt 
    FROM 
        blogs_tbl b 
    JOIN 
        users_tbl u ON b.userID = u.userID 
    ";

$blogsSQLResult = $conn->query($blogsSQL);
?>

<div class="userTableHeader mb-3 d-flex justify-content-end align-items-center gap-3">
    <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#addNewBlogModal">
        <i class="fa-solid fa-scroll"></i> Post a New Blog
    </button>
    <h1>Blogs Table</h1>
</div>

<div class="table-container container-fluid bg-light p-5 rounded shadow">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Blog ID</th>
                <th>Posted By</th>
                <th>Image</th>
                <th>Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($blogsSQLResult->num_rows > 0) {
                while ($row = $blogsSQLResult->fetch_assoc()) {
            ?>
                    <tr>
                        <td><?php echo $row['blogID'] ?></td>
                        <td><?php echo $row['userFullName'] ?></td>
                        <td><img src="<?php echo $row['blogIMG'] ?>" alt="<?php echo $row['blogTitle'] ?>" style="width:100px"></td>
                        <td><?php echo $row['blogTitle'] ?></td>
                        <td><?php echo $row['blogDesc'] ?></td>
                        <td><?php echo  $row['createdAt'] ?></td>
                        <td><?php echo  $row['updatedAt'] ?></td>
                        <td>
                            <div class='d-grid gap-2'>
                                <button class='btn btn-warning' data-bs-toggle="modal" data-bs-target="#editBlogModal">Edit</button>
                                <button class='btn btn-danger' data-bs-toggle="modal" data-bs-target="#deleteBlogModal">Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <h1 class="text-center">No blogs found</h1>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$conn->close();
?>