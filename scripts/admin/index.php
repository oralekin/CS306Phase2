<?php
$mongo = new MongoDB\Driver\Manager("mongodb://" . getenv("MONGO_ROOT_USERNAME") . ":" . getenv("MONGO_ROOT_PASSWORD") . "@" . getenv("MONGO_URL") . ":27017");
$tickets = $mongo->executeQuery(getenv("MONGO_DATABASE") . '.tickets', new MongoDB\Driver\Query(['status' => true]));
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Ticket List</title>
</head>

<body>
  <div style="border: 1px solid black; padding: 10px; margin: 10px;">
    <h2>Active Tickets:</h2>
    <?php
    if (isset($tickets)) {
      foreach ($tickets as $document) {
        ?>
        <div style='border: 1px solid blue; padding: 10px; margin: 5px;'>
          <strong>Status: </strong><?= $document->status ? 'Active' : 'Inactive' ?><br>
          <strong>Body: </strong><?= $document->body ?><br>
          <strong>Created At: </strong><?= $document->created_at ?><br>
          <strong>Username: </strong><?= $document->username ?><br>
          <a href="ticketDetail?id=<?= $document->_id ?>">View Details</a><br>
        </div>
        <?php
      }
    }
    ?>

  </div>

</body>

</html>