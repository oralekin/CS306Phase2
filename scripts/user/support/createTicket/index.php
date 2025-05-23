<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Create Ticket</title>
</head>
<body>
  <a href="..">View Tickets</a><br/>
  <a href="/user">Home</a>

  <h2>Create a Ticket</h2>
  <form action="./confirmTicket.php" method="post">
    <label for="name">username: </label>
    <input type="text" name="username" id="username" required />
    <br /> 
    <label for="name">body: </label>
    <input type="text" name="body" id="body" required />
    <br /> 
    <input type="submit">
  </form>
</body>
</html>