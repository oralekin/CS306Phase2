<?php
if (isset($_GET['id'])) {

  $manager = new MongoDB\Driver\Manager("mongodb://" . getenv("MONGO_ROOT_USERNAME") . ":" . getenv("MONGO_ROOT_PASSWORD") . "@" . getenv("MONGO_URL") . ":27017");
  $results = $manager->executeQuery(getenv("MONGO_DATABASE") . '.tickets', new MongoDB\Driver\Query(['_id' => new \MongoDB\BSON\ObjectId($_GET['id'])]));
  $found = false;
  foreach ($results as $ticket_temp) {
    if ($found) {
      http_response_code(500);
      die();
    }
    $ticket = $ticket_temp;
    $found = true;
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>

  <body>
    <h2>Ticket Details</h2>
    <strong>Username: </strong><?= $ticket->username ?><br>
    <strong>Body: </strong><?= $ticket->body ?><br>
    <strong>Status: </strong><?= $ticket->status ? "Active" : "Inactive" ?><br>
    <strong>Created At: </strong><?= $ticket->created_at ?><br>
    <div style="border: 1px solid black; padding: 10px; margin: 10px;">
      <h2>Comments:</h2>
      <?php foreach ($ticket->comments as $comment) { ?>
        <div style='border: 1px solid blue; padding: 10px; margin: 5px;'>
          <strong>Created At: </strong><?= $comment->created_at ?><br>
          <strong>Username: </strong><?= $comment->username ?><br>
          <strong>Body: </strong><?= $comment->body ?><br>
        </div>
      <?php } ?>
    </div>
    <a href="/user/support">Back to Tickets</a>
  </body>

  </html>
<?php } else {
  http_response_code(400);
}