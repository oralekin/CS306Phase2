<?php

/*
  see user/support/ticketDetail for more info on how form handling is done.
*/

$mongo = new MongoDB\Driver\Manager("mongodb://" . getenv("MONGO_ROOT_USERNAME") . ":" . getenv("MONGO_ROOT_PASSWORD") . "@" . getenv("MONGO_URL") . ":27017");

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'POST':
    switch ($_POST["action"]) {
      case 'deactivate':
        $id = $_POST["id"];
        if (empty($id))
          $deactivate_error .= "Something went wrong!\n";

        $success = empty($comment_error);

        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->update(['_id' => new \MongoDB\BSON\ObjectId($_GET['id'])], [
          '$set' => [
            'status' => false,
          ]
        ]);
        $r = $mongo->executeBulkWrite(getenv("MONGO_DATABASE") . ".tickets", $bulk);
        if ($r->getModifiedCount() == 0) {
          $deactivate_error .= "Failed to deactivate.\n";
          $success = false;
        }
        if ($r->getModifiedCount() > 1) {
          $deactivate_error .= "Something went wrong!\n";
          $success = false;
        }

        // if coment add successful, redirect user to GET detail of this ticket
        if ($success) {
          http_response_code(303); // "See Other" = redirect after POST.
          header("Location: {$_SERVER['PHP_SELF']}?id=$id");
          die();
        }


        break;
      case 'comment':
        // comment being added.
        $id = $_POST["id"];
        $comment_body = $_POST["comment"];

        if (empty($id))
          $comment_error .= "Something went wrong!\n";

        if (empty($comment_body))
          $comment_error .= "Comment body is required.\n";

        $success = empty($comment_error);

        if ($success) {
          $bulk = new MongoDB\Driver\BulkWrite();
          $bulk->update(['_id' => new \MongoDB\BSON\ObjectId($_GET['id'])], [
            '$push' => [
              'comments' => [
                'username' => 'admin',
                'comment' => $comment_body,
                'created_at' => date("c"),
              ]
            ]
          ]);
          $r = $mongo->executeBulkWrite(getenv("MONGO_DATABASE") . ".tickets", $bulk);
          if ($r->getModifiedCount() == 0) {
            $comment_error .= "Failed to add comment.\n";
            $success = false;
          }
          if ($r->getModifiedCount() > 1) {
            $comment_error .= "Something went wrong!\n";
            $success = false;
          }
        }
        // if coment add successful, redirect user to GET detail of this ticket
        if ($success) {
          http_response_code(303); // "See Other" = redirect after POST.
          header("Location: {$_SERVER['PHP_SELF']}?id=$id");
          die();
        }
        break;
      default:
        http_response_code(400);
        die();
    }
    break;
  case 'GET':
    if (!isset($_GET['id'])) {
      http_response_code(400);
      die();
    }

    $tickets = $mongo->executeQuery(getenv("MONGO_DATABASE") . '.tickets', new MongoDB\Driver\Query(['_id' => new \MongoDB\BSON\ObjectId($_GET['id'])]));
    $found = false;
    foreach ($tickets as $ticket_temp) {
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
      <title>Admin Ticket Details</title>
    </head>

    <body>
      <form method="post">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
        <button type="submit" name="action" value="deactivate">Deactivate ticket</button>
      </form>
      <?php if (isset($deactivate_error)) {
      ?>
        <div style="border: 1px solid red; padding: 3px; margin: 3px;">
          <?= $deactivate_error ?>
        </div>
      <?php
      } ?>

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
        <input type="hidden" name="id" value="<?= $_GET['id']  ?? "" ?>">
        <button type="submit" name="action" value="comment">Add comment</button><br>
      </form>
      <?php if (isset($comment_error)) {
      ?>
        <div style="border: 1px solid red; padding: 3px; margin: 3px;">
          <?= $comment_error ?>
        </div>
      <?php
      } ?>
      <a href="..">Back to Tickets</a>
    </body>

    </html>
<?php
    break;
  default:
    http_response_code(400);
    break;
}
