<?php
include 'dbcon.php';
session_start();

if (!isset($_SESSION['Username']) || !isset($_SESSION['Name']) || !isset($_SESSION['email'])) {
    header('location:index.php');
    exit();
}

$query = "SELECT `ID`, `Username`, `Name`, `Email` FROM `users` WHERE `Email` = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    header('location:index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['EditProfile'])) {
    $Fusername = trim($_POST['Fusername'] ?? '');
    $Fname = trim($_POST['Fname'] ?? '');
    $Femail = trim($_POST['Femail'] ?? '');

    if ($Fusername === '' || $Fname === '' || !filter_var($Femail, FILTER_VALIDATE_EMAIL)) {
        header('location:header.php?profile_error=1');
        exit();
    }

    $updateQuery = "UPDATE `users` SET `Username` = ?, `Name` = ?, `Email` = ? WHERE `ID` = ?";
    $updateStmt = mysqli_prepare($connection, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "sssi", $Fusername, $Fname, $Femail, $row['ID']);

    if (!mysqli_stmt_execute($updateStmt)) {
        die("Update failed: " . mysqli_stmt_error($updateStmt));
    }

    $_SESSION['Username'] = $Fusername;
    $_SESSION['Name'] = $Fname;
    $_SESSION['email'] = $Femail;

    header('location:dashboard.php#?profile_updated=1');
    exit();
}

$username = $row['Username'];
$name = $row['Name'];
$email = $row['Email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="titlestyle.css">
</head>

<body>


    <aside style="grid-area: bar1">
        <div class="main titleside">
            <h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-graduation-cap preview-icon">
                    <path
                        d="M21.42 10.922a1 1 0 0 0-.019-1.838L12.83 5.18a2 2 0 0 0-1.66 0L2.6 9.08a1 1 0 0 0 0 1.832l8.57 3.908a2 2 0 0 0 1.66 0z" />
                    <path d="M22 10v6" />
                    <path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5" />
                </svg>&nbsp;CRUD OPERATION</h2>
        </div>
        <div class="navBar">
            <ul class="navLinks">

                <li id="StudentRecords" onclick="Records()"><a href="#" onclick="Records()" id="RecordText"><svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path
                                d="M96 192C96 130.1 146.1 80 208 80C269.9 80 320 130.1 320 192C320 253.9 269.9 304 208 304C146.1 304 96 253.9 96 192zM32 528C32 430.8 110.8 352 208 352C305.2 352 384 430.8 384 528L384 534C384 557.2 365.2 576 342 576L74 576C50.8 576 32 557.2 32 534L32 528zM464 128C517 128 560 171 560 224C560 277 517 320 464 320C411 320 368 277 368 224C368 171 411 128 464 128zM464 368C543.5 368 608 432.5 608 512L608 534.4C608 557.4 589.4 576 566.4 576L421.6 576C428.2 563.5 432 549.2 432 534L432 528C432 476.5 414.6 429.1 385.5 391.3C408.1 376.6 435.1 368 464 368z" />
                        </svg>
                        &nbsp;Student Records</a></li>
                <li id="Profile" onclick="Profiles()"><a href="#" onclick="Profiles()" id="ProfileText"><svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                            <path
                                d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z" />
                        </svg>
                        &nbsp;Profile</a></li>
            </ul>
        </div>

        <form action="logout.php" method="post" class="LogoutBox">

            <button type="submit" name="logout" class="btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"
                    fill="currentColor" class="size-4">
                    <path fill-rule="evenodd"
                        d="M14 4.75A2.75 2.75 0 0 0 11.25 2h-3A2.75 2.75 0 0 0 5.5 4.75v.5a.75.75 0 0 0 1.5 0v-.5c0-.69.56-1.25 1.25-1.25h3c.69 0 1.25.56 1.25 1.25v6.5c0 .69-.56 1.25-1.25 1.25h-3c-.69 0-1.25-.56-1.25-1.25v-.5a.75.75 0 0 0-1.5 0v.5A2.75 2.75 0 0 0 8.25 14h3A2.75 2.75 0 0 0 14 11.25v-6.5Zm-9.47.47a.75.75 0 0 0-1.06 0L1.22 7.47a.75.75 0 0 0 0 1.06l2.25 2.25a.75.75 0 1 0 1.06-1.06l-.97-.97h7.19a.75.75 0 0 0 0-1.5H3.56l.97-.97a.75.75 0 0 0 0-1.06Z"
                        clip-rule="evenodd" />
                </svg>&nbsp;Log out</button>
        </form>

    </aside>
    <div class="barUpper" style="grid-area: bar2">
        <h3 class="main title1">Welcome, <span><?php echo htmlspecialchars($username); ?></span></h3>
    </div>


    <div id="ProfilePage" style="grid-area: bar3">

        <div class="profileCard">

            <div class="upperProfile">
                <div class="profileBox">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <div class="profileUppertext">
                    <span>Profile</span>
                    <h1><?php echo htmlspecialchars($username); ?></h1>
                    <p class="profileText"><?php echo htmlspecialchars($name); ?></p>
                </div>
            </div>

            <div class="formProfile">

                <div class="formTitle">
                    <span>
                        Personal Information
                    </span>
                </div>
                <form id="profileForm" action="header.php" method="post">
                    <div class="divForms">
                        <div class="profileIcons">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>

                        <div class="pofileInfo">
                            <label for="Fusername">Username</label>
                            <p class="profileText"><?php echo htmlspecialchars($username); ?></p>
                            <input type="text" name="Fusername" id="Fusername" class="fields d-none"
                                value="<?php echo htmlspecialchars($username); ?>" required>
                        </div>
                    </div>
                    <div class="divForms">
                        <div class="profileIcons">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </div>

                        <div class="pofileInfo">
                            <label for="Fname">Full name</label>
                            <p class="profileText"><?php echo htmlspecialchars($name); ?></p>
                            <input type="text" name="Fname" id="Fname" class="fields d-none"
                                value="<?php echo htmlspecialchars($name); ?>" required>
                        </div>
                    </div>
                    <div class="divForms">
                        <div class="profileIcons">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>

                        <div class="pofileInfo">
                            <label for="Email">Email address</label>
                            <p class="profileText"><?php echo htmlspecialchars($email); ?></p>
                            <input type="email" name="Femail" id="Femail" class="fields d-none"
                                value="<?php echo htmlspecialchars($email); ?>" required>
                        </div>
                    </div>
                    <div class="footerButtonBox">
                        <button type="button" id="editProfile">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                            Edit profile
                        </button>
                        <button type="submit" name="EditProfile" id="saveProfile" class="d-none" style="margin-right: 1rem;">Save changes</button>
                        <button type="button" id="cancelEdit" class="d-none">Cancel</button>
                    </div>
                </form>
                <script>

                    const editProfile = document.getElementById('editProfile');
                    const saveProfile = document.getElementById('saveProfile');
                    const cancelEdit = document.getElementById('cancelEdit');
                    const profileForm = document.getElementById('profileForm');

                    function toggleProfileEdit(isEditing) {
                        profileForm.querySelectorAll('.profileText').forEach(function (paragraph) {
                            paragraph.classList.toggle('d-none', isEditing);
                        });
                        profileForm.querySelectorAll('.fields').forEach(function (input) {
                            input.classList.toggle('d-none', !isEditing);
                        });
                        editProfile.classList.toggle('d-none', isEditing);
                        saveProfile.classList.toggle('d-none', !isEditing);
                        cancelEdit.classList.toggle('d-none', !isEditing);
                    }

                    editProfile.addEventListener('click', function () {
                        toggleProfileEdit(true);
                    });
                    cancelEdit.addEventListener('click', function () {
                        profileForm.reset();
                        toggleProfileEdit(false);
                    });

                </script>
            </div>








        </div>






    </div>






    <div class="container" id="contentCon" style="grid-area: bar3">
        <div class="AheaderWithASVG">
            <svg xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 640 640"><!--!Font Awesome Free v7.3.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.-->
                <path
                    d="M320 80C377.4 80 424 126.6 424 184C424 241.4 377.4 288 320 288C262.6 288 216 241.4 216 184C216 126.6 262.6 80 320 80zM96 152C135.8 152 168 184.2 168 224C168 263.8 135.8 296 96 296C56.2 296 24 263.8 24 224C24 184.2 56.2 152 96 152zM0 480C0 409.3 57.3 352 128 352C140.8 352 153.2 353.9 164.9 357.4C132 394.2 112 442.8 112 496L112 512C112 523.4 114.4 534.2 118.7 544L32 544C14.3 544 0 529.7 0 512L0 480zM521.3 544C525.6 534.2 528 523.4 528 512L528 496C528 442.8 508 394.2 475.1 357.4C486.8 353.9 499.2 352 512 352C582.7 352 640 409.3 640 480L640 512C640 529.7 625.7 544 608 544L521.3 544zM472 224C472 184.2 504.2 152 544 152C583.8 152 616 184.2 616 224C616 263.8 583.8 296 544 296C504.2 296 472 263.8 472 224zM160 496C160 407.6 231.6 336 320 336C408.4 336 480 407.6 480 496L480 512C480 529.7 465.7 544 448 544L192 544C174.3 544 160 529.7 160 512L160 496z" />
            </svg>
            <div class="textBox">
                <h1>Student <span class="Haccent">CRUD</span> System</span></h1>
                <p>Manage your student records with ease.</p>
            </div>

        </div>
        <div class="contentCard">