<?php
session_start();  // Start the session to access session variables

// Check if the user is already logged in
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    // Check user role and redirect accordingly
    switch ($_SESSION['role']) {
        case 'admin':
            header('Location: ./admin/dashboardAdmin.php');  // Redirect to admin dashboard
            break;
        case 'prof':
            header('Location: ./prof/dashboardProf.php');  // Redirect to professor dashboard
            break;
        case 'etudiant':
            header('Location: ./etudiant/dashboardEtudiant.php');  // Redirect to student dashboard
            break;
        default:
            session_destroy();  // Unset all session variables
            header('Location: login.php');  // Redirect to login page if role is not defined
            break;
    }
    exit;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <link rel="icon" href="./assets/favicon.ico" type="image/x-icon">
    <title>Plateforme Scolarité</title>
</head>
<body>
    <div class="wrapper">
        <section class="login-container">
            <form id="loginForm" class="login-form" novalidate>
                <fieldset class="login-fieldset">
                    <legend class="form-title">Login</legend>

                    <div id="failed" class="error-alert" hidden></div>

                    <div class="form-group">
                        <label for="userType">Type de compte:</label>
                        <select id="userType" name="userType" class="form-input">
                            <option value="admin">Admin</option>
                            <option value="prof">Prof</option>
                            <option value="etudiant">Etudiant</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="identifiant">Identifiant:</label>
                        <input id="identifiant" type="text" name="identifiant" class="form-input" value="" required>
                        <small id="loginError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <label for="mdp">Mot de Passe:</label>
                        <input id="mdp" type="password" name="mdp" class="form-input" required>
                        <small id="mdpError" class="error-message" hidden></small>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="submit-btn">Se Connecter</button>
                    </div>
                    <div class="form-group">
                        <label>Pas de compte?</label>
                        <a href="./register.php">Creer un compte</a> 
                    </div>
                </fieldset>
            </form>
        </section>
    </div>
    <script src="../scripts/login.js" type="module"></script>
</body>
</html>
