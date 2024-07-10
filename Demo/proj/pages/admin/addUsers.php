<?php


session_start();

if (!isset($_SESSION['logged']) || $_SESSION['role'] !== 'admin') {
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
    <link rel="stylesheet" href="dashboardAdmin.css">
    <link rel="stylesheet" href="addUsers.css">
</head>
<body>
    <div class="dash-title">
        <h1>Ajouter Utilisateurs</h1>
        <button class="disconnectBtn" onclick="location.href='../logout.php'">Se deconnecter</button>
    </div>
    <!-- Side Navigation Menu -->
    <div class="side-nav">
        <img src="../pfp.png">
        <h2><?php echo $_SESSION['nom_complet']; ?></h2>
        <h4><?php echo $_SESSION['role']; ?></h4>
        <a href="dashboardAdmin.php" id="dashboard-link">Dashboard</a>
        <a href="manageUsers.php" id="manage-users-link">Gerer les utilisateurs<span id="notif" hidden>!</span></a>
        <a href="manageCours.php" id="manage-cours-link">Gerer les cours</a>
        <a href="addUsers.php" id="addUsers-link">Ajouter utilisateurs</a>
        <a href="../logout.php">Se deconnecter</a>
    </div>


    <div class="tables-cont">
        <div class="contn">
        <h2>Modifer votre profile</h2>
        <form id="registerForm" class="register-form" novalidate>
                    <div id="failed" class="error-alert" hidden></div>
                    <div id="success" class="success-alert" hidden></div>

                    <input type="hidden" id="userRole" value="admin">

                    <div class="form-group">
                        <label for="userType">Type de compte:</label>
                        <select id="userType" name="userType" class="form-input">
                            <option value="prof">Prof</option>
                            <option value="etudiant">Etudiant</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="identifiant">Email:</label>
                        <input id="identifiant" type="email" name="identifiant" class="form-input" placeholder="Email" required>
                        <small id="loginError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="mdp">Mot de Passe:</label>
                        <input id="mdp" type="password" name="mdp" class="form-input" required>
                        <small id="mdpError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input id="name" type="text" name="name" class="form-input" required>
                        <small id="NameFieldError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="surname">Prenom:</label>
                        <input id="surname" type="text" name="surname" class="form-input" required>
                        <small id="surnameError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse:</label>
                        <input id="address" type="text" name="address" class="form-input" required>
                        <small id="addressError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="buttonAdd">Creer un compte</button>
                    </div>
            </form>
        
        </div>
    </div>
    <script src="../../scripts/register.js" type="module"></script>
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