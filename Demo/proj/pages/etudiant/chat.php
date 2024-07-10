<?php


session_start();

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'etudiant') {
    // Redirect them to login page or show an error
    header('Location: ../login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="../assets/favicon.ico" type="image/x-icon">
    <title>Chat</title>
    <link rel="stylesheet" href="dashboardEtudiant.css">
    <link rel="stylesheet" href="mesCours.css">
    <link rel="stylesheet" href="chat.css">
</head>

<body>
    <div class="dash-title">
        <h1>Chat</h1>
        <button class="disconnectBtn" onclick="location.href='../logout.php'">Se deconnecter</button>
    </div>
    <!-- Side Navigation Menu -->
    <div class="side-nav">
        <img src="../pfp.png">
        <h2><?php echo $_SESSION['nom_complet']; ?></h2>
        <h3><?php echo $_SESSION['email']; ?></h3>
        <h4><?php echo $_SESSION['role']; ?></h4>
        <a href="dashboardEtudiant.php" id="dashboard-link">Dashboard</a>
        <a href="mesCours.php" id="mesCours-link">Mes Cours</a>
        <a href="chat.php" id="chat-link">Chat</a>
        <a href="profile.php" id="profile-link">Profile</a>
        <a href="../logout.php">Se deconnecter</a>
    </div>

    <div class="tables-cont">
        <div class="contn">
            <h2>Liste des cours</h2>

            <div id="failed" class="error-alert" hidden></div>
            <div id="success" class="success-alert" hidden></div>

            <div class="form-group">
                <label for="cours">Cours:</label>
                <select id="cours" name="cours" class="form-input">
                </select>
            </div>
            <div class="form-group">
                <label for="prof">Prof:</label>
                <output id="profName">...</output>
            </div>
        </div>
    </div>

    <div class="tables-two-cont">
        <div class="contn">
            <h2 id="chatWith">Chat</h2>
            <div class="chat-box">

            </div>
            <div class="form-group">
                <label for="msg">msg:</label>
                <input id="msg" name="message" class="form-input"></input>
                <button class="buttonAdd">Envoyer</button>
            </div>
        </div>
    </div>

    <script src="../../scripts/chat.js" type="module"></script>
</body>

<footer class="footer">
    Copyright © 2024 ENSA Tetouan.
</footer>

</html>


<script type="text/javascript">
    // Get the current page URL
    const currentPageUrl = window.location.href;

    // Get the sidebar links
    const sidebarLinks = document.querySelectorAll('.side-nav a');

    // Loop through the sidebar links
    sidebarLinks.forEach(link => {
        // Check if the link href matches the current page URL
        if (link.href === currentPageUrl) {
            // Add a class to highlight the selected link
            link.classList.add('selected');
        }
    });
</script>