<?php

// include($_SERVER['DOCUMENT_ROOT'] . '/GenralFunction/UploadImage.php');

session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: /Login/Login.php");
    exit();
}
// Include the script to display profile and questions
include $_SERVER['DOCUMENT_ROOT'] . '/Profile/DisplayProfileAndQuestion.php';
?>

<html>
    <head>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <link rel="stylesheet" href="/Css/Home.css">
      <style>
        .card-container {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .card {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            width: calc(50% - 20px); /* Thêm phần tử trừ cho padding */
        }
        @media (max-width: 768px) {
            .card-container {
                flex-direction: column;
            }
            .card {
                width: 100%;
                margin-bottom: 20px; /* Thêm margin dưới cho card */
            }
        }
        .image-gallery {
            text-align:center;
        }
        .image-gallery img {
            padding: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
            border: 1px solid #FFFFFF;
            border-radius: 4px;
            margin: 20px;
        }
    </style>
    </head>
    <body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/Home/Home.php">Greenwich Of University</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/Home/Home.php">Home</a>
                        </li>
                        <li class="nav-item  dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">
                                    account_circle
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                            <?php
                                // Kiểm tra xem người dùng đã đăng nhập hay chưa
                                if (isset($_SESSION['username'])) {
                                    // Nếu đã đăng nhập, hiển thị tên người dùng
                                    echo '<li><a class="dropdown-item" href="/Profile/ProfilePage.php">' . $_SESSION['username'] . '</a></li>';
                                } else {
                                    // Nếu chưa đăng nhập, hiển thị chữ "Profile"
                                    echo '<li><a class="dropdown-item" href="#">Profile</a></li>';
                                }
                            ?>
                                <li><a class="dropdown-item" href="/Message/Message.php">Send Messenger to Admin</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php
                                     // Kiểm tra xem người dùng đã đăng nhập hay chưa
                                    if (isset($_SESSION['user_id'])) {
                                        // Nếu đã đăng nhập, hiển thị nút Logout
                                        echo '<li><a class = "dropdown-item" href="/Login/Logout.php" class="nav-link">Logout</a></li>';
                                    } else {
                                        // Nếu chưa đăng nhập, hiển thị nút Login
                                        echo '<li><a class = "dropdown-item" href="/Login/Login.php" class="nav-link">Login</a></li>';
                                    }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/AdminSite/AdminHome.php">Admin Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!-- profile Name-->
        <div class="container">
            <div class="card-container">
                <!-- Left Card - Profile Image -->
                <div class="card">
                    <div class="card-body">
                        <div class="image-gallery">
                            <!-- Profile Image -->
                            <?php
                            include $_SERVER['DOCUMENT_ROOT'] . '/GenralFunction/DisplayAvatar.php';
                            // Check if $row is set
                            echo '<img src='.$Avatar.' style="width: 200px; height: 200px;">';
                            ?>
                        </div>
                        <!-- Upload form -->
                        <form action="/GenralFunction/UploadAvatar.php" method="post" enctype="multipart/form-data">
                                <label for="uploadImage" class="btn btn-outline-primary">
                                    <i class="fas fa-upload"></i> Upload Image
                                </label>
                                <input type="file" id="uploadImage" name="image" style="display: none;">
                                <!-- Hidden input fields for database connection details -->
                                <input type="hidden" name="dbHost" id="dbHost" value='localhost'>
                                <input type="hidden" name="dbName" id="dbName" value='coursework'>
                                <input type="hidden" name="dbUsername" id="dbUsername" value='root'>
                                <input type="hidden" name="dbPassword" id="dbPassword" value=''>
                                <!-- Specify the correct table name -->
                                <input type="hidden" name="tableName" id="tableName" value='user'>
                                <!-- Specify the correct avatar field name -->
                                <input type="hidden" name="avatarField" id="avatarField" value='Avatar'>
                                <input type="hidden" name="redirectLocation" value="/Profile/ProfilePage.php">

                                <!-- Hidden input fields for condition clause if needed -->
                                <input type="hidden" name="conditionField" id="conditionField" value='ID'>
                                <input type="hidden" name="conditionValue" id="conditionValue" value='<?php echo $question_id; ?>'> <!-- Assuming you have $question_id available -->
                                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
                <!-- Right Card - Profile Information -->
                <div class="card">
                    <div class="card-body">
                        <?php if (isset($profileData) && !empty($profileData)): ?>
                            <!-- Display user profile information -->
                            <h5 class="card-title"><?php echo $profileData['UserName']; ?></h5>
                            <!-- Display other profile information here -->

                            <p class="card-text">Your Questions:</p>

                            <!-- Display list of questions -->
                            <ul>
                                <?php foreach ($questions as $question): ?>
                                    <li><?php echo $question['QuestionName']; ?></li>
                                    <!-- Display other question details here -->
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <!-- Handle the case where no profile data is found -->
                            <p>No profile data found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal for updating question -->
    <div class="modal fade" id="updateQuestionModal" tabindex="-1" aria-labelledby="updateQuestionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateQuestionModalLabel">Update Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateQuestionForm" action="EditQuestion.php" method="post">
                        <input type="hidden" name="question_id" id="questionIdField">
                        <div class="mb-3">
                            <label for="updatedQuestion" class="form-label">Updated Question Title</label>
                            <input type="text" class="form-control" id="updatedQuestion" name="question_name">
                        </div>
                        <!-- New input field for the detail -->
                        <div class="mb-3">
                            <label for="updatedDetail" class="form-label">Updated Details</label>
                            <textarea class="form-control" id="updatedDetail" name="question_detail" rows="3"></textarea>
                        </div>
                        <button type="submit" name="update_question" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- User's Question -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Questions</h5>
                <?php if (isset($questions) && !empty($questions)): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Number of Question</th>
                                <th>Question Name</th>
                                <th>Question Details</th>
                                <th>Delete</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $index => $question): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><a href="/QuestionPage/QuestionPage.php?id=<?php echo $question['ID']; ?>" class="link"><?php echo $question['QuestionName']; ?></a></td> <!-- Link to the separate question page -->
                                    <td><?php echo $question['QuestionDetail']; ?></td>
                                    <td>
                                        <!-- Form to delete the question -->
                                        <form action="DeleteQuestion.php" method="post">
                                            <input type="hidden" name="question_id" value='<?php echo $question['ID']; ?>'>
                                            <button type="submit" name="delete_question" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                    <td>
                                        <!-- Button to open the update modal -->
                                        <button class="btn btn-primary" onclick="openUpdateModal(<?php echo $question['ID']; ?>, '<?php echo $question['QuestionName']; ?>', '<?php echo $question['QuestionDetail']; ?>')">Update</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No questions found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!--Notifications Card -->
       <?php 
        include('DisplayMessage.php')
        ?> 
   <!-- Table to display notifications -->
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Notifications</h5>
                    <?php if (isset($notifications) && !empty($notifications)): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Reply</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($notifications as $notification): ?>
                                    <tr>
                                        <td><?php echo $notification['Title']; ?></td>
                                        <td><?php echo $notification['Detail']; ?></td>
                                        <td><?php echo $notification['Reply']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No notifications found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
   <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Function to set the question ID and display the modal
        function openUpdateModal(questionId, currentQuestion, currentDetail) {
            document.getElementById('questionIdField').value = questionId;
            document.getElementById('updatedQuestion').value = currentQuestion;
            document.getElementById('updatedDetail').value = currentDetail; // Populate the detail field
            $('#updateQuestionModal').modal('show'); // Show the modal
        }
    </script>
</body>
</html>