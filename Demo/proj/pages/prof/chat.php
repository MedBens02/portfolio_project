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
    <link rel="stylesheet" href="chat.css">
</head>

<body>
    <div class="dash-title">
        <h1>Gerer vos etudiants</h1>
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
        <a href="manageEtudiant.php" id="settings-link">Manage Etudiants</a>
        <a href="manageModule.php" id="manageModule-link">Manage Module</a>
        <a href="chat.php" id="chat-link">Chat</a>

        <a href="profile.php" id="profile-link">Profile</a>
        <a href="../logout.php">Logout</a>
    </div>

    <div class="tables-cont">
        <div class="contn">
            <h2>Liste des etudiant</h2>

            <div id="failed" class="error-alert" hidden></div>
            <div id="success" class="success-alert" hidden></div>

            <div class="form-group">
                <label for="cours">Cours:</label>
                <select id="cours" name="Cour" class="form-input"></select>
            </div>

            <div class="form-group">
                <label for="cours">Etudiants:</label>
                <select id="students" name="student" class="form-input"></select>
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
                <button id="sendbtn" class="buttonAdd">Envoyer</button>
                <button id="broadcastbtn" class="buttonAdd">Annoncer</button>
            </div>

        </div>
    </div>
</body>

<footer class="footer">
    Copyright © 2024 ENSA Tetouan.
</footer>

</html>

<script type="text/javascript">
    var moduleID = undefined;
    const PAYLOAD = {
        recipientId: undefined,
        message: undefined
    }

    var chatPull = setInterval(() => {
        if (PAYLOAD.recipientId != undefined) {
            loadChat(PAYLOAD.recipientId);
        }
    }, 1000);

    document.querySelector("#students").addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        PAYLOAD.recipientId = selectedOption.getAttribute("data-std-id");
    })
    document.querySelector("#cours").addEventListener("change", function() {
        const selectedOption = this.options[this.selectedIndex];
        moduleID = selectedOption.value
        // alert(selectedOption.value)
    })

    document.querySelector("#msg").addEventListener("change", function() {
        PAYLOAD.message = this.value
    })

    document.querySelector('#sendbtn').addEventListener("click", function() {
        if (!PAYLOAD.message || !PAYLOAD.recipientId) {
            alert("Selectionner un etudiant");
            return;
        }
        fetch(
                `../../controllers/ChatController.php?method=send_message&secondParty=${PAYLOAD.recipientId}`, {
                    method: "POST",
                    body: JSON.stringify({
                        message: PAYLOAD.message
                    })
                }
            )
            .then((r) => {
                if (r.status !== 201) {
                    alert("could not send messag")
                }
            })
            .catch(() => {
                alert("Oops something went wrong")
            })
            .finally(() => {
                loadChat(PAYLOAD.recipientId);
                PAYLOAD.message = undefined;
            });
    })

    document.querySelector('#broadcastbtn').addEventListener("click", function() {

        if (!PAYLOAD.message) {
            alert("Ecrire un message");
            return;
        }
        if (moduleID == undefined) {
            alert("Selectionner un cours");
            return;
        }
        fetch(
                `../../controllers/AnnoucmentController.php?module=${moduleID}`, {
                    method: "POST",
                    body: JSON.stringify({
                        message: PAYLOAD.message
                    })
                }
            )
            .then((r) => {

            })
            .catch(() => {
                alert("Oops something went wrong")
            })
            .finally(() => {
                loadChat(PAYLOAD.recipientId);
            });
    })


    document.addEventListener("DOMContentLoaded", function() {
        fetchStudents();
        fetchCourses();
    })

    function loadChat(secondParty) {
        fetch(
                `../../controllers/ChatController.php?method=get_chat_logs&secondParty=${PAYLOAD.recipientId}`
            )
            .then((response) => response.json())
            .then((res) => {
                const populateChat = ChatBuilder(secondParty);

                populateChat(res);
            });
    }

    function ChatBuilder(recipient_id) {
        return function PopulateChat(messagelogs) {
            const chatbox = document.querySelector(".chat-box");
            chatbox.innerHTML = ``;
            if (messagelogs.length === 0) {
                chatbox.innerHTML = `No Message Found`;
                return;
            }

            messagelogs.toReversed().forEach((message) => {
                const messageBlock = document.createElement("div");
                messageBlock.classList.add("msg-block");

                const textBlob = document.createElement("div");
                if (message.recipient_id == -1) {
                    textBlob.classList.add("broadcast");
                } else {
                    textBlob.classList.add(
                        recipient_id == message.sender_id ? "received-msg" : "sent-msg"
                    );
                }



                textBlob.setAttribute("data-time-stamp", message.time_stamp);
                textBlob.innerText = message.msg;
                var timepstamp = document.createElement("div")
                timepstamp.classList.add("time_stamp")
                timepstamp.innerText = message.time_stamp
                textBlob.appendChild(timepstamp)
                messageBlock.appendChild(textBlob);
                chatbox.appendChild(messageBlock);
            });
        };
    }


    function fetchCourses() {
        const select = document.getElementById("cours");
        select.innerHTML += `<option value="" disabled selected>Cours</option>`;
        fetch("../../controllers/fetchAllcourses.php")
            .then((response) => response.json())
            .then((data) => {
                select.innerHTML += data
                    .map(
                        (course) =>
                        `<option data-prof-id="${course.prof_id}" name="${course.prof_id}" value="${course.id}">${course.nom}</option>`
                    )
                    .join("");
            });
    }


    function fetchStudents() {
        const select = document.querySelector("#students");
        var opt = document.createElement("option");
        opt.disabled = true;
        opt.selected = true;
        opt.innerText = "Etudiants";

        select.appendChild(opt)



        fetch("../../controllers/fetchStudents.php")
            .then((response) => response.json())
            .then((data) => {

                data.forEach(std => {
                    var stdOpts = document.createElement("option");
                    stdOpts.innerText = `${std.nom} ${std.prenom}`
                    stdOpts.setAttribute("data-std-id", std.id);
                    stdOpts.value = std.id;

                    select.appendChild(stdOpts)
                });

            });
    }
</script>




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