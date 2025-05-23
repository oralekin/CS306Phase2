<?php
$mongo = new MongoDB\Driver\Manager("mongodb://" . getenv("MONGO_ROOT_USERNAME") . ":" . getenv("MONGO_ROOT_PASSWORD") . "@" . getenv("MONGO_URL") . ":27017");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Ticket List</title>
</head>

<body>
  <form action="." method="get">
    <select name="username" id="username_select">
      <?php
      $distinct = new MongoDB\Driver\Command([
        'distinct' => 'tickets',
        'key' => 'username',
        'query' => [
          'status' => true,
        ]
      ]);
      $usernames = $mongo->executeReadCommand(getenv("MONGO_DATABASE"), $distinct)
        ->toArray()[0]
        ->values;
      ?>
      <option <?= !empty($_GET["username"]) ? "" : " selected" ?>></option>
      <?php

      if (count($usernames) == 0) { ?>
        <!-- count == 0 -->
        <option value=""> </option>
      <?php }
      foreach ($usernames as $username) { ?>
        <option value="<?= $username ?>" <?= (($_GET["username"] ?? NULL) == trim($username)) ? " selected" : "" ?>>
          <?= $username ?>
        </option>
      <?php }
      ?>
    </select>
    <button type="submit">Select</button>
  </form>
  <a href="./createTicket">Create a Ticket</a>

  <div style="border: 1px solid black; padding: 10px; margin: 10px;">
    <h2>Results:</h2>
    <?php
    if (!empty($_GET['username'])) {
      $results = $mongo->executeQuery(getenv("MONGO_DATABASE") . '.tickets', new MongoDB\Driver\Query([
        'username' => $_GET['username'],
        'status' => true,
      ]));
      foreach ($results as $document) {
        ?>
        <div style='border: 1px solid blue; padding: 10px; margin: 5px;'>
          <strong>Status: </strong><?= $document->status ? "Active" : "Inactive" ?><br>
          <strong>Body: </strong><?= $document->body ?><br>
          <strong>Created At: </strong><?= $document->created_at ?><br>
          <strong>Username: </strong><?= $document->username ?><br>
          <a href="ticketDetail?id=<?= $document->_id ?>">View Details</a><br>
        </div>
        <?php
      }
    } else {
      echo "No results found!<br>";
    }

    ?>
  </div>

  <a href="/user">Home</a><br>

</body>

</html>