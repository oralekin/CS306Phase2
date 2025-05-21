<?php

$con = mysqli_connect(getenv('MYSQL_URL'), "root", getenv('MYSQL_ROOT_PASSWORD'), getenv("MYSQL_DATABASE"));

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
$event = mysqli_query($con, "Select * from JudoEvents where eId = 1 ");

$outsideQuery = "INSERT INTO JudoMatch (mTime, mDate, eId) VALUES (3.42, '2026-08-01', 1)";
$insideQuery = "INSERT INTO JudoMatch (mTime, mDate, eId) VALUES (3.42, '2025-08-01', 1)";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trigger 1</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>
    <div class="flex flex-col gap-4 justify-center items-center min-h-screen">
        <a href="/user" class="text-indigo-400 text-sm hover:text-gray-500 underline ">Back</a>
        <h1 class="font-bold text-4xl flex gap-2 items-center justify-center">Trigger <div class="text-5xl text-red-400 rotate-45">1</div>
        </h1>
        <div class="font-bold text-md text-gray-400">By Daniele Venere</div>
        <p class="max-w-xl text-sm">When judo matches are inserted into JudoMatch, they must be associated with a judo
            event which has specified start and end dates. Based on our real-world requirements, a constraint
            is that a match date must fall inside the duration of the event it is associated with. Before a row is
            inserted into or updated in JudoMatch, these two triggers verify that the date is valid given the
            constraint, and reject the insert or update if it is invalid, ensuring consistency</p>
        <div><?
                $event = mysqli_query($con, "Select * from JudoEvents where eId = 1 ");
                $event = $event->fetch_row();
                echo "eid 1: " . $event[1] . " (" . $event[4] . ", " . $event[5] . ")";
                // echo print_r($event->fetch_row());
                ?></div>
        <div><span class="font-bold">Outside range query:</span> <? echo $outsideQuery ?></div>
        <div><span class="font-bold">Inside range query:</span> <? echo $insideQuery ?></div>

        <form method="post" class="flex gap-2 items-end ">
            <button value="outside" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Outside the date</button>
            <button value="inside" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Inside the date</button>
        </form>
        <div class="flex pt-20 flex-col items-center gap-4">
            <div class="font-bold text-2xl">Results</div>
            <div class="max-w-4xl border-2 border-black rounded-xl px-15 py-10"> <?

                                                                                    if (isset($_POST['fire'])) {
                                                                                        $query = $_POST['fire'] == "outside" ? $outsideQuery : $insideQuery;
                                                                                        // echo $query;
                                                                                        if ($result = mysqli_query($con, $query)) {
                                                                                            echo "Element inserted";
                                                                                        }
                                                                                    }
                                                                                    ?></div>
        </div>
    </div>
</body>

</html>