<?php
// Enable error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
        $height = $_POST['height'];
        $handPreference = $_POST['handPreference'];
        $sql="Select player.player_name, player.player_ht, count(*) as cnt
                From matches, player, tournerment
                where matches.winner_id=player.player_id
                and matches.tourney_id=tournerment.tourney_id
                and abs(player_ht - ?) <= 3 
                and player_hand = ?
                Group by player_name
                order by cnt desc
                limit 3;";
        // 執行 SQL 查詢，使用预处理语句来防止 SQL 注入
        $stmt = $db->prepare($sql);
        $stmt->bind_param("is", $height, $handPreference);
        $stmt->execute();
        $result = $stmt->get_result();

        // 檢查查詢是否成功
        if ($result) {
            // 輸出查詢結果
            while ($row = $result->fetch_assoc()) {
                $searchResults .= "Name: " . htmlspecialchars($row["player_name"]) . " - Player Height: " . htmlspecialchars($row["player_ht"]) . " - Number of wins: " . htmlspecialchars($row["cnt"]) .  "<br>";
            }
        } else {
            $searchResults = "Query failed: " . $db->error;
        }
        // 釋放查詢結果集
        $result->free();
        // 關閉预处理语句
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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Modern Business - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body class="d-flex flex-column">
        <main class="flex-shrink-0">
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html">Customize</a>
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
            <h3>Please Enter your dominant hand and height below</h3>
            <form class="search-bar" action="" method="post">
            <select class="form-control" name="handPreference" style="width: auto; display: inline-block;">
                <option value="L">Left Hand</option>
                <option value="R">Right Hand</option>
            </select>    
                <input class="form-control" type="text" name="height" placeholder="Height" style="display: inline-block;">
                <input class="btn" type="submit" value="Enter" style="display: inline-block;">
            </form>
        </div>

        <?php if ($isPost): ?>
            <div class="search-results">
                <h4>Search Results:</h4>
                <?php echo $searchResults; ?>
            </div>
        <?php endif; ?>   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
