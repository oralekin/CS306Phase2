<?php

/*
if this is a POST, we are adding a comment.
on successful comment addition, redireect user to ticket detail for this thicket
on failure, RENDER ticket detail with error message.
*/

$mongo = new MongoDB\Driver\Manager("mongodb://" . getenv("MONGO_ROOT_USERNAME") . ":" . getenv("MONGO_ROOT_PASSWORD") . "@" . getenv("MONGO_URL") . ":27017");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // comment being added.
  $id = $_POST["id"];
  $username = $_POST["username"];
  $comment_body = $_POST["comment"];

  if (empty($id))
    $add_error .= "Something went wrong!\n";

  if (empty($username))
    $add_error .= "Username is required.\n";

  if (empty($comment_body))
    $add_error .= "Comment body is required.\n";

  $success = empty($add_error);

  if ($success) {
    $bulk = new MongoDB\Driver\BulkWrite();
    $bulk->update(['_id' => new \MongoDB\BSON\ObjectId($_GET['id'])], [
      '$push' => [
        'comments' => [
          'username' => $username,
          'comment' => $comment_body,
          'created_at' => date("c"),
        ]
      ]
    ]);
    $r = $mongo->executeBulkWrite(getenv("MONGO_DATABASE") . ".tickets", $bulk);
    if ($r->getModifiedCount() == 0) {
      $add_error .= "Failed to add comment.\n";
      $success = false;
    }
    if ($r->getModifiedCount() > 1) {
      $add_error .= "Something went wrong!\n";
      $success = false;
    }
  }


  // if coment add successful, redirect user to GET detail of this ticket
  if ($success) {
    http_response_code(303); // "See Other" = redirect after POST.
    header("Location: {$_SERVER['PHP_SELF']}?id=$id");
    die();
  }
}


if (isset($_GET['id'])) {
  $results = $mongo->executeQuery(getenv("MONGO_DATABASE") . '.tickets', new MongoDB\Driver\Query(['_id' => new \MongoDB\BSON\ObjectId($_GET['id'])]));
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
    <title>Ticket Details</title>
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
          <strong>Comment: </strong><?= $comment->comment ?><br>
        </div>
      <?php } ?>
    </div>
    <form method="post">
      <textarea name="comment" placeholder="Add a comment"><?= $comment_body ?? "" ?></textarea><br>
      <input type="text" name="username" placeholder="Your username" value="<?= $username ?? "" ?>"><br>
      <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
      <button type="submit">Add comment</button><br>
    </form>
    <?php if (isset($add_error)) {
    ?>
      <div style="border: 1px solid red; padding: 3px; margin: 3px;">
        <?= $add_error ?>
      </div>
    <?php
    } ?>
    <a href="/user/support">Back to Tickets</a>
  </body>

  </html>
<?php } else {
  http_response_code(400);
}
