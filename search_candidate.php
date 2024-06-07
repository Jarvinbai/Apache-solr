<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Skillsense-Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-between">
        <h1 class="mt-5 skill-logo">Search Engine</h1>
        <div class="mt-5 user">
            <ul>
            <li class="user-list dropdown"> 
                <a class="navbar-brand" href="#">
                <img src="./assets/images/user-1.png" width="30" height="30" class="d-inline-block align-top" alt="">
                Jarvin bai <i class="bi bi-caret-down-fill"></i>
                </a>
            </li>
            </ul>
        </div>
        </div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">search</li>
        </ol>
        </nav>
        <p class="text-head">Type keywords to find the candidate or job records you need </p>
        <div class="logo">
        <div class="input-search mb-5">
            <form action="search_candidate.php" method="get">
                <input class="input-text" id="searchInput" type="text" name="query" required placeholder="Type here" autocomplete="off">
                <button type="submit" class="btn btn-primary mt-3">Search</button>
            </form>
            <div id="suggestionsContainer"></div>

        </div>
        <?php
        // Add a conditional check to hide the image during search
        if (!isset($_GET['query'])) {
            echo '<img src="./assets/images/search-img.png" alt="search-image" style="width: 205.049px; height: 195.639px;">';
        }
        ?>
        </div>
    </div>



    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
        // Set Solr core URL
        $solrUrl = 'http://localhost:8983/solr/my_core';

        // Candidate search query
        $query = $_GET['query'];

        // Set cURL options
        $ch = curl_init($solrUrl . '/select?q=' . urlencode('name:' . $query . ' OR job_title:' . $query));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL request
        $response = curl_exec($ch);


        // Check for cURL errors
        if (curl_errno($ch)) {
            echo '<div class="container text-center">';
            echo 'Curl error: ' . curl_error($ch);
            echo '</div>';
        } else {
            // Decode Solr response
            $result = json_decode($response, true);
        
            // Display search results
            echo '<div class="container text-center">';
            if ($result['response']['numFound'] > 0) {
                echo '<h2>Search Results:</h2>';
                foreach ($result['response']['docs'] as $candidate) {
                    echo '<p>Name: ' . $candidate['name'][0] . '</p>';
                    echo '<p>Job Title: ' . $candidate['job_title'][0] . '</p>';
                    echo '<p>Salary: ' . $candidate['salary'][0] . '</p>';
                    echo '<hr>';
                }
            } else {
                echo '<p>No results found.</p>';
            }
            echo '</div>';
        }
        

        // Close cURL session
        curl_close($ch);
    }
    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function () {
    $("#searchInput").on("input", function () {
        var query = $(this).val();

        // Make an AJAX request to Solr suggest endpoint
        $.ajax({
            url: "http://localhost:8983/solr/my_core/suggest",
            data: {
                q: query,
                suggester: "mySuggester",
                field: "job_title", // Update this line
            },
            dataType: "json",
            success: function (data) {
                // Display suggestions in a dropdown or another container
                var suggestions = data.suggest.mySuggester.suggestions;
                displaySuggestions(suggestions);
            },
            error: function (error) {
                console.error("Error fetching suggestions:", error);
            },
        });
    });

    // Function to display suggestions
    function displaySuggestions(suggestions) {
        // Clear previous suggestions
        $("#suggestionsContainer").empty();

        // Display new suggestions
        for (var i = 0; i < suggestions.length; i++) {
            var suggestion = suggestions[i].term;
            $("#suggestionsContainer").append("<div>" + suggestion + "</div>");
        }
    }
});





</script>

</body>
</html>
