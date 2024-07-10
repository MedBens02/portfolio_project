document.addEventListener('DOMContentLoaded', function() {
    fetchMyCourses();
    fetchRequests();
    fetchAllCourses();
});

let enrolledCourseIds = [];
let requestedCourseIds = [];


function fetchMyCourses() {
    fetch('../../controllers/fetchMycours.php')
    .then(response => response.text()) // Get the response as text first to check it
    .then(text => {
        try {
            const cours = JSON.parse(text); // Try to parse text as JSON
            const container = document.getElementById('cours');
            let html = `<table>`;
            html += `<tr><th>ID</th><th>Cours</th><th>Description</th></tr>`;
            cours.forEach(course => {
                html += `<tr>
                            <td>${course.id}</td>
                            <td>${course.nom}</td>
                            <td>${course.description}</td>
                         </tr>`;
                enrolledCourseIds.push(course.id);
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



function fetchAllCourses() {
    fetch('../../controllers/fetchAllExistantCours.php')
        .then(response => response.text())
        .then(text => {
            try {
                const allCourses = JSON.parse(text);
                const container = document.getElementById('coursAll');
                let html = `<table><tr><th>ID</th><th>Cours</th><th>Description</th><th>Action</th></tr>`;
                allCourses.forEach(course => {
                    let buttonLabel = 'S\'inscrire';
                    let buttonClass = 'enroll-btn';
                    if (!enrolledCourseIds.includes(course.id)) {
                        if (requestedCourseIds.includes(course.id)) {
                            buttonLabel = 'Annuler';  // Change button label if there's a pending request
                            buttonClass = 'delete-btn';
                        }
                        html += `<tr><td>${course.id}</td><td>${course.nom}</td>
                                <td>${course.description}</td>
                                <td><button class="${buttonClass}" 
                                    data-courseid="${course.id}"
                                    data-profid="${course.prof_id}"
                                    >${buttonLabel}</button></td>
                                </tr>`;
                    }
                });
                html += `</table>`;
                container.innerHTML = html;
                attachEnrollEventListeners();  // Ensure event listeners are attached
            } catch (error) {
                console.error('Error parsing JSON:', error, 'Received text:', text);
            }
        })
        .catch(error => {
            console.error('Error fetching all courses:', error);
    });
}


function attachEnrollEventListeners() {
    const container = document.getElementById('coursAll');
    container.addEventListener('click', function(event) {
        if (event.target.classList.contains('enroll-btn')) {
            const courseId = event.target.getAttribute('data-courseid');
            const profId = event.target.getAttribute('data-profid');
            enrollInCourse(courseId, profId);
        } else if (event.target.classList.contains('delete-btn')) {
            const courseId = event.target.getAttribute('data-courseid');
            cancelCourseRequest(courseId);
        }
    });
}

function cancelCourseRequest(courseId) {
    fetch('../../controllers/cancelRequest.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `courseId=${courseId}`
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        const index = requestedCourseIds.indexOf(courseId);
        if (index > -1) {
            requestedCourseIds.splice(index, 1);  // Remove from the list of pending requests
        }
        updateCourseButtons();  // Immediately update UI
    })
    .catch(error => {
        console.error('Error cancelling request', error);
        alert('Erreur lors de l\'annulation de la demande.');
    });
}


function enrollInCourse(courseId, profId) {
    fetch('../../controllers/requestEnroll.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `courseId=${courseId}&profId=${profId}`
    })
    .then(response => response.text())
    .then(result => {
        alert(result);
        requestedCourseIds.push(courseId);  // Add to the list of pending requests
        updateCourseButtons();  // Immediately update UI
    })
    .catch(error => {
        console.error('Error sending request', error);
        alert('Erreur lors de l\'envoi de la demande.');
    });
}

function fetchRequests() {
    fetch('../../controllers/fetchRequests.php')
        .then(response => response.json())
        .then(data => {
            requestedCourseIds = data.map(request => request.cours_id);
            updateCourseButtons();  // Call a function to update the button text
        })
        .catch(error => {
            console.error('Error fetching requests:', error);
        });
}

function updateCourseButtons() {
    const buttons = document.querySelectorAll('button[data-courseid]');
    buttons.forEach(button => {
        const courseId = button.getAttribute('data-courseid');
        if (requestedCourseIds.includes(courseId)) {
            button.textContent = 'Annuler';  // Change the text to 'Annuler'
            button.classList.remove('enroll-btn');
            button.classList.add('delete-btn');
        } else {
            button.textContent = 'S\'inscrire';  // Revert text to 'S'inscrire'
            button.classList.remove('delete-btn');
            button.classList.add('enroll-btn');
        }
    });
}

