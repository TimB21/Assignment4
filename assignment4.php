<?php

define("_RADIO_FIELD_INDEX_", 0);
define("_RADIO_OPTIONS_INDEX_", 1);
define("_RESULT_LIMIT_", 25);

require_once 'vendor/autoload.php';
require_once('formModel.lib');
require_once('inputTags.lib');

//use Exception; // In the global namespace, so this is not needed
use MongoDB\Client;
use MongoDB\Driver\ServerApi;

// This array contains all valid amenities values
$amenities = array();
$amenities[] = "24-hour check-in";
$amenities[] = "Accessible-height bed";
$amenities[] = "Accessible-height toilet";
$amenities[] = "Air conditioning";
$amenities[] = "Air purifier";
$amenities[] = "Alfresco shower";
$amenities[] = "BBQ grill";
$amenities[] = "Baby bath";
$amenities[] = "Baby monitor";
$amenities[] = "Babysitter recommendations";
$amenities[] = "Balcony";
$amenities[] = "Bath towel";
$amenities[] = "Bathroom essentials";
$amenities[] = "Bathtub";
$amenities[] = "Bathtub with bath chair";
$amenities[] = "Beach chairs";
$amenities[] = "Beach essentials";
$amenities[] = "Beach view";
$amenities[] = "Beachfront";
$amenities[] = "Bed linens";
$amenities[] = "Bedroom comforts";
$amenities[] = "Bicycle";
$amenities[] = "Bidet";
$amenities[] = "Body soap";
$amenities[] = "Boogie boards";
$amenities[] = "Breakfast";
$amenities[] = "Breakfast bar";
$amenities[] = "Breakfast table";
$amenities[] = "Building staff";
$amenities[] = "Buzzer/wireless intercom";
$amenities[] = "Cable TV";
$amenities[] = "Carbon monoxide detector";
$amenities[] = "Cat(s)";
$amenities[] = "Ceiling fan";
$amenities[] = "Central air conditioning";
$amenities[] = "Changing table";
$amenities[] = "Chef's kitchen";
$amenities[] = "Children’s books and toys";
$amenities[] = "Children’s dinnerware";
$amenities[] = "Cleaning before checkout";
$amenities[] = "Coffee maker";
$amenities[] = "Convection oven";
$amenities[] = "Cooking basics";
$amenities[] = "Crib";
$amenities[] = "DVD player";
$amenities[] = "Day bed";
$amenities[] = "Dining area";
$amenities[] = "Disabled parking spot";
$amenities[] = "Dishes and silverware";
$amenities[] = "Dishwasher";
$amenities[] = "Dog(s)";
$amenities[] = "Doorman";
$amenities[] = "Double oven";
$amenities[] = "Dryer";
$amenities[] = "EV charger";
$amenities[] = "Electric profiling bed";
$amenities[] = "Elevator";
$amenities[] = "En suite bathroom";
$amenities[] = "Espresso machine";
$amenities[] = "Essentials";
$amenities[] = "Ethernet connection";
$amenities[] = "Extra pillows and blankets";
$amenities[] = "Family/kid friendly";
$amenities[] = "Fax machine";
$amenities[] = "Fire extinguisher";
$amenities[] = "Fireplace guards";
$amenities[] = "Firm mattress";
$amenities[] = "First aid kit";
$amenities[] = "Fixed grab bars for shower";
$amenities[] = "Fixed grab bars for toilet";
$amenities[] = "Flat path to front door";
$amenities[] = "Formal dining area";
$amenities[] = "Free parking on premises";
$amenities[] = "Free street parking";
$amenities[] = "Full kitchen";
$amenities[] = "Game console";
$amenities[] = "Garden or backyard";
$amenities[] = "Gas oven";
$amenities[] = "Ground floor access";
$amenities[] = "Gym";
$amenities[] = "Hair dryer";
$amenities[] = "Handheld shower head";
$amenities[] = "Hangers";
$amenities[] = "Heated towel rack";
$amenities[] = "Heating";
$amenities[] = "High chair";
$amenities[] = "Home theater";
$amenities[] = "Host greets you";
$amenities[] = "Hot tub";
$amenities[] = "Hot water";
$amenities[] = "Hot water kettle";
$amenities[] = "Ice Machine";
$amenities[] = "Indoor fireplace";
$amenities[] = "Internet";
$amenities[] = "Iron";
$amenities[] = "Ironing Board";
$amenities[] = "Kayak";
$amenities[] = "Keypad";
$amenities[] = "Kitchen";
$amenities[] = "Kitchenette";
$amenities[] = "Lake access";
$amenities[] = "Laptop friendly workspace";
$amenities[] = "Lock on bedroom door";
$amenities[] = "Lockbox";
$amenities[] = "Long term stays allowed";
$amenities[] = "Luggage dropoff allowed";
$amenities[] = "Memory foam mattress";
$amenities[] = "Microwave";
$amenities[] = "Mini fridge";
$amenities[] = "Mountain view";
$amenities[] = "Murphy bed";
$amenities[] = "Netflix";
$amenities[] = "Other";
$amenities[] = "Other pet(s)";
$amenities[] = "Outdoor parking";
$amenities[] = "Outdoor seating";
$amenities[] = "Outlet covers";
$amenities[] = "Oven";
$amenities[] = "Pack ’n Play/travel crib";
$amenities[] = "Paid parking off premises";
$amenities[] = "Paid parking on premises";
$amenities[] = "Parking";
$amenities[] = "Patio or balcony";
$amenities[] = "Permit parking";
$amenities[] = "Pets allowed";
$amenities[] = "Pets live on this property";
$amenities[] = "Pillow-top mattress";
$amenities[] = "Pocket wifi";
$amenities[] = "Pool";
$amenities[] = "Pool with pool hoist";
$amenities[] = "Private bathroom";
$amenities[] = "Private entrance";
$amenities[] = "Private hot tub";
$amenities[] = "Private living room";
$amenities[] = "Private pool";
$amenities[] = "Rain shower";
$amenities[] = "Refrigerator";
$amenities[] = "Roll-in shower";
$amenities[] = "Room-darkening shades";
$amenities[] = "Safe";
$amenities[] = "Safety card";
$amenities[] = "Sauna";
$amenities[] = "Self check-in";
$amenities[] = "Shampoo";
$amenities[] = "Shared pool";
$amenities[] = "Shower chair";
$amenities[] = "Single level home";
$amenities[] = "Ski-in/Ski-out";
$amenities[] = "Smart TV";
$amenities[] = "Smart lock";
$amenities[] = "Smoke detector";
$amenities[] = "Smoking allowed";
$amenities[] = "Snorkeling equipment";
$amenities[] = "Sonos sound system";
$amenities[] = "Sound system";
$amenities[] = "Stair gates";
$amenities[] = "Standing valet";
$amenities[] = "Step-free access";
$amenities[] = "Stove";
$amenities[] = "Suitable for events";
$amenities[] = "Sun loungers";
$amenities[] = "Swimming pool";
$amenities[] = "TV";
$amenities[] = "Table corner guards";
$amenities[] = "Tennis court";
$amenities[] = "Terrace";
$amenities[] = "Toaster";
$amenities[] = "Toilet paper";
$amenities[] = "Walk-in shower";
$amenities[] = "Warming drawer";
$amenities[] = "Washer";
$amenities[] = "Washer / Dryer";
$amenities[] = "Waterfront";
$amenities[] = "Well-lit path to entrance";
$amenities[] = "Wheelchair accessible";
$amenities[] = "Wide clearance to bed";
$amenities[] = "Wide clearance to shower";
$amenities[] = "Wide doorway";
$amenities[] = "Wide entryway";
$amenities[] = "Wide hallway clearance";
$amenities[] = "Wifi";
$amenities[] = "Window guards";
$amenities[] = "toilet";

?>

<CENTER>
<H1>Sky BnB</H1>
(Find the perfect travel destination!)
<FORM name="searchform" action="assignment4.php" method="POST">
<TABLE>

<?php   
if (!isset($_POST['submit'])) {
// create associative array to store the fields with single textboxes
$fields = ["name","description","address.street","address.suburb","transit","property_type"];

// loop to create html code for each field with a single textbox
foreach ($fields as $field) { 
    // Handle fields within the "address" category
    if (strpos($field, 'address.') === 0) {
        // Create subcategory
        $subcategory = str_replace('address.', '', $field);
        $category = 'address'; 
        echo '<tr>';
        echo '<td align="right">' . $subcategory . '</td>';
        echo '<td>';
        echo '<input type="text" size="30" name="' . $category . '_' . $subcategory . '" id="' . $category . '_' . $subcategory . '" value="" maxlength="2048">';
        echo '</td>';
        echo '</tr>'; 
        echo "\n";
    } else {
        $category = $field;  
        echo '<tr>';
        echo '<td align="right">' . $category . '</td>';
        echo '<td>';
        echo '<input type="text" size="30" name="' . $category . '" id="' . $category . '" value="" maxlength="2048">';
        echo '</td>';
        echo '</tr>';
    }
} 

// create array to store the fields with two text boxes for a minimum and maximum value 
$fields = ["accommodates","bedrooms","bathrooms","beds","price","cleaning_fee"];

// create loop to create html code for each of the fields with two text boxes 
foreach ($fields as $field) {
    echo '<tr>';
    echo '<td align="right">' . $field . '</td>';
    echo '<td>';
    echo 'between <input type="text" size="3" name="low' . $field . '" id="low' . $field . '" value="" maxlength="5"> and <input type="text" size="3" name="hi' . $field . '" id="hi' . $field . '" value="" maxlength="5">';
    echo '</td>';
    echo '</tr>';
} 

// create associative array for the fields of data with have multiple radioboxes
$fieldValues = [
    "address.country" => ["Any", "Australia", "Brazil", "Canada", "China", "Hong Kong", "Portugal", "Spain", "Turkey", "United States"],
    "room_type" => ["Any", "Entire home/apt", "Private room", "Shared room"],
    "bed_type" => ["Any", "Futon", "Airbed", "Pull-out Sofa", "Real Bed", "Couch"],
    "cancellation_policy" => ["Any", "flexible", "moderate", "strict_14_with_grace_period", "super_strict_30", "super_strict_60"]
];

// loop through entities and create radio boxes for the different options
foreach ($fieldValues as $field => $values) {
    echo '<tr>';
    echo '<td align="right">' . $field . '</td>';
    echo '<td>'; 
    // creates the radio boxes for each of the values within the entity 
    foreach ($values as $value) {
        echo '<input type="radio" name="' . str_replace('.', '_', $field) . '" id="' . str_replace('.', '_', $field) . '" value="' . $value . '"';
        // check the any value       
        if ($value === "Any") {
            echo ' checked';
        }
        echo '>' . $value . ', ';
    }
    echo '</td>';
    echo '</tr>';
}

echo '</TABLE>'; // Close the existing table after the amenities section

echo 'Amenities';  
echo '<div id="div1" style="height: 100px;position:relative;">';
echo '<div id="div2" style="max-height:100%;overflow:auto;border:1px solid black;">';

foreach ($amenities as $amenity) {
    $id = str_replace(' ', '_', $amenity); // Convert spaces to underscores for checkbox ID
    $value = "yes";

    echo '<div class="item">';
    echo '  <input type="checkbox" name="' . $id . '" id="' . $id . '" value="' . $value . '">' . $amenity;
    echo '</div>';
}

echo '</div>';
echo '</div>';

// Start a new table for the sorting criteria
echo '<TABLE>';

// create an array for the sorting criteria 
$criteria = ["accommodates", "bedrooms", "bathrooms", "beds", "price", "cleaning_fee"];

// loop through the sorting criteria and create radio boxes for different sorting options
foreach ($criteria as $criterion) {
    echo '<tr>';
    echo '  <td align="right">' . $criterion . '</td>';
    echo '  <td>';
    echo '    <input type="radio" name="sort_' . $criterion . '" value="No sorting" checked> No sorting,';
    echo '    <input type="radio" name="sort_' . $criterion . '" value="Increasing"> Increasing,';
    echo '    <input type="radio" name="sort_' . $criterion . '" value="Decreasing"> Decreasing';
    echo '  </td>';
    echo '</tr>';
}

echo '</TABLE>'; 
}
?> 

<?php  
// this section runs after the user has submitted the form
if (isset($_POST['submit'])) { 

    // create associative array to store the fields with single textboxes
    $fields = ["name","description","address.street","address.suburb","transit","property_type"]; 

    // loops through array and creates the textboxes with the inputted information if it was provided
    foreach ($fields as $field) {
        if (strpos($field, 'address.') === 0) { 
            $subcategory = str_replace('address.', '', $field);
            $category = 'address'; 
            echo '<tr>';
            echo '  <td align="right">' . $subcategory . '</td>';
            echo '  <td>';
            echo '    <input type="text" size="30" name="' . $category . '_' . $subcategory . '" id="' . $category . '_' . $subcategory . '" value="' . htmlspecialchars($_REQUEST[$category . '_' . $subcategory] ?? '') . '" maxlength="2048">';
            echo '  </td>';
            echo '</tr>';
            echo "\n";
        } else {
            $category = $field;  
            echo '<tr>';
            echo '  <td align="right">' . $category . '</td>';
            echo '  <td>';
            echo '    <input type="text" size="30" name="' . $category . '" id="' . $category . '" value="' . htmlspecialchars($_REQUEST[$category] ?? '') . '" maxlength="2048">';
            echo '  </td>';
            echo '</tr>';
        }
    } 

    // create array to store the fields with two text boxes for a minimum and maximum value 
    $fields = ["accommodates","bedrooms","bathrooms","beds","price","cleaning_fee"];

    // loops through array and creates the low and high textboxes with the inputted information if it was provided 
    foreach ($fields as $field) { 
        // begin creating tags
        echo '<tr>';
        echo '  <td align="right">' . $field . '</td>';
        echo '  <td>';
    
    // check if 'low' value is not empty
    if (!empty($_REQUEST['low' . $field])) {
        // check if 'low' value is a valid number
        if (is_numeric($_REQUEST['low' . $field])) {
            $lowValue = ($_REQUEST['low' . $field]);

            // ensure low is not less than or equal to 0
            if ($lowValue <= 0) { 
                // tell user that their input must be a valid number and clear the field
                echo '<span style="color: red;">Low value cannot be less than or equal 0.</span>';
                $lowValue = '';
            } 

        } else { 
            // tell user that their input must be numeric and clear the field
            echo '<span style="color: red;">Low value must be numeric.</span>';
            $lowValue = '';
        }
    } else { // runs if field is empty
        $lowValue = '';
    }

    // check if 'hi' value is not empty
    if (!empty($_REQUEST['hi' . $field])) {
        // check if 'hi' value is a valid number
        if (is_numeric($_REQUEST['hi' . $field])) {
            $hiValue = htmlspecialchars($_REQUEST['hi' . $field]);

            // ensure high is not less than 0
            if ($hiValue <= 0) { 
                // tell user that their input must be a valid number and clear the field
                echo '<span style="color: red;">High value cannot be less than or equal to 0.</span>';
                $hiValue = '';
            }
        } else {
            echo '<span style="color: red;">High value must be numeric.</span>';
            $hiValue = '';
        }

        // Ensure low is not greater than high
        if ($lowValue !== '' && $hiValue !== '' && $lowValue > $hiValue) { 
             // tell user that their input must be numeric and clear the field
            echo '<span style="color: red;">High value cannot be less than the low value.</span>';
            $hiValue = '';
        } 
    } else { 
        // runs if no input was provided
        $hiValue = '';
    }

    // finish creating tags with correct field names and values
        echo '    between <input type="text" size="3" name="low' . $field . '" id="low' . $field . '" value="' . $lowValue . '" maxlength="5">';
        echo ' and <input type="text" size="3" name="hi' . $field . '" id="hi' . $field . '" value="' . $hiValue . '" maxlength="5">';
    
        echo '  </td>';
        echo '</tr>';
    }


    // create associative array for the radiobox fields
    $fieldValues = [
        "address.country" => ["Any", "Australia", "Brazil", "Canada", "China", "Hong Kong", "Portugal", "Spain", "Turkey", "United States"],
        "room_type" => ["Any", "Entire home/apt", "Private room", "Shared room"],
        "bed_type" => ["Any", "Futon", "Airbed", "Pull-out Sofa", "Real Bed", "Couch"],
        "cancellation_policy" => ["Any", "flexible", "moderate", "strict_14_with_grace_period", "super_strict_30", "super_strict_60"]
    ];

    // loop through the radio box fields and their values to create the html tags. 
    // the radiobox selection will reflect the with user's selected radioboxes for these fields
    foreach ($fieldValues as $field => $values) {
        echo '<tr>';
        echo '  <td align="right">' . $field . '</td>';
        echo '  <td>';
        foreach ($values as $value) {  
            // str_replace makes sure the name and id are correctly formatted
            echo '    <input type="radio" name="' . str_replace('.', '_', $field) . '" id="' . str_replace('.', '_', $field) . '" value="' . $value . '"';
            // updates radiobox to be selected if the user has chosen it 
            if ($_REQUEST[str_replace('.', '_', $field)] === $value) {
                echo ' checked';
            }
            echo '>' . $value . ', ';
        }
        echo '  </td>';
        echo '</tr>';
    }
    
    echo '</TABLE>'; // Close the existing table after the amenities section

    echo 'Amenities';  
    echo '<div id="div1" style="height: 100px;position:relative;">';
    echo '  <div id="div2" style="max-height:100%;overflow:auto;border:1px solid black;">';

    foreach ($amenities as $amenity) {
        $id = str_replace(' ', '_', $amenity);
        $name = $id;
        $value = "yes";

        echo '    <div class="item">';
        echo '      <input type="checkbox" name="' . $name . '" id="' . $id . '" value="' . $value . '"';  
        if (isset($_REQUEST[$name])) {
            echo ' checked';
        } 
        echo '>' . $amenity; 
        echo '    </div>';
    }

    echo '  </div>';
    echo '</div>';

    echo '<TABLE>';

    // create array for sorting criteria 
    $criteria = ["accommodates", "bedrooms", "bathrooms", "beds", "price", "cleaning_fee"]; 

    // loop through criteria and create radio boxes for each 
    // radio box will be selected if user selected it in the form
    foreach ($criteria as $criterion) { 
        $label = (str_replace('_', ' ', $criterion));

        echo '<tr>';
        echo '  <td align="right">' . $label . '</td>';
        echo '  <td>';
        echo '    <input type="radio" name="sort_' . $criterion . '" value="No sorting"'; 
        // if the field was selected, update the html tags to reflect this
        if ($_REQUEST['sort_' . $criterion] === "No sorting") {
            echo ' checked';
        }
        echo '> No sorting,';
        echo '    <input type="radio" name="sort_' . $criterion . '" value="Increasing"';
        if ($_REQUEST['sort_' . $criterion] === "Increasing") {
            echo ' checked';
        }
        echo '> Increasing,';
        echo '    <input type="radio" name="sort_' . $criterion . '" value="Decreasing"';
        if ($_REQUEST['sort_' . $criterion] === "Decreasing") {
            echo ' checked';
        }
        echo '> Decreasing';
        echo '  </td>';
        echo '</tr>';
        echo "\n";
    }

    echo '</TABLE>'; 
} 
// Code for processing the query and displaying the results
?>
<TR><TD><INPUT type="submit" name="submit" id="submit" value="Search"></TD> 
</FORM>	</TR>

</CENTER>


