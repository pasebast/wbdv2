<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - Contact Us</title>
    <link rel="stylesheet" href="sty.css"> <!-- Link to your external stylesheet -->
</head>
<body>
    <div class="main">
        <div class="navbar">
            <div class="icon">
               <img src="images/logo01.png" alt="Logo">
            </div>
             <div class="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="aboutus.php">About</a></li>
                </ul>
            </div>
        </div>

        <div class="content" style="
    width: 1200px;
    margin: auto;
    padding: 20px;
    color: #964B00;
">
            <h1 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    font-size: 36px;
    text-align: center;
    margin-bottom: 20px;
">Contact Us</h1>
            <div class="contact-container" style="
    display: flex;
    justify-content: space-between;
    padding: 20px;
">
                <div class="contact-info" style="
    width: 45%;
">
                    <h2 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #964B00;
    font-size: 24px;
    margin-bottom: 15px;
">Get in Touch</h2>
                    <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 16px;
    line-height: 1.6;
">If you have any questions or would like to get in touch with us, please use the contact form below or reach out via the contact details provided.</p>
                    <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 16px;
"><strong>Email:</strong> contact@cafesolstice.com</p>
                    <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 16px;
"><strong>Phone:</strong> +123 456 7890</p>
                    <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 16px;
"><strong>Address:</strong> Tamaraw Hills, 120 MacArthur Highway, Valenzuela, 1440 Metro Manila</p>
                </div>
                <div class="contact-form" style="
    width: 45%;
">
                    <h2 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #964B00;
    font-size: 24px;
    margin-bottom: 15px;
">Contact Form</h2>
                    <form action="submit_form.php" method="POST" style="
    display: flex;
    flex-direction: column;
">
                        <label for="name" style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    margin: 10px 0 5px;
">Name:</label>
                        <input type="text" id="name" name="name" required style="
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #964B00;
    margin-bottom: 10px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
">
                        
                        <label for="email" style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    margin: 10px 0 5px;
">Email:</label>
                        <input type="email" id="email" name="email" required style="
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #964B00;
    margin-bottom: 10px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
">
                        
                        <label for="message" style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    margin: 10px 0 5px;
">Message:</label>
                        <textarea id="message" name="message" rows="5" required style="
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #964B00;
    margin-bottom: 10px;
    font-family: 'Comic Sans MS', cursive, sans-serif;
"></textarea>
                        
                        <button type="submit" class="submit-button" style="
    background-color: #964B00; /* Dark brown background */
    color: #FFFFFF; /* White text color */
    border: none; /* Remove default border */
    padding: 10px 15px; /* Padding for button */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    font-size: 16px; /* Font size */
    font-family: 'Comic Sans MS', cursive, sans-serif; /* Font style */
    transition: background-color 0.3s ease; /* Smooth background color transition */
">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>
