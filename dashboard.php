<?php include 'header.php'; ?>
<?php include 'users.php'; ?>



<div class="container mt-4" id="innerCon">
    <div class="d-flex justify-content-between align-items-center mb-3" id="labelCon">

        <h2 class="main title2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-square-text preview-icon">
                <rect width="18" height="18" x="3" y="3" rx="2" />
                <path d="M7 8h8" />
                <path d="M7 12h10" />
                <path d="M7 16h6" />
            </svg>&nbsp;Manage Records</h2>
        <form action="" method="GET">
            <button name="findName" type="submit" id="Searching"><svg xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                    <path
                        d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z" />
                </svg></button>
            <input type="text" name="SearchedName" value="<?php if(isset($_GET['SearchedName'])){echo $_GET['SearchedName'];}?>" id="search" placeholder="Search a record">

        </form>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">ADD STUDENTS</button>
    </div>
</div>






<table id="table1" class="table table-dark table-hover table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>
                <center>Update</center>
            </th>
            <th>
                <center>Delete</center>
            </th>
        </tr>

    </thead>
    <tbody>
        <?php

$records_per_page = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $records_per_page;


$search_query_param = isset($_GET['SearchedName']) ? trim($_GET['SearchedName']) : '';

if (!empty($search_query_param)) {

    $Findname = mysqli_real_escape_string($connection, $search_query_param);
    

    $query = "SELECT * FROM students WHERE CONCAT(First_Name, ' ', Last_Name) LIKE '%$Findname%'";
} else {

    $count_query = "SELECT COUNT(*) AS total FROM students";
    $count_result = mysqli_query($connection, $count_query);
    $count_row = mysqli_fetch_assoc($count_result);
    $total_records = $count_row['total'];
    $total_pages = ceil($total_records / $records_per_page);


    $query = "SELECT * FROM students LIMIT $offset, $records_per_page";
}


$result = mysqli_query($connection, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($connection));
}


if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) { 

        $modal_id = "deleteModal_" . $row['id'];
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id']); ?></td>
            <td><?php echo htmlspecialchars($row['First_Name']); ?></td>
            <td><?php echo htmlspecialchars($row['Last_Name']); ?></td>
            <td><?php echo htmlspecialchars($row['Age']); ?></td>
            <td>
                <center>
                    <a id="UpdateBtn" href="update_page_1.php?id=<?php echo $row['id']; ?>" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil preview-icon"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                        Update
                    </a>
                </center>
            </td>
            <td>
                <center>
                    <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#<?php echo $modal_id; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash preview-icon"><path d="M10 11v6"/><path d="M14 11v6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        Delete
                    </a>
                </center>
            </td>
        </tr>


        <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="<?php echo $modal_id; ?>Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?php echo $modal_id; ?>Label">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h2>Do you want to delete this record?</h2>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <a href="delete_page.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Yes</a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
} else { ?>
    <tr>
        <td colspan="6" class="text-center">No Records Found</td>
    </tr>
<?php } ?>

    </tbody>
</table>
<div class="footerContents" id="paginator">
    <nav class="mt-3" aria-label="Student records pages" id="RecordNav">
        <ul class="pagination justify-content-center">

            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page - 1 ?>">
                    Previous
                </a>
            </li>

            <?php for ($i = 1; $i <= $page; $i++): ?>
                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="?page=<?= $page + 1 ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>
    <div>
        <?php
        if (isset($_GET['message'])) {
            echo "<h6 class='Error' style='color: red; text-align: center;'>" . $_GET['message'] . "</h6>";
        }
        ?>

        <?php
        if (isset($_GET['insert_msg'])) {
            echo "<h6 class='Valid' style='color: green; text-align: center;'> " . $_GET['insert_msg'] . "</h6>";
        }
        ?>

        <?php
        if (isset($_GET['update_msg'])) {
            echo "<h6 class='Valid' style='color: green; text-align: center;'>" . $_GET['update_msg'] . "</h6>";
        }
        ?>

        <?php
        if (isset($_GET['delete_msg'])) {
            echo "<h6 class='Error' style='color: red; text-align: center;'>" . $_GET['delete_msg'] . "</h6>";
        }
        ?>
    </div>
</div>

<form action="insert_data.php" method="post">
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: white;">
                        Add Student
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="First_Name">First Name</label>
                        <input type="text" name="First_Name" id="First_Name" class="form-control">
                        <label for="Last_Name">Last Name</label>
                        <input type="text" name="Last_Name" id="Last_Name" class="form-control">
                        <label for="Age">Age</label>
                        <input type="number" name="Age" id="Age" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <input type="submit" class="btn btn-success" name="add_students" value="ADD">
                </div>
            </div>
        </div>
    </div>
</form>








<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>

<?php include 'footer.php'; ?>