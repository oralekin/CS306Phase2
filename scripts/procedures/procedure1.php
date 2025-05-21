<?php
$con = mysqli_connect("localhost","my_user","my_password","my_db");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

// Perform query
if ($result = mysqli_query($con, "SELECT * FROM Persons")) {
  echo "Returned rows are: " . mysqli_num_rows($result);
  // Free result set
  mysqli_free_result($result);
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procedure 1</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>
    <div class="flex flex-col gap-4 justify-center items-center h-screen">
        <a href="/user" class="text-gray-400 text-sm hover:text-gray-500">Back</a>
        <h1 class="font-bold text-4xl">Procedure 1</h1>
        <div class="font-bold text-md text-gray-400">By Thorfinn Thorsson</div>
        <p class="max-w-xl text-sm">This stored procedure takes in two date parameters and returns the judokas that started
            between these dates.
            Before insert operation After insert operation
        </p>
        <button class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Test Trigger</button>
        <div class="flex pt-20 flex-col items-center gap-4">
            <div class="font-bold text-2xl">Results</div>
            <div class="max-w-4xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab dolores commodi ipsum excepturi voluptatibus quibusdam harum eligendi, obcaecati repudiandae id alias pariatur ex, molestias quae maxime corrupti explicabo, aliquid tempora?</div>
        </div>
    </div>
</body>

</html>