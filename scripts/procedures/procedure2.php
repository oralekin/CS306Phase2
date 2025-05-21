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
        <h1 class="font-bold text-4xl">Procedure 2</h1>
        <div class="font-bold text-md text-gray-400">By Thorfinn Thorsson</div>
        <p class="max-w-xl text-sm">This stored procedure takes in one integer parameter, a match id, and returns the match id,
            total points, point composition and the name of the judoka who won the match. This stored
            procedure implements the calculation to get total score from score components, as well as
            checking for forfeits. The script for this is included below.</p>
        <button class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Test Trigger</button>
        <div class="flex pt-20 flex-col items-center gap-4">
            <div class="font-bold text-2xl">Results</div>
            <div class="max-w-4xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab dolores commodi ipsum excepturi voluptatibus quibusdam harum eligendi, obcaecati repudiandae id alias pariatur ex, molestias quae maxime corrupti explicabo, aliquid tempora?</div>
        </div>
    </div>

</body>

</html>