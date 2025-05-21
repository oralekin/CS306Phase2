<!--
PHP SCRIPT HERE!!!
DEFINE "results" variable to be able to use it in the html script.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- get the results from the php script and put them into seperate outlined boxes  -->
    <div style="border: 1px solid black; padding: 10px; margin: 10px;">
        <h2>Results:</h2>
        <?php
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
        } else {
            echo "No results found!<br>";
        }
        ?>
    </div>

</body>

</html>