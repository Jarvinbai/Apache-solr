<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Candidate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center; /* Center-align the content within the body */
        }

        h1 {
            margin-bottom: 20px; /* Add some space below the heading */
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            text-align: left; /* Reset text alignment for the form */
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Add Candidate</h1>
    
    <form action="add_candidate.php" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" required><br>

        <label for="salary">Salary:</label>
        <input type="number" name="salary" required><br>

        <button type="submit">Add Candidate</button>
    </form>
</body>
</html>
