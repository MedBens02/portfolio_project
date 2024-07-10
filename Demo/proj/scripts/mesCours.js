document.addEventListener('DOMContentLoaded', function() {
    fetchCourses();
});

document.getElementById('cours').addEventListener('change', function() {
    fetchParts(this.value);
});
function fetchCourses() {
    const select = document.getElementById('cours');
    select.innerHTML += `<option value="" disabled selected>Cours</option>`;
    fetch('../../controllers/fetchMyCours.php')
        .then(response => response.json())
        .then(data => {
            select.innerHTML += data.map(course => `<option name="${course.prof_id}" value="${course.id}">${course.nom}</option>`).join('');

    });
}

function fetchParts(courseId) {
    fetch(`../../controllers/fetchParts.php?courseId=${courseId}`)
    .then(response => response.json())
    .then(parts => {
        const container = document.getElementById('parts');
        let html = "";
        parts.forEach(part => {
            let filename = part.path_part.split('/').pop();
            html += `<div class="part-item">
                        <h4>${part.title_part}</h4>
                        <a href="/proj/${part.path_part}" target="_blank">
                            <button class="buttonAdd">${filename}</h4></button>
                        </a>
                    </div>`;
        });
        container.innerHTML = html;
    });
}
