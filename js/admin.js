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

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("add-product-tab").addEventListener("click", function () {
        showTab("add-product-content");
    });
    document.getElementById("request-product-tab").addEventListener("click", function () {
        showTab("request-product-content");
    });

    function showTab(tabId) {
        const tabs = document.querySelectorAll(".tab-content");
        tabs.forEach(function (tab) {
            tab.style.display = "none";
        });
        document.getElementById(tabId).style.display = "block";
    }
});

        // JavaScript-code om tabbladen te beheren
        document.getElementById("add-product-tab").addEventListener("click", function() {
            document.getElementById("add-product-content").classList.add("active-tab");
            document.getElementById("request-product-content").classList.remove("active-tab");
        });

        document.getElementById("request-product-tab").addEventListener("click", function() {
            document.getElementById("add-product-content").classList.remove("active-tab");
            document.getElementById("request-product-content").classList.add("active-tab");
        });
        