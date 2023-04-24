function editProject(pid) {
    // Show a popup dialog to edit the project details
    var title = prompt("Enter project title:");
    var start_date = prompt("Enter project start date:");
    var end_date = prompt("Enter project end date:");
    var phase = prompt("Enter project phase:");
    var description = prompt("Enter project description:");

    // Send the edited project details to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "editproject.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Reload the project list to show the updated project details
            window.location.reload();
        }
    };
    xhr.send("id=" + pid + "&title=" + title + "&start_date=" + start_date + "&end_date=" + end_date + "&phase=" + phase + "&description=" + description);
}
