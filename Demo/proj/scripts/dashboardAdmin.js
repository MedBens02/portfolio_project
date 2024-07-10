
document.addEventListener('DOMContentLoaded', function() {
    fetchProfs();
    fetchStudents();
});



function fetchProfs() {
    fetch('../../controllers/fetchProfs.php')
    .then(response => response.json())
    .then(profs => {
        const container = document.getElementById('profs');
        let html = `<table>`;
        html += `<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Adresse</th><th>Action</th></tr>`;
        profs.forEach(prof => {
            if (prof.request) {
                html += `<tr>
                    <td>${prof.id} <span>!<span/></td>
                `;
                const notif = document.getElementById('notif');
                notif.hidden = false;
                const errorMsg = document.getElementById('failed');
                errorMsg.textContent = "Certains utilisateurs ont demandes une suppression de compte";
                errorMsg.hidden = false;
            } else {
                html += `<tr>
                    <td>${prof.id}</td>
                    `;
            }
            
            html += `<td>${prof.nom}</td>
                        <td>${prof.prenom}</td>
                        <td>${prof.email}</td>
                        <td>${prof.adresse}</td>
                        <td><button class='delete-btn' onclick='confirmDeleteProf(${prof.id})'>Supprimer</button></td>
                        </tr>`;
        });
        html += `</table>`;
        container.innerHTML = html;
    });
}

function fetchStudents() {
    if (window.location.href.includes('manage')) {
        const errorMsg = document.getElementById('failed');
        errorMsg.hidden = true;
    }

    const notif = document.getElementById('notif');
        notif.hidden = true;


    fetch('../../controllers/fetchStudents.php')
    .then(response => response.json())
    .then(students => {
        const container = document.getElementById('students');
        let html = `<table>`;
        html += `<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Adresse</th><th>Action</th></tr>`;
        students.forEach(student => {
            
            if (student.request) {
                html += `<tr>
                    <td>${student.id} <span>!<span/></td>
                `;
                const notif = document.getElementById('notif');
                notif.hidden = false;
                const errorMsg = document.getElementById('failed');
                errorMsg.textContent = "Certains utilisateurs ont demandes une suppression de compte";
                errorMsg.hidden = false;
            } else {
                html += `<tr>
                    <td>${student.id}</td>
                `;
            }

            html += `<td>${student.nom}</td>
                        <td>${student.prenom}</td>
                        <td>${student.email}</td>
                        <td>${student.adresse}</td>
                        <td><button class='delete-btn' onclick='confirmDeleteStudent(${student.id})'>Supprimer</button></td>
                        </tr>`;
        });
        html += `</table>`;
        container.innerHTML = html;  
    });
}

function confirmDeleteProf(profId) {
    if (confirm('Confirmer la supression du professeur.')) {
        removeProf(profId);
    }
}

function confirmDeleteStudent(stdId) {
    if (confirm('Confirmer la supression d\'etudiant.')) {
        removeStudent(stdId);
    }
}


function removeProf(profId) {
    fetch('../../controllers/removeProf.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `profId=${profId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the profs list
            fetchProfs();
        } else {
            alert('Failed to delete professor.');
        }
    });
    fetchProfs();
}

function removeStudent(stdId) {
    fetch('../../controllers/removeStudent.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `stdId=${stdId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the students list
            fetchStudents();
        } else {
            alert('Failed to delete student.');
        }
    });
    fetchStudents();
}