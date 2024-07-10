document.addEventListener('DOMContentLoaded', function() {
    checkForRequests();
});

function checkForRequests() {
    fetch('../../controllers/fetchRequestsForProf.php')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                document.getElementById('notif').hidden = false;
            }
        })
        .catch(error => {
            console.error('Error fetching requests:', error);
        });
}
