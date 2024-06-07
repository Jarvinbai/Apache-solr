<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set Solr core URL
    $solrUrl = 'http://localhost:8983/solr/my_core';

    // Candidate details from the form
    $candidateData = array(
        'name' => $_POST['name'],
        'job_title' => $_POST['job_title'],
        'salary' => $_POST['salary'],
    );

    // Convert candidate data to Solr JSON format
    $jsonData = json_encode(array($candidateData));

    // Set cURL options
    $ch = curl_init($solrUrl . '/update/json/docs');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    } else {
        echo 'Candidate added successfully!';
    }

    // Close cURL session
    curl_close($ch);
}
?>
