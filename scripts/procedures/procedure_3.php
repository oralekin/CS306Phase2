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
        <a href="/user" class="text-indigo-400 text-sm hover:text-gray-500 underline ">Back</a>
        <h1 class="font-bold text-4xl flex gap-2 items-center justify-center">Procedure <div class="text-5xl text-red-400 -rotate-45">3</div>
        </h1>
        <div class="font-bold text-md text-gray-400">By Thorfinn Thorsson</div>
        <p class="max-w-xl text-sm">This stored procedure returns the id, gross income, and name of judo event in the database
            that made the most gross income from participant entry fees. The gross income is found by
            multiplying the fee for the event with the number of approved requests to participate in the event.</p>
        <form method="post" class="flex gap-2 items-end ">
            <div class="flex flex-col"><label for="start">Year</label><input value="" name="start" class="bg-white border-2 border-gray-300 min-w-50 rounded-xl" /></div>


            <button value="fire" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Test Trigger</button>
        </form>
        <div class="flex pt-20 flex-col items-center gap-4">
            <div class="font-bold text-2xl">Results</div>
            <div class="max-w-4xl border-2 border-black rounded-xl px-15 py-10"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab dolores commodi ipsum excepturi voluptatibus quibusdam harum eligendi, obcaecati repudiandae id alias pariatur ex, molestias quae maxime corrupti explicabo, aliquid tempora?</div>
        </div>
    </div>
</body>

</html>