<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    padding-top: 69px;
}

.logo{
    font-size: 20px;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    cursor: pointer;
    transition: color 0.3s ease;
    width:20%;
}

.logo:hover {
    color: #009688;
}

.navbar {
    background-color: #333;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    width: 100%; 
    z-index: 1000; 
}

.navbar ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

.navbar ul li {
    position: relative;
}

.navbar ul li a {
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    display: block;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.navbar ul li a:hover {
    background-color: #575757;
    border-radius: 5px;
}

.navbar ul li::after {
    content: '';
    height: 3px;
    width: 0%;
    background: #009688;
    position: absolute;
    left: 0;
    bottom: -10px;
    transition: 0.5s;
}

.navbar ul li:hover::after {
    width: 100%;
}

</style>

<div class="navbar">
    <a class="logo" href="home.php">Huan Fitness</a>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Physical Training</a></li>
                <li><a href="#">Membership</a></li>
                <li><a href="view_booking.php">Book Now</a></li>
            </ul>
        </div>
