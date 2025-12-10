<?php
session_start();
include 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch streak data
$streakQuery = $conn->query("SELECT current_streak, last_logged FROM streaks WHERE user_id = $user_id");
if ($streakQuery->num_rows > 0) {
    $streakData = $streakQuery->fetch_assoc();
    $current_streak = (int)$streakData['current_streak'];
    $last_logged = $streakData['last_logged'];
} else {
    $current_streak = 0;
    $last_logged = null;
}

$today = date('Y-m-d');
$yesterday = date('Y-m-d', strtotime("-1 day"));

if ($last_logged !== $today) {
    if ($last_logged === $yesterday) {
        $current_streak++;
    } else {
        $current_streak = 1;
    }
    $stmt = $conn->prepare("INSERT INTO streaks (user_id, current_streak, last_logged) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE current_streak = ?, last_logged = ?");
    $stmt->bind_param("iissi", $user_id, $current_streak, $today, $current_streak, $today);
    $stmt->execute();
    $stmt->close();
}

$badges = [
    5 => ['name' => 'Rookie Streak', 'img' => 'badge5.png'],
    7 => ['name' => 'Getting Stronger', 'img' => 'badge7.png'],
    30 => ['name' => 'Fitness Enthusiast', 'img' => 'badge30.png'],
    60 => ['name' => 'Dedicated Warrior', 'img' => 'badge60.png'],
    100 => ['name' => 'Legendary Streak', 'img' => 'badge100.png']
];
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <title>Achievements - FitnessGym</title>
  <style>
    /* Root & fonts */
    body {
      margin: 0; padding: 0; background-color: #0f172a;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #e0e0e0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px 20px;
      user-select: none;
    }

    h1 {
      font-weight: 700;
      font-size: 2.8rem;
      color: #22c55e; /* bright green accent */
      margin-bottom: 40px;
      text-shadow: 0 0 8px #22c55e80;
    }

    /* Streak card */
    .streak-container {
      background: #1e293b;
      max-width: 520px;
      width: 100%;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgb(34 197 94 / 0.5);
      padding: 30px 25px;
      text-align: center;
      margin-bottom: 50px;
      border: 2px solid #22c55e44;
      transition: box-shadow 0.3s ease;
    }

    .streak-container:hover {
      box-shadow: 0 0 30px #22c55eaa;
    }

    .streak-label {
      font-size: 1.3rem;
      letter-spacing: 1px;
      color: #94a3b8;
    }

    .streak-number {
      font-size: 5rem;
      font-weight: 800;
      color: #22c55e;
      margin: 10px 0 15px;
      text-shadow: 0 0 10px #22c55eaa;
      font-family: 'Courier New', Courier, monospace;
      user-select: text;
    }

    .streak-note {
      font-size: 1rem;
      color: #64748b;
      letter-spacing: 0.6px;
    }

    /* Badges grid */
    .badges-container {
      max-width: 960px;
      width: 100%;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
      gap: 28px;
      padding: 0 10px;
    }

    /* Badge cards */
    .badge {
      background: #1e293b;
      border-radius: 20px;
      box-shadow: 0 3px 15px rgba(34, 197, 94, 0.3);
      padding: 20px 15px;
      cursor: default;
      transition: filter 0.4s ease, transform 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      user-select: none;
      border: 2px solid transparent;
      position: relative;
    }

    .badge img {
      width: 70px;
      margin-bottom: 15px;
      user-select: none;
    }

    .badge-name {
      font-weight: 700;
      font-size: 1.1rem;
      text-align: center;
      color: #94a3b8;
      user-select: none;
      margin-bottom: 5px;
    }

    .badge-days {
      font-size: 0.85rem;
      color: #64748b;
      font-weight: 600;
      letter-spacing: 0.4px;
      user-select: none;
    }

    /* Locked state - blurred & grayscale */
    .badge.locked {
      filter: blur(4px) grayscale(65%);
      opacity: 0.6;
      pointer-events: none;
      transform: scale(0.95);
      border-color: #64748b33;
    }

    /* Unlocked state - bright green border & glow */
    .badge.unlocked {
      filter: none;
      opacity: 1;
      border-color: #22c55e;
      box-shadow: 0 0 18px 4px #22c55e66;
      color: #22c55e;
      transform: scale(1);
    }

    .badge.unlocked .badge-name {
      color: #22c55e;
    }

    /* Tooltip */
    .badge[title]:hover::after {
      content: attr(title);
      position: absolute;
      bottom: 110%;
      left: 50%;
      transform: translateX(-50%);
      background: #0f172a;
      padding: 6px 12px;
      border-radius: 6px;
      color: #22c55e;
      font-size: 0.9rem;
      white-space: nowrap;
      box-shadow: 0 0 10px #22c55eaa;
      user-select: none;
      pointer-events: none;
      opacity: 1;
      transition: opacity 0.3s ease;
      z-index: 10;
    }
  </style>
</head>
<body>

<h1>🔥 Your Fitness Achievements</h1>

<div class="streak-container" title="Your current daily workout streak">
  <div class="streak-label">Current Daily Streak</div>
  <div class="streak-number"><?= $current_streak ?></div>
  <div class="streak-note">Keep working out every day to unlock badges and rewards!</div>
</div>

<div class="badges-container">
  <?php foreach ($badges as $days => $badge): 
    $unlocked = $current_streak >= $days;
  ?>
  <div class="badge <?= $unlocked ? 'unlocked' : 'locked' ?>" title="<?= $badge['name'] ?> - Requires <?= $days ?> days streak">
    <img src="badges/<?= $badge['img'] ?>" alt="<?= $badge['name'] ?>" />
    <div class="badge-name"><?= $badge['name'] ?></div>
    <div class="badge-days">(<?= $days ?> days)</div>
  </div>
  <?php endforeach; ?>
</div>

<br>
<a href="HOME.html" class="btn-action" 
     style="
       background-color: #16a085; 
       color: #333; 
       box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
       padding: 12px 30px; 
       border-radius: 12px; 
       font-weight: bold; 
       text-decoration: none; 
       display: inline-block;
       width: 120px;
       text-align: center;
       transition: background-color 0.3s ease;
     ">
    Home
  </a>

</body>
</html>
