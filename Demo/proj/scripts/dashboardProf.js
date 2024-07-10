document.addEventListener('DOMContentLoaded', function() {
    if (window.location.href.includes('dashboard') || window.location.href.includes('manageEtud'))
        fetchStudents();
    if (window.location.href.includes('dashboard') || window.location.href.includes('manageCours'))
        fetchCourses();
    checkForRequests;
});

function fetchStudents() {
    fetch('../../controllers/fetchStudents.php')
    .then(response => response.json())
    .then(students => {
        const container = document.getElementById('students');
        let html = `<table>`;
        html += `<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Adresse</th></tr>`;
        students.forEach(student => {
            html += `<tr>
                        <td>${student.id}</td>
                        <td>${student.nom}</td>
                        <td>${student.prenom}</td>
                        <td>${student.email}</td>
                        <td>${student.adresse}</td>
                     </tr>`;
        });
        html += `</table>`;
        container.innerHTML = html;
    });
}


function fetchCourses() {
    fetch('../../controllers/fetchAllcourses.php')
    .then(response => response.text()) // Get the response as text first to check it
    .then(text => {
        try {
            const cours = JSON.parse(text); // Try to parse text as JSON
            const container = document.getElementById('cours');
            let html = `<table>`;
            html += `<tr><th>ID</th><th>Cours</th><th>Description</th><th>Action</th></tr>`;
            cours.forEach(course => {
                html += `<tr>
                            <td>${course.id}</td>
                            <td>${course.nom}</td>
                            <td>${course.description}</td>
                            <td><button class='delete-btn' onclick='confirmDeleteCours(${course.id})'>Delete</button></td>
                         </tr>`;
            });
            html += `</table>`;
            container.innerHTML = html;
        } catch (error) {
            console.error('Error parsing JSON:', error, 'Received text:', text);
        }
    })
    .catch(error => {
        console.error('Error fetching the courses:', error);
    });
}

function confirmDeleteCours(crsId) {
    if (confirm('Are you sure you want to delete this Cours?')) {
        removeCours(crsId);
    }
}

function removeCours(crsId) {
    fetch('../../controllers/removeCours.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `crsId=${crsId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the profs list
            fetchCourses();
        } else {
            alert('Failed to delete course.');
        }
    });
}
