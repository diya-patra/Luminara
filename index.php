<?php
session_start();
require_once 'config.php';

// Fetch published posts (latest first)
$sql = "SELECT posts.*, users.username FROM posts 
        JOIN users ON posts.author_id = users.user_id
        WHERE posts.status = 'published'
        ORDER BY posts.created_at DESC";
$result = $mysqli->query($sql);

// Site navigation state
$loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$user = $loggedin ? $_SESSION["username"] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Luminara Blog</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lemonada:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <img src="assets/luminara-logo.png" alt="Luminara Logo" class="logo" />
        <a href="index.php" class="active">Home</a>
        <?php if($loggedin): ?>
            <a href="create_post.php">Create Post</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Log Out</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </div>

    <div class="main-container">
        <div class="navbar">
            <a href="index.php" class="active">Home</a>
            <?php if($loggedin): ?>
                <a href="create_post.php">Create Post</a>
            <?php else: ?>
                <a href="register.php">Start Writing</a>
            <?php endif; ?>
        </div>
        <?php 
        if($result && $result->num_rows > 0): 
            while($row = $result->fetch_assoc()): 
        ?>
        <div class="card">
            <div class="author-row">
                <div class="author-avatar"></div>
                <div>
                    <span style="font-weight:500"><?php echo htmlspecialchars($row['username']); ?></span>
                    <span style="font-size:0.98em;color:#7868EA;font-style:italic;">
                        <?php
                            $date = new DateTime($row['created_at']);
                            $now = new DateTime();
                            $diff = $now->diff($date);
                            echo ($diff->days >= 7) ? floor($diff->days / 7) . "W ago" : $diff->days . "d ago";
                        ?>
                    </span>
                </div>
            </div>
            <div class="post-title"><?php echo htmlspecialchars($row['title']); ?></div>
            <div class="post-body"><?php echo nl2br(htmlspecialchars(mb_strimwidth($row['content'],0,120,"..."))); ?></div>
            <a href="view_post.php?id=<?php echo $row['post_id']; ?>" class="button" style="display:inline-block;margin-top:12px;">Read Full Blog</a>
        </div>
        <?php 
            endwhile; 
        else: 
        ?>
        <div class="card">
            <div class="post-title">No published posts yet.</div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>