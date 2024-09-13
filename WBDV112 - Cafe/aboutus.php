<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Solstice - About Us</title>
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
            <h2 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    font-size: 36px;
    text-align: center;
    margin-bottom: 20px;
">About Us</h2>

            <section style="
    margin-bottom: 40px;
">
                <h2 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #964B00;
    font-size: 28px;
    margin-bottom: 15px;
    text-align: center;
">Our Story</h2>
                <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 16px;
    line-height: 1.6;
    text-align: center;
    max-width: 800px;
    margin: auto;
">At Café Solstice, we believe in crafting moments of joy and relaxation through our exquisite coffee and pastries. Founded in 2023, our café is dedicated to providing a warm and welcoming atmosphere where every customer can experience a touch of elegance and comfort. From our carefully sourced beans to our handcrafted desserts, every detail is designed with passion and care. Join us and be part of our story!</p>
            </section>

            <section style="
    margin-bottom: 40px;
">
                <h2 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #964B00;
    font-size: 28px;
    margin-bottom: 15px;
    text-align: center;
">Meet Our Team</h2>
                <div style="
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
">
                    <div style="
    width: 30%;
    text-align: center;
">
                        <img src="images/pic01.jpg" alt="Team Member 1" style="
    max-width: 100%;
    height: auto;
    border: 3px solid rgba(0, 0, 0, 0.3); /* Slightly visible border */
    border-radius: 10px; /* Curved corners */
    margin-bottom: 10px;
">
                        <h3 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 20px;
    margin-bottom: 5px;
">Alice Guo</h3>
                        <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #000000;
    font-size: 16px;
">Founder & Head Barista</p>
                    </div>
                    <div style="
    width: 30%;
    text-align: center;
">
                        <img src="images/pic02.jpg" alt="Team Member 2" style="
    max-width: 100%;
    height: auto;
    border: 3px solid rgba(0, 0, 0, 0.3); /* Slightly visible border */
    border-radius: 10px; /* Curved corners */
    margin-bottom: 10px;
">
                        <h3 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 20px;
    margin-bottom: 5px;
">Winston Churchill</h3>
                        <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #000000;
    font-size: 16px;
">Pastry Chef</p>
                    </div>
                    <div style="
    width: 30%;
    text-align: center;
">
                        <img src="images/pic03.jpg" alt="Team Member 3" style="
    max-width: 300px;
    height: auto;
    border: 3px solid rgba(0, 0, 0, 0.3); /* Slightly visible border */
    border-radius: 10px; /* Curved corners */
    margin-bottom: 10px;
">
                        <h3 style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #664228;
    font-size: 20px;
    margin-bottom: 5px;
">René Descartes</h3>
                        <p style="
    font-family: 'Comic Sans MS', cursive, sans-serif;
    color: #000000;
    font-size: 16px;
">Customer Service</p>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include('footer.php'); ?>

</body>
</html>
