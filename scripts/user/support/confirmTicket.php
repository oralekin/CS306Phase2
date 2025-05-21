<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ticket Confirmation</title>
</head>
<body>
<a href="./createTicket.php">Create another ticket</a><br />
<a href=".">Ticket list</a>
<?php
$manager = new MongoDB\Driver\Manager("mongodb://" . getenv("MONGO_ROOT_USERNAME") . ":" . getenv("MONGO_ROOT_PASSWORD") . "@" . getenv("MONGO_URL") . ":27017");
$bulk = new MongoDB\Driver\BulkWrite();
if (!empty($_POST)) {
  $bulk->insert([
    'username'=> $_POST['username'],  
    'body'=> $_POST['body'],
    'created_at' => date("c"),
    'status'=> TRUE,
    'comments'=> [],
  ]);
  $result = $manager->executeBulkWrite(getenv("MONGO_DATABASE") . ".tickets", $bulk);

  $success = $result->isAcknowledged();
  if ($success) {
    $messages = ['Inserted ' . $result->getInsertedCount() . ' document(s).'];
  } else {
    $messages = $result->getWriteErrors();
  }
?>
  <h2>Ticket was <?= $success?"":"not "?> created successfully.</h2>
  <?php             foreach ($messages as $message) { ?>
    <?= $message ?><br />
  <?php } ?>
<?php } else { ?>
  <h2>Bad access.</h2>
<?php } ?>

</body>
</html>