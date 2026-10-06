<?php

echo "<h1>PHP & MySQL Assignment 2</h1>";

/* =====================================================
   QUESTION 1
   One Dimensional Array
   ===================================================== */

echo "<hr>";
echo "<h2>Question 1</h2>";

$array = [5, -7, 12, 10, -7, 11, -6, 12, 1, -7, 2, 9];

echo "<b>All Elements:</b> ";

foreach ($array as $value) {
    echo $value . " ";
}

$total = 0;
$evenTotal = 0;
$oddTotal = 0;

foreach ($array as $value) {

    $total += $value;

    if ($value % 2 == 0) {
        $evenTotal += $value;
    } else {
        $oddTotal += $value;
    }
}

echo "<p>Total of all elements: $total</p>";
echo "<p>Total of even elements: $evenTotal</p>";
echo "<p>Total of odd elements: $oddTotal</p>";

$min = min($array);
$max = max($array);

echo "<p>Minimum element: $min</p>";
echo "<b>Minimum positions:</b> ";

foreach ($array as $index => $value) {
    if ($value == $min) {
        echo $index . " ";
    }
}

echo "<p>Maximum element: $max</p>";
echo "<b>Maximum positions:</b> ";

foreach ($array as $index => $value) {
    if ($value == $max) {
        echo $index . " ";
    }
}


/* =====================================================
   QUESTION 2
   Associative Two Dimensional Array
   ===================================================== */

echo "<hr>";
echo "<h2>Question 2</h2>";

$colors = [

    "Light" => [
        "Red" => "Light Red",
        "Green" => "Light Green",
        "Blue" => "Light Blue"
    ],

    "Normal" => [
        "Red" => "Normal Red",
        "Green" => "Normal Green",
        "Blue" => "Normal Blue"
    ],

    "Dark" => [
        "Red" => "Dark Red",
        "Green" => "Dark Green",
        "Blue" => "Dark Blue"
    ]

];

echo "<table border='1' cellpadding='10'>";

echo "<tr>";
echo "<th></th>";
echo "<th>Red</th>";
echo "<th>Green</th>";
echo "<th>Blue</th>";
echo "</tr>";

foreach ($colors as $rowName => $row) {

    echo "<tr>";

    echo "<th>$rowName</th>";

    foreach ($row as $value) {
        echo "<td>$value</td>";
    }

    echo "</tr>";
}

echo "</table>";


/* =====================================================
   QUESTION 3
   Square Two Dimensional Array
   ===================================================== */

echo "<hr>";
echo "<h2>Question 3</h2>";

$array2 = [
    [2, -6, 8],
    [-6, 1, 6],
    [7, 8, -6]
];

echo "<b>All Elements:</b><br><br>";

echo "<table border='1' cellpadding='10'>";

foreach ($array2 as $row) {

    echo "<tr>";

    foreach ($row as $value) {
        echo "<td>$value</td>";
    }

    echo "</tr>";
}

echo "</table>";

/* Odd and Even */

$oddTotal = 0;
$evenTotal = 0;
$allTotal = 0;

foreach ($array2 as $row) {

    foreach ($row as $value) {

        $allTotal += $value;

        if ($value % 2 == 0) {
            $evenTotal += $value;
        } else {
            $oddTotal += $value;
        }
    }
}

echo "<p>Total of odd elements: $oddTotal</p>";
echo "<p>Total of even elements: $evenTotal</p>";

/* Row totals */

echo "<b>Total of each row:</b><br>";

for ($i = 0; $i < 3; $i++) {

    $rowTotal = 0;

    for ($j = 0; $j < 3; $j++) {
        $rowTotal += $array2[$i][$j];
    }

    echo "Row " . ($i + 1) . " = $rowTotal<br>";
}

/* Column totals */

echo "<br><b>Total of each column:</b><br>";

for ($j = 0; $j < 3; $j++) {

    $columnTotal = 0;

    for ($i = 0; $i < 3; $i++) {
        $columnTotal += $array2[$i][$j];
    }

    echo "Column " . ($j + 1) . " = $columnTotal<br>";
}

/* Diagonal totals */

$diagonal1 = 0;
$diagonal2 = 0;

for ($i = 0; $i < 3; $i++) {

    $diagonal1 += $array2[$i][$i];

    $diagonal2 += $array2[$i][2 - $i];
}

echo "<p>Total of first diagonal: $diagonal1</p>";
echo "<p>Total of second diagonal: $diagonal2</p>";

/* Total of all elements */

echo "<p>Total of all elements: $allTotal</p>";

/* Minimum and Maximum */

$min = $array2[0][0];
$max = $array2[0][0];

for ($i = 0; $i < 3; $i++) {

    for ($j = 0; $j < 3; $j++) {

        if ($array2[$i][$j] < $min) {
            $min = $array2[$i][$j];
        }

        if ($array2[$i][$j] > $max) {
            $max = $array2[$i][$j];
        }
    }
}

echo "<p>Minimum element: $min</p>";

echo "<b>Minimum positions:</b> ";

for ($i = 0; $i < 3; $i++) {

    for ($j = 0; $j < 3; $j++) {

        if ($array2[$i][$j] == $min) {
            echo "Row " . ($i + 1) . ", Column " . ($j + 1) . " &nbsp;";
        }
    }
}

echo "<p>Maximum element: $max</p>";

echo "<b>Maximum positions:</b> ";

for ($i = 0; $i < 3; $i++) {

    for ($j = 0; $j < 3; $j++) {

        if ($array2[$i][$j] == $max) {
            echo "Row " . ($i + 1) . ", Column " . ($j + 1) . " &nbsp;";
        }
    }
}


/* =====================================================
   QUESTION 4
   Student Information
   ===================================================== */

echo "<hr>";
echo "<h2>Question 4</h2>";

$students = [

    "CA221" => [
        "Name" => "Mohamed Ahmed Ali",
        "Phone" => "0648440403",
        "Address" => "Laba Dhagax, Wardhiigley"
    ],

    "CA223" => [
        "Name" => "Ahmed Abdi Jama",
        "Phone" => "0647223201",
        "Address" => "Taleex, Hodan"
    ],

    "CA221-2" => [
        "Name" => "Amina Nur Adan",
        "Phone" => "0646990276",
        "Address" => "Macmacaanka, Dharkeynley"
    ]

];

echo "<table border='1' cellpadding='10'>";

echo "<tr>";
echo "<th>ID</th>";
echo "<th>Name</th>";
echo "<th>Phone</th>";
echo "<th>Address</th>";
echo "</tr>";

foreach ($students as $id => $student) {

    echo "<tr>";

    echo "<td>$id</td>";
    echo "<td>" . $student["Name"] . "</td>";
    echo "<td>" . $student["Phone"] . "</td>";
    echo "<td>" . $student["Address"] . "</td>";

    echo "</tr>";
}

echo "</table>";


/* =====================================================
   QUESTION 5
   Student Transcript
   ===================================================== */

echo "<hr>";
echo "<h2>Question 5</h2>";

$transcript = [

    "Semester 1" => [

        "subject1" => [
            "CW1" => 9,
            "MidTerm" => 26,
            "CW2" => 10,
            "Final" => 40,
            "Total" => 85,
            "Status" => "Pass"
        ],

        "subject2" => [
            "CW1" => 9,
            "MidTerm" => 26,
            "CW2" => 10,
            "Final" => 40,
            "Total" => 85,
            "Status" => "Pass"
        ],

        "subject3" => [
            "CW1" => 9,
            "MidTerm" => 26,
            "CW2" => 10,
            "Final" => 40,
            "Total" => 85,
            "Status" => "Pass"
        ]

    ],

    "Semester 2" => [

        "subject1" => [
            "CW1" => 9,
            "MidTerm" => 26,
            "CW2" => 10,
            "Final" => 0,
            "Total" => 45,
            "Status" => "Fail"
        ],

        "subject2" => [
            "CW1" => 9,
            "MidTerm" => 26,
            "CW2" => 10,
            "Final" => 40,
            "Total" => 85,
            "Status" => "Pass"
        ],

        "subject3" => [
            "CW1" => 9,
            "MidTerm" => 26,
            "CW2" => 10,
            "Final" => 40,
            "Total" => 85,
            "Status" => "Pass"
        ]

    ]

];

echo "<table border='1' cellpadding='10'>";

echo "<tr>";
echo "<th>Semester</th>";
echo "<th>Course</th>";
echo "<th>CW1</th>";
echo "<th>MidTerm</th>";
echo "<th>CW2</th>";
echo "<th>Final</th>";
echo "<th>Total</th>";
echo "<th>Status</th>";
echo "</tr>";

foreach ($transcript as $semester => $courses) {

    foreach ($courses as $course => $data) {

        echo "<tr>";

        echo "<td>$semester</td>";
        echo "<td>$course</td>";
        echo "<td>" . $data["CW1"] . "</td>";
        echo "<td>" . $data["MidTerm"] . "</td>";
        echo "<td>" . $data["CW2"] . "</td>";
        echo "<td>" . $data["Final"] . "</td>";
        echo "<td>" . $data["Total"] . "</td>";
        echo "<td>" . $data["Status"] . "</td>";

        echo "</tr>";
    }
}

echo "</table>";

echo "<hr>";
echo "<h2>Assignment Completed ✅</h2>";

?>