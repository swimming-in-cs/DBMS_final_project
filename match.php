<?php
// Enable error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// 連接資料庫
try {
    $db = new mysqli("localhost:3307", "user", "", "final");

    // 檢查資料庫連接是否成功
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    // 確認是否有 POST 請求
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 取得輸入的名字
        $searchName = $_POST['searchName']; // You don't need to escape this for prepared statements

        // 執行 SQL 查詢，使用预处理语句来防止 SQL 注入
        $stmt = $db->prepare("SELECT * FROM matches JOIN player ON player.player_id = matches.winner_id OR player.player_id = matches.loser_id WHERE player_name LIKE CONCAT('%', ?, '%')");
        $stmt->bind_param("s", $searchName);
        $stmt->execute();
        $result = $stmt->get_result();

        // 檢查查詢是否成功
        if ($result) {
            // 輸出查詢結果
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . htmlspecialchars($row["player_id"]) . " - Name: " . htmlspecialchars($row["player_name"]) . " - Score: " . htmlspecialchars($row["score"]) ."<br>";
                // 顯示其他欄位...
            }
        }
        // 釋放查詢結果集
        $result->free();
        // 關閉预处理语句
        $stmt->close();
    }
} catch (mysqli_sql_exception $e) {
    die("SQL Error: " . $e->getMessage());
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
                    <a class="navbar-brand" href="index.php">Start Bootstrap</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="match.php">Match</a></li>
                            <li class="nav-item"><a class="nav-link" href="best_player.php">Best Player</a></li>
                            <li class="nav-item"><a class="nav-link" href="customize.php">Customize</a></li>
                            <li class="nav-item"><a class="nav-link" href="dream_team.php">Dream team</a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                    <li><a class="dropdown-item" href="blog-home.html">Blog Home</a></li>
                                    <li><a class="dropdown-item" href="blog-post.html">Blog Post</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Portfolio</a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                                    <li><a class="dropdown-item" href="portfolio-overview.html">Portfolio Overview</a></li>
                                    <li><a class="dropdown-item" href="portfolio-item.html">Portfolio Item</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- Header-->
            <header class="py-5">
                <div class="container px-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xxl-6">
                            <div class="text-center my-5">
                                <h1 class="fw-bolder mb-3">Our mission is to make building websites easier for everyone.</h1>
                                <p class="lead fw-normal text-muted mb-4">Start Bootstrap was built on the idea that quality, functional website templates and themes should be available to everyone. Use our open source, free products, or support us by purchasing one of our premium products or services.</p>
                                <a class="btn btn-primary btn-lg" href="#scroll-target">Read our story</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        <script src="js/scripts.js"></script>
    </body>
</html>
