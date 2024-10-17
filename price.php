<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="pricingTable">
        <div class="pricingTable-title">Pricing Plans</div>
        <div class="pricingTable-subtitle">Choose the plan that suits you</div>
        <ul class="pricingTable-firstTable">
            <li class="pricingTable-firstTable_table">
                <div class="pricingTable-firstTable_table__header">Basic Plan</div>
                <div class="pricingTable-firstTable_table__pricing">RM50<span>/month</span></div>
                <ul class="pricingTable-firstTable_table__options">
                    <li>Full-body strength workout</li>
                    <li>No equipment needed</li>
                    <li>Quick and effective routine</li>
                </ul>
                <button class="pricingTable-firstTable_table__getstart">Get Started</button>
            </li>
        </ul>
    </div>
</body>
</html>
<?php

$pricingPlans = array(
    array(
        'title' => 'Junior Coach',
        'price' => 65,
        'options' => array('High-calorie burn', 'Intense cardio intervals', 'Boost endurance')
    ),
    array(
        'title' => 'Elite Coach',
        'price' => 75,
        'options' => array('Improve flexibility', 'Focus on stretching and mobility', 'Relaxing and restorative')
    ),
    array(
        'title' => 'Master Coach',
        'price' => 100,
        'options' => array('Comprehensive strength and cardio mix', 'Functional training', 'Group motivation')
    )
);

echo '<div class="pricingTable">';
echo '<h2 class="pricingTable-title">Find a plan that\'s right for you.</h2>';
echo '<h3 class="pricingTable-subtitle">Every plan comes with a 30-day free trial.</h3>';

echo '<ul class="pricingTable-firstTable">';
foreach ($pricingPlans as $plan) {
    echo '<li class="pricingTable-firstTable_table">';
    echo '<h1 class="pricingTable-firstTable_table__header">' . $plan['title'] . '</h1>';
    echo '<p class="pricingTable-firstTable_table__pricing"><span>RM</span><span>' . $plan['price'] . '</span><span>/Month</span></p>';
    echo '<ul class="pricingTable-firstTable_table__options">';
    foreach ($plan['options'] as $option) {
        echo '<li>' . $option . '</li>';
    }
    echo '</ul>';
    echo '<button class="pricingTable-firstTable_table__getstart">Get Started Now</button>';
    echo '</li>';
}
echo '</ul>';
echo '</div>';
?>