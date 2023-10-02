const adminButton = document.querySelector('.admin-button');

document.addEventListener('mousemove', (e) => {
    // Check if the mouse is in the top-right corner
    if (e.clientX >= window.innerWidth - 100 && e.clientY <= 100) {
        adminButton.style.display = 'inline-block';
    } else {
        adminButton.style.display = 'none';
    }
});
document.addEventListener("DOMContentLoaded", function() {
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    const cart = [];

    addToCartButtons.forEach(button => {
        button.addEventListener("click", function() {
            const productId = button.getAttribute("data-product-id");

            // Add the product to the cart (you can customize this logic)
            cart.push(productId);

            // Update the cart icon or perform other actions
            alert("Product added to cart!");

            // You can also send the cart data to the server for processing
            // Example: sendCartToServer(cart);
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = button.getAttribute('data-product-id');
            const productName = button.getAttribute('data-product-name');

            // Check if productId and productName are valid
            if (productId !== null && productName !== null) {
                // Send an AJAX request to a PHP script to add the product to the cart
                // Replace 'add_to_cart.php' with the actual URL of your PHP script
                const url = 'add_to_cart.php?product_id=' + productId + '&product_name=' + encodeURIComponent(productName);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(productName + ' has been added to your cart.');
                    } else {
                        alert('Failed to add ' + productName + ' to your cart.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while adding ' + productName + ' to your cart.');
                });
            }
        });
    });
});
    // Function to check if the mouse is within 5 centimeters of the admin button
    function isMouseNearAdminButton(event) {
        const adminButton = document.getElementById("admin-button");
        const rect = adminButton.getBoundingClientRect();
        const mouseX = event.clientX;
        const mouseY = event.clientY;

        // Calculate the distance between the mouse pointer and the admin button
        const distance = Math.sqrt(
            Math.pow(mouseX - (rect.left + rect.width / 2), 2) +
            Math.pow(mouseY - (rect.top + rect.height / 2), 2)
        );

        // Adjust this value (50) as needed to define the proximity threshold
        return distance <= 50;
    }

    // Event listener to toggle the visibility of the admin button
    document.body.addEventListener("mousemove", function (event) {
        const adminButton = document.getElementById("admin-button");

        if (isMouseNearAdminButton(event)) {
            adminButton.style.display = "inline-block";
        } else {
            adminButton.style.display = "none";
        }
    });