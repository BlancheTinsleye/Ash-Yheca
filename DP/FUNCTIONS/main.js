function close_menu() {
    document.getElementById('menu_cont').style.display = 'none';
}

function close_question() {
    document.getElementById('logout_cont').style.display = 'none';
}

document.getElementById("logout_btn").addEventListener("click", function() {
    // Show the notification
    let logout = document.getElementById("logout_cont");
    logout.style.display = "flex";
    
});

document.getElementById("menu_icon").addEventListener("click", function() {
    // Show the notification
    let menu_cont = document.getElementById("menu_cont");
    menu_cont.style.display = "flex";
    
});

function changeLanguage(language) {
    fetch('../FUNCTIONS/language.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `language=${language}`
    })
    .then(response => location.reload()); // Reloads the page to apply the new language
}

function calculateTotal() {
    var price = parseFloat(document.getElementById('price').value);
    var quantity = parseInt(document.getElementById('quantity').value);
    document.getElementById('total').value = price * quantity;
}

// Cancel order action
function cancelOrder() {
    alert('Order has been cancelled.');
}

// Submit form action (currently just an alert)
function submitForm() {
    alert('Order placed successfully.');
}

function setActive(element) {
    // Remove 'active' class from all nav items
    document.querySelectorAll('.material-symbols-outlined').forEach(item => {
        item.classList.remove('active');
    });
    // Add 'active' class to the clicked nav item
    element.classList.add('active');
}

document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        let checkedProducts = JSON.parse(localStorage.getItem('checkedProducts')) || [];

        if (this.checked) {
            const quantity = this.closest('.prdct_cont').querySelector('input[name="quantity"]').value;
            checkedProducts.push({
                cart_id: this.dataset.cartId,
                product_id: this.dataset.productId,
                name: this.dataset.name,
                price: this.dataset.price,
                img: this.dataset.img,
                quantity: quantity
            });
        } else {
            checkedProducts = checkedProducts.filter(product => product.cart_id !== this.dataset.cartId);
        }

        localStorage.setItem('checkedProducts', JSON.stringify(checkedProducts));
        document.cookie = "checkedProducts=" + JSON.stringify(checkedProducts) + "; path=/";
    });
});




function clearLocalStorage() {
    localStorage.clear();
    console.log("Local storage cleared.");
}


