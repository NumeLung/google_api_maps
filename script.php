<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "google_heatmap";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//base query to get the coordinates
$query = "
SELECT
    c.id_crash,
    c.crash_date,
    ci.city_name AS city,
    d.descr AS crash_damage,
    c.crash_lat,
    c.crash_lng,
    c.crash_descr
FROM
    crashes c
JOIN
    cities ci ON c.id_city = ci.id_city
JOIN
    damage_descr d ON c.id_crash_dmg = d.id;
";

$result = $conn->query($query);

// Check if the query was successful
if ($result === false) {
    echo "Error: " . $conn->error;
} else {
    $data = array(); // Create an empty array to hold the results

// Fetch and add each row to the data array
    while ($row = $result->fetch_assoc()) {
        $id_crash = $row['id_crash']; // Get the id_crash value

        // Remove the id_crash from the row data (optional)
        /*unset($row['id_crash']);*/

        // Create a nested associative array with id_crash as the key
        $data[$id_crash] = $row;
    }

// Close the result set
    $result->close();

    // Encode the data array as JSON
    $json_data = json_encode($data);
}

// Close the connection when you're done
$conn->close();

echo $json_data;
?>