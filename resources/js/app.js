import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// Ambil URL dari atribut data
var addToCartButtons = document.querySelectorAll('.add-to-cart');

addToCartButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var endpoint = button.getAttribute('data-url'); // Fetch the URL from the 'data-url' attribute
        // Perform actions with the endpoint URL
        // For example, send a POST request to this endpoint
    });
});

