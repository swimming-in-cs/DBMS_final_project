<?php
// Enable error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$message = "";
// Initialize variables
$searchResults = '';
$isPost = $_SERVER["REQUEST_METHOD"] == "POST";

// 連接資料庫
try {
    $db = new mysqli("localhost:3307", "user", "", "final");

    // 檢查資料庫連接是否成功
    if ($db->connect_error) {
        throw new Exception("Connection failed: " . $db->connect_error);
    }

    // 確認是否有 POST 請求
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 取得輸入的名字
        $id = $_POST['id'];
        $name = $_POST['name'];
        $handPreference = $_POST['handPreference'];
        $height = $_POST['height'];
        $country = $_POST['country'];
        $age = $_POST['age'];
    
        // Prepare the SQL statement
        $sql = "INSERT INTO player 
                (player_id, player_name, player_hand, player_ht, player_ioc, player_age) 
                VALUES (?, ?, ?, ?, ?, ?)";
    
        // Prepare the statement
        $stmt = $db->prepare($sql);
    
        // Bind the parameters
        $stmt->bind_param("issisi", $id, $name, $handPreference, $height, $country, $age);
    
        // Execute the statement
        if ($stmt->execute()) {
            $message = "New player info inserted successfully";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
} catch (Exception $e) {
    $searchResults = "Error: " . $e->getMessage();
}

// 關閉資料庫連接
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Player</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.php">Search Player</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="match.php">Match</a></li>
                            <li class="nav-item"><a class="nav-link" href="best_player.php">Best Player</a></li>
                            <li class="nav-item"><a class="nav-link" href="customize.php">Customize</a></li>
                            <li class="nav-item"><a class="nav-link" href="Search_Player.php">Search Player</a></li>
                            <li class="nav-item"><a class="nav-link" href="Insert.php">Insert Player</a></li>
                            <li class="nav-item"><a class="nav-link" href="Delete.php">Delete Player</a></li>
                            <li class="nav-item"><a class="nav-link" href="Update.php">Update Player</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        <style>
            .search-bar-container {
                background-color: #4ABDAC; /* Teal background */
                padding: 20px;
                text-align: center;
            }
            .search-bar input[type="text"] {
                width: 250px; /* Width of the text field */
            }
            .search-bar input[type="submit"] {
                background-color: #FFFFFF; /* White background for the submit button */
                border: 1px solid #CCCCCC;
                cursor: pointer;
            }
            .search-results {
                text-align: center;
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="search-bar-container">
        <h3>Please Enter the info of the player you want to insert below</h3>
        <form class="player-info-form" action="" method="post">
            <div class="form-row">
                <div class="col">
                    <input class="form-control" type="text" name="id" placeholder="ID">
                </div>
                <div class="col">
                    <input class="form-control" type="text" name="name" placeholder="Name">
                </div>
                <div class="col">
                    <input class="form-control" type="text" name="handPreference" placeholder="Hand Preference">
                </div>
                <div class="col">
                    <input class="form-control" type="text" name="height" placeholder="Height">
                </div>
                <div class="col">
                    <input class="form-control" type="text" name="country" placeholder="Country">
                </div>
                <div class="col">
                    <input class="form-control" type="text" name="age" placeholder="Age">
                </div>
                <div class="col">
                    <input class="btn btn-primary" type="submit" value="Insert Player Info">
                </div>
            </div>
        </form>


        <?php if (!empty($message)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Bootstrap JS and Popper.js -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>
