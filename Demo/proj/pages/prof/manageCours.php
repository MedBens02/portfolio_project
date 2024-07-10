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
    <link rel="stylesheet" href="manageCours.css">
</head>
<body>
    <div class="dash-title">
        <h1>Gerer vos cours</h1>
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
        <h2>Ajouter un cours</h2>
        <form id="coursForm" novalidate>
                    <div id="failed" class="error-alert" hidden></div>
                    <div id="success" class="success-alert" hidden></div>

                    <div class="form-group">
                        <label for="title">Titre:</label>
                        <input id="title" type="text" name="title" class="form-input" required>
                        <small id="titleError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="mdp">Description:</label>
                        <input id="desc" type="text" name="desc" class="form-input" required>
                        <small id="descError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <button class="buttonAdd">Ajouter cours</button>
                    </div>
            </form>
        
        </div>
    </div>
            
    <div class="tables-two-cont">
        <div class="contn">
        <h2>Liste de vos cours</h2>
        <div id="cours" class="table-wrapper course-table"></div>
        </div>
    </div>
    
    
    
    <script src="../../scripts/dashboardProf.js"></script>
    <script src="../../scripts/manageCours.js" type="module"></script>
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