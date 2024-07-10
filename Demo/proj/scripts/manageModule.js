document.addEventListener('DOMContentLoaded', function() {
    fetchCourses();

});

document.getElementById('cours').addEventListener('change', function() {
    fetchParts(this.value);
});
function fetchCourses() {
    const select = document.getElementById('cours');
    select.innerHTML += `<option value="" disabled selected>Cours</option>`;
    fetch('../../controllers/fetchAllCourses.php')
        .then(response => response.json())
        .then(data => {
            select.innerHTML += data.map(course => `<option value="${course.id}">${course.nom}</option>`).join('');
        });
}

function fetchParts(courseId) {
    fetch(`../../controllers/fetchParts.php?courseId=${courseId}`)
    .then(response => response.json())
    .then(parts => {
        const container = document.getElementById('parts');
        let html = "";
        parts.forEach(part => {
            html += `<div class="part-item">
                        <span class="remove-part" data-part-id="${part.id_part}" title="Remove part">×</span>
                        <a href="/proj${part.path_part}" target="_blank">
                            <button class="buttonAdd"><h4>${part.title_part}</h4></button>
                        </a>
                        <label><input type="checkbox" class="view-flag" data-part-id="${part.id_part}" ${part.view_flag ? 'checked' : ''}> Valable</label>
                    </div>`;
        });
        container.innerHTML = html;

        addPartRemovalListeners(courseId); // Add remove listeners after HTML is rendered
        addViewFlagListeners(); // Add view flag listeners
    });
}

function addPartRemovalListeners(courseId) {
    document.querySelectorAll('.remove-part').forEach(item => {
        item.addEventListener('click', function() {
            const partId = this.getAttribute('data-part-id');
            console.log("Trying to remove part ID:", partId); // Debugging output
            removePart(partId, courseId);
        });
    });
}

function addViewFlagListeners() {
    document.querySelectorAll('.view-flag').forEach(item => {
        item.addEventListener('change', function() {
            toggleViewFlag(this.getAttribute('data-part-id'), this.checked);
        });
    });
}

function toggleViewFlag(partId, isViewable) {
    fetch('../../controllers/toggleViewFlag.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ partId: partId, viewFlag: isViewable })
    })
    .then(response => response.text())
    .then(result => {
        console.log('View flag updated:', result);
    })
    .catch(error => console.error('Error:', error));
}



document.getElementById('addPartForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission
    const courseId = document.getElementById('cours').value;
    const formData = new FormData(this);
    formData.append('courseId', courseId); // Append the selected course ID to the form data

    fetch('../../controllers/addPartController.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        console.log(result); // Log the server response
        fetchParts(courseId); // Optionally refresh the list of parts
    })
    .catch(error => console.error('Error:', error));
});


function removePart(partId, courseId) {
    if (!confirm('Are you sure you want to remove this part?')) {
        return; // Stop the function if the user cancels the action
    }

    fetch('../../controllers/removePartController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ partId: partId })
    })
    .then(response => response.text())
    .then(result => {
        console.log(result);
        fetchParts(courseId); // Refresh parts list after deletion
    })
    .catch(error => console.error('Error:', error));
}

// Add this inside your fetchParts function, within the forEach loop that generates part items
document.querySelectorAll('.remove-part').forEach(item => {
    item.addEventListener('click', function() {
        const partId = this.getAttribute('data-part-id');
        console.log("trying to remove part");
        removePart(partId, courseId);
    });
});
