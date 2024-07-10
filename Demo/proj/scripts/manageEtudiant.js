document.addEventListener('DOMContentLoaded', function() {
    fetchCourses();
    fetchAllStudents();

    document.getElementById('enrollButton').addEventListener('click', enrollStudents);
});

document.getElementById('cours').addEventListener('change', function() {
    fetchStudents(this.value);
});



function fetchAllStudents() {
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
    const select = document.getElementById('cours');
    select.innerHTML = `<option value="" disabled selected>Selectionner un cours</option>`; // Reset dropdown content

    Promise.all([
        fetch('../../controllers/fetchAllCourses.php').then(response => response.json()),
        fetch('../../controllers/fetchRequestsByCourse.php').then(response => response.json())
    ])
    .then(([courses, requestedCourseIds]) => {
        if (courses.error) {
            console.error('Error fetching courses:', courses.error);
            return;
        }
        if (!Array.isArray(requestedCourseIds)) {
            console.error('Error fetching requests:', requestedCourseIds);
            return;
        }

        const requestsSet = new Set(requestedCourseIds); // Create a set for quick lookup
        courses.forEach(course => {
            const hasRequests = requestsSet.has(course.id);
            const notifHtml = hasRequests ? ' (!)' : ''; // Show '!' if there are pending requests
            select.innerHTML += `<option value="${course.id}">${course.nom}${notifHtml}</option>`;
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
}
const errorMsg = document.getElementById('failed');
const successMsg = document.getElementById('success');

function fetchStudents(courseId) {
    Promise.all([
        fetch(`../../controllers/fetchStudentsWithEnrollment.php?courseId=${courseId}`).then(res => res.json()),
        fetch(`../../controllers/fetchRequestsForCourse.php?courseId=${courseId}`).then(res => res.json())
    ]).then(([students, requests]) => {
        const container = document.getElementById('students');
        let html = `<table class="check-table"><tr><th>Action</th><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Adresse</th></tr>`;
        students.forEach(student => {
            const isRequested = requests.includes(student.id);
            let actionHtml = student.is_enrolled ?
                `<span class="remove-enrollment" data-student-id="${student.id}" title="Remove enrollment">×</span>` :
                `<input type="checkbox" name="student" value="${student.id}">`;
            let notifHtml = isRequested ? `<span class="notif"> !</span>` : '';

            html += `<tr>
                        <td>${actionHtml}</td>
                        <td>${student.id}${notifHtml}</td>
                        <td>${student.nom}</td>
                        <td>${student.prenom}</td>
                        <td>${student.email}</td>
                        <td>${student.adresse}</td>
                     </tr>`;
        });
        html += `</table>`;
        container.innerHTML = html;

        // Add click event listeners for removing enrollment
        document.querySelectorAll('.remove-enrollment').forEach(item => {
            item.addEventListener('click', function() {
                removeEnrollment(courseId, this.getAttribute('data-student-id'));
            });
        });
    }).catch(error => {
        console.error('Error fetching data:', error);
    });
}


function enrollStudents() {
    const selectedStudents = Array.from(document.querySelectorAll('input[name="student"]:checked')).map(input => input.value);
    const courseId = document.getElementById('cours').value;
    errorMsg.hidden = true;
    successMsg.hidden = true;

    // Check if any students are selected
    if (selectedStudents.length === 0) {
        errorMsg.textContent = 'Aucun etudiant n\'est selectionne.';
        errorMsg.hidden = false;
        return;
    }

    fetch('../../controllers/enrollEtudiant.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ courseId: courseId, students: selectedStudents })
    })
    .then(response => response.text())
    .then(result => {
        if (result === "Success") {
            successMsg.textContent = "Etudiant ajoute avec succees";
            successMsg.hidden = false;
            selectedStudents.forEach(studentId => {
                removeRequest(courseId, studentId);
            });
        }
    })
    .catch(error => console.error('Error:', error));
    fetchStudents(courseId);
}

function removeEnrollment(courseId, studentId) {
    fetch('../../controllers/removeEnrollment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ courseId: courseId, studentId: studentId })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            fetchStudents(courseId);
            successMsg.textContent = "Etudiant enleve avec succees";
            successMsg.hidden = false;
        } else {
            errorMsg.textContent = "Erreur lors la supression de l'etudiant";
            errorMsg.hidden = false;
        }
    })
    .catch(error => console.error('Error:', error));
}

function removeRequest(courseId, studentId) {
    fetch('../../controllers/cancelRequest.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `courseId=${courseId}&studentId=${studentId}`
    })
    .then(response => response.text())
    .then(result => {
        fetchStudents(courseId);
        fetchCourses();
    })
    .catch(error => {
        console.error('Error removing request:', error);
        alert('Failed to remove request.');
    });
}
