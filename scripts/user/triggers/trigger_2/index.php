<?php

$con = mysqli_connect(getenv('MYSQL_URL'), "root", getenv('MYSQL_ROOT_PASSWORD'), getenv("MYSQL_DATABASE"));

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
$event1 = mysqli_query($con, "Select * from Judoka where jId = 1");
$event2 = mysqli_query($con, "Select * from Judoka where jId = 3");

$failureQuery = "INSERT INTO TeachIn (dId, jId, cAge, cLevel) VALUES (10, 1, 'Adult', 'Advanced')";
$okQuery = "INSERT INTO TeachIn (dId, jId, cAge, cLevel) VALUES (10, 3, 'Elderly', 'Beginner')";

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trigger 2</title>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>
<div class="flex flex-col gap-4 justify-center items-center min-h-screen">
<a href="/user" class="text-indigo-400 text-sm hover:text-gray-500 underline ">Back</a>
<h1 class="font-bold text-4xl flex gap-2 items-center justify-center">Trigger <div class="text-5xl text-red-400 rotate-45">2</div>
</h1>
<div class="font-bold text-md text-gray-400">By Edoardo Cecca</div>
<p class="max-w-xl text-sm">The Judoka-Dojo relationship where the judoka is an instructor at the dojo is represented by
the TeachIn relation. According to our requirements, a judoka must be at a black belt level in
order to be allowed to teach at a dojo. Before a row is inserted or updated, these two triggers
ensure that the referenced judoka has a black belt by rejecting the operation if not.</p>
<div><?
$event1 = $event1->fetch_row();
echo "jId: " . $event1[0] . " (" . $event1[1] . ", " . $event1[4] . ", " . $event1[6] . ")";
?></div>
<div><?
$event2 = $event2->fetch_row();
echo "jId: " . $event2[0] . " (" . $event2[1] . ", " . $event2[4] .", ". $event2[6] . ")";
?></div>
<form method="post" class="flex gap-2 items-end ">
<button value="ok" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Invalid teacher</button>
<button value="notValid" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Valid teacher</button>
</form>
<div class="flex py-20 flex-col items-center gap-4">
<div class="font-bold text-2xl">Results</div>
<div class="max-w-4xl border-2 border-black rounded-xl px-15 py-10"> 
<?

if (isset($_POST['fire'])) {
    $query = $_POST['fire'] == "notValid" ? $failureQuery : $okQuery;
    // echo $query;
    if ($result = mysqli_query($con, $query)) {
        echo "Element inserted";
    }
}
$con->close()
?>

</div>
</div>
</body>

</html>
