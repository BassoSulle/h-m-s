<?php
// Replace this with your data retrieval logic
// For example, fetch data from a database
$data = [
  ['label' => 'Category A', 'value' => 30],
  ['label' => 'Category B', 'value' => 50],
  ['label' => 'Category C', 'value' => 20],
];

// Convert data to JSON and send it as a response
header('Content-Type: application/json');
echo json_encode($data);
?>