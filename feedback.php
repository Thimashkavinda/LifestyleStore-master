<?php

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

$query = new MongoDB\Driver\Query([]);

$cursor = $manager->executeQuery('nibm.customers', $query); // Assuming 'NIBM' is the database and 'customers' is the collection

$documents = $cursor->toArray();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $feedback = $_POST['feedback'];
    
    $document = new stdClass();
    $document->name = $name;
    $document->email = $email;
    $document->age = $age;
    $document->feedback = $feedback;
    
    $bulkWrite = new MongoDB\Driver\BulkWrite();
    $bulkWrite->insert($document);
    $manager->executeBulkWrite('nibm.customers', $bulkWrite);
    
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Records</title>
    <style>
       #name {
            width: 400px;
            height:50px; 
            margin:20px; 
        }
        #email {
            width: 400px;
            height:50px;
            margin:20px;
        }
        #age {
            width: 400px; 
            height:20px;
            margin:20px; 
        }
        #feedback {
            width: 400px; 
            height:100px;
            margin:20px; 
        }
        .{
            color:red;
            cursor: pointer;
        }
    </style>
</head>
<body>



<h2>Add Customer Feed Back</h2><br><br><br><br>

<form method="post">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="age">Age:</label><br>
    <input type="number" id="age" name="age" required><br><br>

    <label for="feedback">Customer Feed Back:</label><br>
    <input type="text" id="feedback" name="feedback" required><br>

    <input type="submit" value="Submit">

</form>

</body>
</html>
