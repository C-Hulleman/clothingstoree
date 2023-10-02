var inactivityTimeout = null;

function resetInactivityTimeout() {
    if (inactivityTimeout) {
        clearTimeout(inactivityTimeout);
    }

    inactivityTimeout = setTimeout(function() {
        window.location.href = "logout.php";
    }, 300000); // 300000 milliseconds (5 minutes)
}

// Track user activity and reset the inactivity timeout
document.addEventListener("mousemove", resetInactivityTimeout);
document.addEventListener("keydown", resetInactivityTimeout);
document.addEventListener("click", resetInactivityTimeout);

// Initial call to start the inactivity timer
resetInactivityTimeout();