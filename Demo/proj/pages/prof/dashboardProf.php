<?php


session_start();

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'prof') {
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
    <title>Prof Dashboard</title>
    <link rel="stylesheet" href="dashboardProf.css">
</head>

<body>
    <div class="dash-title">
        <h1>Prof Dashboard</h1>
        <button class="disconnectBtn" onclick="location.href='../logout.php'">Se deconnecter</button>
    </div>
    <!-- Side Navigation Menu -->
    <div class="side-nav">
        <img src="../../<?php echo $_SESSION['image']; ?>">
        <h2><?php echo $_SESSION['nom_complet']; ?></h2>
        <h3><?php echo $_SESSION['email']; ?></h3>
        <h4><?php echo $_SESSION['role']; ?></h4>
        <a href="dashboardProf.php" id="dashboard-link">Dashboard</a>
        <a href="manageCours.php" id="manage-cours-link">Manage Cours</a>
        <a href="manageEtudiant.php" id="settings-link">Manage Etudiants <span id="notif" hidden>!</span></a>
        <a href="manageModule.php" id="manageModule-link">Manage Module</a>
        <a href="chat.php" id="chat-link">Chat</a>

        <a href="profile.php" id="profile-link">Profile</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="tables-cont">
        <div class="contn">
            <h2>List des Étudiants</h2>
            <div id="students" class="table-wrapper"></div>
        </div>
    </div>

    <div class="tables-two-cont">
        <div class="contn">
            <h2>List des cours</h2>
            <button class="buttonAdd" onclick="window.location.href='manageCours.php';">Ajouter Cours</button>
            <div id="cours" class="table-wrapper course-table"></div>
        </div>
    </div>



    <script src="../../scripts/dashboardProf.js"></script>
    <script src="../../scripts/requestCheck.js"></script>
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