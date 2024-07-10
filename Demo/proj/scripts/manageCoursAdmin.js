document.addEventListener('DOMContentLoaded', function() {
    fetchAllCourses();
});
    function fetchAllCourses() {
    fetch('../../controllers/fetchAllExistantCours.php')
    .then(response => response.text())
    .then(text => {
        const cours = JSON.parse(text);
        const container = document.getElementById('cours');
        let html = `<table>`;
        html += `<tr><th>ID</th><th>Cours</th><th>Description</th><th>Prof ID</th><th>Action</th></tr>`;
        cours.forEach(course => {
            html += `<tr>
                        <td>${course.id}</td>
                        <td>${course.nom}</td>
                        <td>${course.description}</td>
                        <td>${course.prof_id}</td>
                        <td><button class='delete-btn' onclick='confirmDeleteCours(${course.id})'>Supprimer</button></td>
                     </tr>`;
            });
        html += `</table>`;
        container.innerHTML = html

    });
}

function confirmDeleteCours(crsId) {
    if (confirm('Confirmer la supression du cours.')) {
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
            fetchAllCourses();
        } else {
            alert('Failed to delete course.');
        }
    });
}


