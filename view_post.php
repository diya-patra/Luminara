<?php
session_start();
require_once "config.php";
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT posts.*, users.username FROM posts JOIN users ON posts.author_id = users.user_id WHERE posts.post_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows != 1){
    die("Post not found.");
}
$post = $result->fetch_assoc();

// Access control
$is_author = (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true && $_SESSION["user_id"] == $post['author_id']);
if($post['status'] != 'published' && !$is_author){
    die("You don't have access to this post.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($post['title']); ?> | Luminara</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="sidebar">
        <img src="assets/luminara-logo.png" alt="Luminara Logo" class="logo" />
        <a href="index.php">Home</a>
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]===true): ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="create_post.php">Create Post</a>
            <a href="logout.php">Log Out</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Sign Up</a>
        <?php endif; ?>
    </div>
    <div class="main-container">
        <div class="card">
            <div class="author-row">
                <div class="author-avatar"></div>
                <strong><?php echo htmlspecialchars($post['username']); ?></strong>
                <span style="margin-left:12px;font-size:0.95em;color:#7868EA;font-style:italic;">
                    <?php
                        $date = new DateTime($post['created_at']);
                        $now = new DateTime();
                        $diff = $now->diff($date);
                        echo ($diff->days >= 7) ? floor($diff->days / 7) . "W ago" : $diff->days . "d ago";
                    ?>
                </span>
            </div>
            <div class="post-title"><?php echo htmlspecialchars($post['title']); ?></div>
            <div class="post-body"><?php echo nl2br(htmlspecialchars($post['content'])); ?></div>
        </div>
    </div>
</body>
</html>