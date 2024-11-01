<?php
// Initialize session and cart, etc.
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $first_name = trim($_POST['firstname']); // Trim any leading/trailing spaces
    $last_name = trim($_POST['lastname']); // Trim any leading/trailing spaces
    $email = $_POST['email'];
    $address = $_POST['address'];
    $payment = $_POST['payment'];
    $expiry_date = !empty($_POST['expiry_date']) ? $_POST['expiry_date'] : NULL;
    $cvc = $_POST['cvc'];

    // Server-side validation
    if (!preg_match("/^[a-zA-Z.\s]{2,50}$/", $first_name) || preg_match("/^[.\s]*$/", $first_name) || strlen($first_name) == 0) {
        $error = "First Name should be 2-50 characters long, can contain letters, spaces, and periods, but cannot consist solely of periods or spaces.";
    } elseif (!preg_match("/^[a-zA-Z.\s]{2,50}$/", $last_name) || preg_match("/^[.\s]*$/", $last_name) || strlen($last_name) == 0) {
        $error = "Last Name should be 2-50 characters long, can contain letters, spaces, and periods, but cannot consist solely of periods or spaces.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($payment && !preg_match("/^\d{4}-\d{4}-\d{4}-\d{4}$/", $payment)) {
        $error = "Invalid Card Number. It should be in the 16-digit format XXXX-XXXX-XXXX-XXXX.";
    } elseif ($expiry_date && !preg_match("/^(0[1-9]|1[0-2])\/?([0-9]{2})$/", $expiry_date)) {
        $error = "Invalid Expiry Date. It should be in the format MM/YY.";
    } elseif ($cvc && !preg_match("/^\d{3}$/", $cvc)) {
        $error = "Invalid CVC. It should be a 3-digit number.";
    } else {
        // Existing logic for handling registration
    }
}



// Get the current page filename
$current_page = basename($_SERVER['REQUEST_URI']);
?>

<!-- register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Café Solstice</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
	<link rel="stylesheet" href="sty.css">

<style>
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    border-radius: 10px;
}

/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}


</style>	
	
</head>
<body>

    <div class="main">
        <div class="navbar">
            <div class="icon">
               <img src="images/logo01.png" alt="Logo">
            </div>

            <div class="menu">
                <ul>
                    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="menu.php" class="<?php echo ($current_page == 'menu.php') ? 'active' : ''; ?>">Menu</a></li>
                    <li><a href="gallery.php" class="<?php echo ($current_page == 'gallery.php') ? 'active' : ''; ?>">Gallery</a></li>
                    <li><a href="contact.php" class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
                    <li><a href="aboutus.php" class="<?php echo ($current_page == 'aboutus.php') ? 'active' : ''; ?>">About</a></li>
                </ul>
            </div>
        </div>
 <!-- Background Image -->
    <img src="images/coffee02.jpg" alt="Coffee Background" class="background-image"> <!-- Add this line -->

         <!-- Registration Section -->
        <div class="register-container">
            <!-- Welcome Message and Instructions -->
            <div class="intro">
                <h1>Welcome to Café Solstice !</h1>
                <p>We’re excited to have you join us. Please fill out the form below to create your account. Make sure to use a valid email address, as you’ll need it to activate your account.</p>
            </div>

            <!-- Flex Container for Content -->
            <div class="register-content">
                <!-- Additional Information Section -->
                <div class="register-info">
                    <h2>Why Register?</h2>
                    <p>Registering with us gives you access to exclusive content, personalized recommendations, and the ability to connect with our vibrant community. Don't miss out on the opportunity to stay updated with the latest news and events.</p>
                    <h2>Membership Benefits</h2>
                    <p>As a member, you’ll enjoy special discounts, early access to events, and the opportunity to participate in our forums and discussions. We value our community and strive to provide the best experience for our members.</p>
                    <h2>Need Help?</h2>
                    <p>If you have any questions or encounter any issues while registering, feel free to reach out to our support team at <a href="mailto:contact@cafesolstice.com">contact@cafesolstice.com</a>. We’re here to help!</p>
                </div>

                <!-- Registration Form Section -->
                <div class="register-form">
                    <form action="register_process.php" method="POST" onsubmit="return validateFormAndPayment()">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Choose a Username" required required pattern="^[a-zA-Z0-9_.]{4,50}$" title="Username should be 4-50 characters long and can only contain letters, numbers, periods, and underscores.">

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Your Email Address" required required pattern="^[a-zA-Z0-9_.@]{4,50}$" title="Email should be 4-50 characters long and can only contain letters, numbers, @, periods, and underscores.">

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" placeholder="Create a Password" required>

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>

						<label for="firstname">First Name:</label>
						<input type="text" id="firstname" name="firstname" placeholder="Your First Name" required pattern="^[a-zA-Z.\s]{2,50}$" title="First Name should be 2-50 characters long and can only contain letters, spaces, and periods.">

						<label for="lastname">Last Name:</label>
						<input type="text" id="lastname" name="lastname" placeholder="Your Last Name" required pattern="^[a-zA-Z.\s]{2,50}$" title="Last Name should be 2-50 characters long and can only contain letters, spaces, and periods.">

						<label for="address">Address:</label>
						<input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
						<div id="map" style="height: 300px;"></div>
						<input type="hidden" id="lat" name="lat">
						<input type="hidden" id="lng" name="lng">


						<div class="checkbox-wrapper">
						<label for="add_payment" class="checkbox-label">Add A Payment Method?</label>
						<input type="checkbox" id="add_payment" name="add_payment" onclick="togglePaymentFields()" style="width: 20px; height: 20px;">
						</div>

						<div id="payment_fields" style="display:none;">
						<label for="payment">Payment Method:</label>
						<input type="text" id="payment" name="payment" placeholder="____-____-____-____" pattern="\d{4}-\d{4}-\d{4}-\d{4}" title="Enter a valid 16-digit card number or leave it blank." maxlength="19" oninput="formatCardNumber(this)">

						<label for="expiry_date">Expiry Date (MM/YY):</label>
						<input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/?([0-9]{2})$" title="Please enter a valid expiry date in MM/YY format." maxlength="5" oninput="formatExpiryDate(this)" onblur="validateExpiryDate(this)">

						<label for="cvc">CVC:</label>
						<input type="text" id="cvc" name="cvc" placeholder="CVC" maxlength="3" pattern="^\d{3}$" title="Please enter a valid 3-digit CVC code.">
						</div>
						
						
                        <button type="submit" class="btnn">Register</button>


                    </form>
					
					
<!-- Loading Spinner -->
<div id="loadingSpinner" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9999; text-align: center;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="loader"></div>
        <p style="color: white;">Loading...</p>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="successMessage">Registration successful! Redirecting to homepage...</p>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="errorMessage"></p>
    </div>
</div>


                </div>
            </div>
			</div>
			
    </div>

<script>

document.addEventListener('DOMContentLoaded', (event) => {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const success = urlParams.get('success');
    if (error) {
        showModal(decodeURIComponent(error));
    }
    if (success) {
        showSuccessModal(decodeURIComponent(success));
    }
});

function showModal(message) {
    var modal = document.getElementById('errorModal');
    var span = document.getElementsByClassName('close')[0];
    var errorMessage = document.getElementById('errorMessage');

    errorMessage.innerText = message;
    modal.style.display = 'block';

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
}

function showSuccessModal(message) {
    // Hide loading spinner
    document.getElementById('loadingSpinner').style.display = 'none';

    var modal = document.getElementById('successModal');
    var span = document.getElementsByClassName('close')[1]; // Get the close element for success modal
    var successMessage = document.getElementById('successMessage');

    successMessage.innerText = message;
    modal.style.display = 'block';

    span.onclick = function() {
        modal.style.display = 'none';
        window.location.href = 'index.php';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
            window.location.href = 'index.php';
        }
    }

    setTimeout(() => {
        window.location.href = 'index.php';
    }, 5000);
}
function togglePaymentFields() {
    var paymentFields = document.getElementById('payment_fields');
    var addPaymentCheckbox = document.getElementById('add_payment');

    if (addPaymentCheckbox.checked) {
        paymentFields.style.display = 'block';
    } else {
        paymentFields.style.display = 'none';
        document.getElementById('payment').value = '';
        document.getElementById('expiry_date').value = '';
        document.getElementById('cvc').value = '';
    }
}

function formatExpiryDate(input) {
    const value = input.value.replace(/\D/g, '');
    const formattedValue = value.replace(/(\d{2})(\d+)/, '$1/$2');
    input.value = formattedValue;
}

function validateExpiryDate(input) {
    const value = input.value;
    if (value) {
        const parts = value.split('/');
        const month = parseInt(parts[0], 10);
        const year = parseInt(parts[1], 10) + 2000;
        const now = new Date();
        const currentYear = now.getFullYear();
        const currentMonth = now.getMonth() + 1;
        if (year < currentYear || (year === currentYear && month < currentMonth)) {
            showModal('The card has expired. Please enter a valid expiry date.');
            input.value = '';
        }
    }
}
function validateFormAndPayment() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var firstName = document.getElementById("firstname").value;
    var lastName = document.getElementById("lastname").value;
    var addPaymentCheckbox = document.getElementById('add_payment');
    var payment = document.getElementById('payment').value;
    var expiry_date = document.getElementById('expiry_date').value;
    var cvc = document.getElementById('cvc').value;
    var errorMessage = '';

    // Validate username
    var usernameRegex = /^[a-zA-Z0-9_.]{4,50}$/;
    if (!usernameRegex.test(username)) {
        showModal("Invalid username. It should be 4-50 characters long and can only contain letters, numbers, periods, and underscores.");
        return false;
    }

    // Validate email
    var emailRegex = /^[a-zA-Z0-9_.@]{4,50}$/;
    if (!emailRegex.test(email)) {
        showModal("Invalid email. It should be 4-50 characters long and can only contain letters, numbers, @, periods, and underscores.");
        return false;
    }

    // Validate first name
    var nameRegex = /^[a-zA-Z.\s]{2,50}$/;
    if (!nameRegex.test(firstName) || firstName.replace(/[.\s]/g, '').length === 0) {
        showModal("Invalid First Name. It should be 2-50 characters long, can contain letters, spaces, and periods, but cannot consist solely of periods or spaces.");
        return false;
    }

    // Validate last name
    if (!nameRegex.test(lastName) || lastName.replace(/[.\s]/g, '').length === 0) {
        showModal("Invalid Last Name. It should be 2-50 characters long, can contain letters, spaces, and periods, but cannot consist solely of periods or spaces.");
        return false;
    }

    // Validate password
    if (password.length < 8) {
        errorMessage = 'Password must be at least 8 characters long.';
    } else if (!/[A-Z]/.test(password)) {
        errorMessage = 'Password must include at least 1 uppercase letter.';
    } else if (!/[a-z]/.test(password)) {
        errorMessage = 'Password must include at least 1 lowercase letter.';
    } else if (!/[0-9]/.test(password)) {
        errorMessage = 'Password must include at least 1 number.';
    } else if (password !== confirmPassword) {
        errorMessage = 'Passwords do not match. Please try again.';
    }

    if (errorMessage) {
        showModal(errorMessage);
        return false;
    }

    // Validate payment fields if checkbox is checked
    if (addPaymentCheckbox.checked) {
        if (payment === '') {
            showModal('Please enter a valid 16-digit card number.');
            return false;
        }
        if (expiry_date === '' || !/^\d{2}\/\d{2}$/.test(expiry_date)) {
            showModal('Please enter a valid expiry date in MM/YY format.');
            return false;
        }
        if (cvc === '' || !/^\d{3}$/.test(cvc)) {
            showModal('Please enter a valid 3-digit CVC code.');
            return false;
        }
    }

    // Show loading spinner
    document.getElementById('loadingSpinner').style.display = 'block';
    return true;
}


function formatCardNumber(input) {
    const value = input.value.replace(/\D/g, ''); // Remove all non-digit characters
    const formattedValue = value.match(/.{1,4}/g)?.join('-') || ''; // Format as XXXX-XXXX-XXXX-XXXX
    input.value = formattedValue;
}


</script>


<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Initialize the map with the new coordinates
    var map = L.map('map').setView([14.6789128, 120.9835721], 15); // Set to your new coordinates

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Set the default marker at the new location
    var marker = L.marker([14.6789128, 120.9835721]).addTo(map);

    // Function to set marker and pan map
    function setMarkerAndPan(lat, lng) {
        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng]).addTo(map);
        map.setView([lat, lng], 15);
    }

    // On map click, add a marker and get the address
    map.on('click', function(e) {
        setMarkerAndPan(e.latlng.lat, e.latlng.lng);
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${e.latlng.lat}&lon=${e.latlng.lng}&format=json`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    document.getElementById('address').value = data.display_name;
                }
            })
            .catch(err => console.error(err));
    });

    // Geocode the address when the user types in the input field
    document.getElementById('address').addEventListener('change', function() {
        const address = this.value;
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const { lat, lon } = data[0];
                    setMarkerAndPan(lat, lon);
                    document.getElementById('address').value = data[0].display_name;
                } else {
                    alert("Address not found. Please try again.");
                }
            })
            .catch(err => console.error(err));
    });

   
</script>

<!-- Include the footer -->
    <?php include('footer.php'); ?>


</body>
</html>
