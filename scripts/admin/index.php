<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Ticket List</title>
</head>

<body>

    <a href="/user">Home</a>
    <a href="./createTicket.php">Create a Ticket</a>

    <div style="border: 1px solid black; padding: 10px; margin: 10px;">
        <h2>Results:</h2>
        <?php

        $manager = new MongoDB\Driver\Manager("mongodb://" . getenv("MONGO_ROOT_USERNAME") . ":" . getenv("MONGO_ROOT_PASSWORD") . "@" . getenv("MONGO_URL") . ":27017");
        $results = $manager->executeQuery(getenv("MONGO_DATABASE") . '.tickets', new MongoDB\Driver\Query([]));
        if (isset($results)) {
            foreach ($results as $document) {
                echo "<div style='border: 1px solid blue; padding: 10px; margin: 5px;'>";
                $status_str = "";
                if ($document->status) {
                    $status_str = "Active";
                } else {
                    $status_str = "Inactive";
                }
                echo "<strong>Status: </strong>{$status_str}<br>";
                echo "<strong>Body: </strong>{$document->body}<br>";
                echo "<strong>Created At: </strong>{$document->created_at}<br>";
                echo "<strong>Username: </strong>{$document->username}<br>";
                echo "</div>";
            }
        }
        ?>

    </div>

</body>

</html>