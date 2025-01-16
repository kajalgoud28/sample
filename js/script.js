
// Basic cart functionality
let cart = [];

function addToCart(products) {
    cart.push(products);
    alert(`${products.name} has been added to your cart!`);
}

document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.add-to-cart');
    buttons.forEach(button => {
        button.addEventListener('click', (event) => {
            const productElement = event.target.closest('.product');
            const product = {
                name: productElement.querySelector('h3').innerText,
                price: productElement.querySelector('.price').innerText,
                image: productElement.querySelector('img').src
            };
            addToCart(product);
        });
    });
});

function bookAppointment() {
    window.location.href = 'booking.php';
}

