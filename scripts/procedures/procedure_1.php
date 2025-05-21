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
    <title>Procedure 1</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>
    <div class="flex flex-col gap-4 justify-center items-center min-h-screen">
        <a href="/user" class="text-gray-400 text-sm hover:text-gray-500">Back</a>
        <h1 class="font-bold text-4xl">Procedure 1</h1>
        <div class="font-bold text-md text-gray-400">By Thorfinn Thorsson</div>
        <p class="max-w-xl text-sm">This stored procedure takes in one parameters called year, and returns all the judokas that started
            in that year.
            Before insert operation After insert operation
        </p>
        <form method="post" class="flex gap-2 items-end ">
            <div class="flex flex-col"><label for="start">Year</label><input value="" name="start" class="bg-white border-2 border-gray-300 min-w-50 rounded-xl" /></div>


            <button value="fire" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Test Trigger</button>
        </form>
        <div class="flex pt-20 flex-col items-center gap-4">
            <div class="font-bold text-2xl">Results</div>
            <div class="max-w-4xl">
                <?
                if (isset($_POST['fire']) && isset($_POST["start"]) && is_numeric($_POST["start"])) {
                    $query = "CALL yearly_subs('" . $_POST["start"] . "-01-01','" . $_POST["start"] + 1 . "-01-01');";
                   
                    if ($result = mysqli_query($con, $query)) {
                        if (mysqli_num_rows($result) > 0) {
                            for ($i = 0; $i < $result->num_rows; $i++) {
                                $row = $result->fetch_row();
                                echo  $row[1] . "<br/>";
                            }
                        } else echo "No results";
                    }
                } else {
                    echo  "Insert a year!";
                }

                ?>
            </div>
        </div>
    </div>
</body>

</html>