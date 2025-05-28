<?php

$con = mysqli_connect(getenv('MYSQL_URL'), "root", getenv('MYSQL_ROOT_PASSWORD'), getenv("MYSQL_DATABASE"));

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procedure 2</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>
    <div class="flex flex-col gap-4 justify-center items-center min-h-screen">
        <a href="/user" class="text-indigo-400 text-sm hover:text-gray-500 underline ">Back</a>
        <h1 class="font-bold text-4xl flex gap-2 items-center justify-center">Procedure <div class="text-5xl text-red-400 rotate-45">2</div>
        </h1>
        <div class="font-bold text-md text-gray-400">By Edoardo Cecca</div>
        <p class="max-w-xl text-sm">This stored procedure takes in one integer parameter, a match id, and returns the match id,
            total points, point composition and the name of the judoka who won the match. This stored
            procedure implements the calculation to get total score from score components, as well as
            checking for forfeits. The script for this is included below.</p>
        <form method="post" class="flex gap-2 items-end ">
<div class="flex flex-col"><label for="start">Match id:</label>
<select
name="start"
value=""
id="start"
class="border-2 border-gray-200 rounded-lg"
onchange="enableButton(1)"
>
<?
$event = mysqli_query($con, "CALL versus();");
while($row = $event->fetch_row()){
    echo sprintf(
        '<option value="%s">%s vs %s</option>',
        htmlspecialchars($row[0]),
        htmlspecialchars($row[1]),
        htmlspecialchars($row[2])
    );
}
?>

</select>

            
            <button value="fire" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Test Procedure</button>
        
        </form>
        <div class="flex py-20 flex-col items-center gap-4">
            <div class="font-bold text-2xl">Results</div>
<div class="max-w-4xl border-2 border-black rounded-xl px-15 py-10">
            
<?

$event->free_result();
while ($con->more_results() && $con->next_result()) {
    if ($extra_result = $con->store_result()) {
        $extra_result->free_result();
    }
}



if (isset($_POST['fire']) && isset($_POST["start"]) && is_numeric($_POST["start"])) {
    $match_id = (int)$_POST["start"];

    $result = mysqli_query($con, "CALL check_winner($match_id);");

    if ($result) {
        $row = $result->fetch_row();
        echo "Winner: " . htmlspecialchars($row[5] ?? 'N/A');

        $result->free_result();
        while ($con->more_results() && $con->next_result()) {
            if ($extra_result = $con->store_result()) {
                $extra_result->free_result();
            }
        }
    } else {
        echo "Errore nella query: " . mysqli_error($con);
    }
} else {
    echo "Select a match!";
}
?>
        </div>
</div>
</div>

</body>

</html>
