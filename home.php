<?php
require 'connect.php'
?>

<html>
    <head>
        <title>Huan Fitness</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box; /* Added for better box sizing */
    font-family: sans-serif;
}

body {
    background: white;
    height: 100vh;
    margin: 0;
}

.container {
    margin: 70px auto;
    margin-top: 0;
    height: auto;
    overflow: auto;
    display: flex;
    justify-content: center;
    border-radius: 20px;
    box-shadow: 0 4px 8px rgba(0.2, 0.2, 0.2, 0.2);
    width: 70%; 
}

.box {
    width: 100%;
    height: auto; 
    position: relative;
    background-color: rgb(236, 239, 240);
    padding: 20px; 
}

.navbar {
    width: 90%;
    margin: auto;
    padding: 30px 0; 
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.navbar ul li {
    list-style: none;
    display: inline-block;
    margin: 0 20px;
    position: relative;
}

.navbar ul li a {
    text-decoration: none;
    color: black;
    text-transform: uppercase;
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

.content {
    position: relative; 
    width: 100%;
    text-align: left; 
    color: black;
}

.content h1 {
    font-size: 35px;
    margin-left: 5%;
    color: #000000a5;
}

button {
    width: 200px;
    padding: 15px 0;
    text-align: center;
    margin: 20px 10px;
    border-radius: 25px;
    font-weight: bold;
    border: 2px solid #aaa0eee4;
    background: transparent;
    color: black;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

span {
    background: #aaa0eee4;
    height: 100%;
    width: 0%;
    border-radius: 25px;
    position: absolute;
    left: 0;
    bottom: 0;
    z-index: -1;
    transition: 0.5s;
}

button:hover span {
    width: 100%;
}

button:hover {
    border: none;
}

.card {
    display: flex;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.4);
    padding: 20px;
    max-width: 800px;
    margin: 20px auto;
}
.date {
    width: 70px;
    text-align: center;
    border-right: 1px solid #e0e0e0;
    padding-right: 15px;
}
.date .day {
    font-size: 36px;
    font-weight: bold;
    color: #6366F1;
}
.date .month {
    font-size: 16px;
    color: #4B5563;
}

.details {
    flex-grow: 1;
    padding-left: 15px;
}

.exercise-routine {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #111827;
}
.water-consumtion, .body-weight {
    font-size: 14px;
    color: #6B7280;
}
.update-btn {
    width: 100px;
    margin-top: 10px;
    margin-left:65%;
    font-size: 14px;
    background-color: #aaa0eee4;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    text-align: center;
    display: block;
}
.update-btn:hover {
    background-color: #26dc5d;
}

.delete-btn {
    width: 100px;
    margin-top: -6.75%;
    float: right;
    font-size: 14px;
    background-color: #aaa0eee4;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    text-align: center;
    display: block;
}
.delete-btn:hover {
    background-color: #fb0400;
}

.add-btn {
    width: 62px;
    font-size: 20px;
    margin-left: 45%;
    background-color: #aaa0eee4;
    color: white;
    border: none;
    border-radius: 200px;
    padding: 20px 10px;
    cursor: pointer;
    text-align: center;
    display: block;
}
/*.date-list {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 90%;
    border-radius: 10px;
    margin: 20px auto; 
    background: #fff;
    padding: 1rem;
    box-shadow: 0 25px 50px 0 rgba(0, 0, 0, .2), 0 5px 15px 0 rgba(0, 0, 0, .15);
}

.list {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.information {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
}
*/

/*
.form {
    flex: 1; 
    padding: 20px;
    max-width: 400px; 
}

.form h2 {
    text-align: center;
    color: #333;
    margin-bottom: 15px;
}

.form label {
    font-weight: bold;
    margin-top: 10px;
    display: block;
}

.form input, .form textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.form input[type="submit"] {
    background-color: #9283f2;
    color: white;
    border: none;
    cursor: pointer;
    width: 100%;
    padding: 10px;
    border-radius: 5px;
}

.form input[type="submit"]:hover {
    background-color: #8367e2;
}*/
    </style>
    <body>
        <div class="navbar">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Physical Training</a></li>
                <li><a href="#">Membership</a></li>
                <li><a href="#">Book Now</a></li>
            </ul>
        </div>

            <div class="box">

                <div class="content">
                    <h1>Dashboard</h1>

                    <div class="card">
                        <div class="details">
                            <div class="exercise-routine"></div>
                            <div class="water-consumtion"></div>
                            <div class="body-weight"></div>
                            <button class="add-btn">+</button>
                        </div>
                    </div> 

                    <div class="card">
                        <div class="date">
                            <div class="day">22</div>
                            <div class="month">Nov</div>
                        </div>
                        <div class="details">
                            <div class="exercise-routine">Exercise Routine: Jogging</div>
                            <div class="water-consumtion">Water Consumtion: 2 litters</div>
                            <div class="body-weight">Body Weight(kg): 20</div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="date">
                            <div class="day">22</div>
                            <div class="month">Nov</div>
                        </div>
                        <div class="details">
                            <div class="exercise-routine">Exercise Routine: Jogging</div>
                            <div class="water-consumtion">Water Consumtion: 2 litters</div>
                            <div class="body-weight">Body Weight(kg): 20</div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>

                    <div class="card">
                        <div class="date">
                            <div class="day">22</div>
                            <div class="month">Nov</div>
                        </div>
                        <div class="details">
                            <div class="exercise-routine">Exercise Routine: Jogging</div>
                            <div class="water-consumtion">Water Consumtion: 2 litters</div>
                            <div class="body-weight">Body Weight(kg): 20</div>
                            <button class="update-btn">Update</button>
                            <button class="delete-btn">Delete</button>
                        </div>
                    </div>

                </div>
            </div>

    </body>
</html>