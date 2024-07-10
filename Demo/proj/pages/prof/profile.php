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
    <link rel="stylesheet" href="profile.css">
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
        <h2>Changer mot de passe</h2>
        <form id="changePassForm" novalidate>
                    <div id="failed" class="error-alert" hidden></div>
                    <div id="success" class="success-alert" hidden></div>

                    <div class="form-group">
                        <label for="oldpass">Ancien mdp:</label>
                        <input id="oldpass" type="password" name="oldpass" class="form-input" required>
                        <small id="oldpassError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="newpass">Nouveau mdp:</label>
                        <input id="newpass" type="text" name="newpass" class="form-input" required>
                        <small id="newpassError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="mdp">Confirmer nouveau mdp:</label>
                        <input id="newpassConf" type="text" name="newpassConf" class="form-input" required>
                        <small id="newpassConfError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <button class="buttonAdd">Modifier mot de passe</button>
                    </div>
            </form>
        
        </div>
    </div>

    <div class="tables-two-cont">
        <div class="contn">
        <h2>Modifer votre profile</h2>
        <form id="modifyProfile" novalidate>
                    <div id="failedChange" class="error-alert" hidden></div>
                    <div id="successChange" class="success-alert" hidden></div>

                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input id="name" type="text" name="name" class="form-input" required>
                        <small id="nameError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="surname">Prenom:</label>
                        <input id="surname" type="text" name="surname" class="form-input" required>
                        <small id="surnameError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="email">email:</label>
                        <input id="email" type="email" name="email" class="form-input" required>
                        <small id="emailError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="address">adresse:</label>
                        <input id="address" type="text" name="address" class="form-input" required>
                        <small id="addressError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="buttonAdd">Modifier profile</button>
                        <button type="button" id="demande" class="buttonAdd">Demander suppression</button>
                    </div>
            </form>
        
        </div>
    </div>
    <script src="../../scripts/changePass.js" type="module"></script>
    <script src="../../scripts/modifyProfile.js" type="module"></script>
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