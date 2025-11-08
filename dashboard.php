<?php
session_start();
require_once 'config.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];

// Handle post deletion
if(isset($_GET['delete'])){
    $delete_id = intval($_GET['delete']);
    $del_q = $mysqli->prepare("DELETE FROM posts WHERE post_id = ? AND author_id = ?");
    $del_q->bind_param("ii", $delete_id, $user_id);
    $del_q->execute();
    $del_q->close();
    header("Location: dashboard.php");
    exit;
}

// Fetch author's posts (all status)
$sql = "SELECT * FROM posts WHERE author_id = ? ORDER BY created_at DESC";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$posts = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Luminara</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="sidebar">
        <img src="assets/luminara-logo.png" alt="Luminara Logo" class="logo" />
        <a href="index.php">Home</a>
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="create_post.php">Create Post</a>
        <a href="logout.php">Log Out</a>
    </div>
    <div class="main-container">
        <h2 style="font-family:'Lemonada',cursive;font-size:2rem;font-weight:400;margin-bottom:19px;">Hi <?php echo htmlspecialchars($username); ?> 👋</h2>
        <?php if($posts->num_rows > 0): 
            while($row = $posts->fetch_assoc()): ?>
                <div class="card">
                    <div class="author-row">
                        <div class="author-avatar"></div>
                        <strong><?php echo htmlspecialchars($username); ?></strong>
                        <span style="margin-left:12px;font-size:0.9em;color:#5946d4;"><?php
                            $date = new DateTime($row['created_at']);
                            $now = new DateTime();
                            $diff = $now->diff($date);
                            echo ($diff->days >= 7) ? floor($diff->days / 7) . "W ago" : $diff->days . "d ago";
                        ?></span>
                        <span style="margin-left:auto;color:#aaa;"><?php echo ucfirst($row['status']); ?></span>
                    </div>
                    <div class="post-title"><?php echo htmlspecialchars($row['title']); ?></div>
                    <div class="post-body"><?php echo nl2br(htmlspecialchars(mb_strimwidth($row['content'],0,120,"..."))); ?></div>
                    <a href="view_post.php?id=<?php echo $row['post_id']; ?>" class="button" style="margin-right:10px;">View</a>
                    <a href="edit_post.php?id=<?php echo $row['post_id']; ?>" class="button" style="background:orange;color:#fff;margin-right:10px;">Edit</a>
                    <a href="dashboard.php?delete=<?php echo $row['post_id']; ?>" class="button" style="background:#d72323;color:#fff;" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                </div>
        <?php endwhile; else: ?>
            <div class="card">
                <div class="post-title">You have not created any posts yet.</div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>