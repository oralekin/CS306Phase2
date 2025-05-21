<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trigger 3</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>
    <div class="flex flex-col gap-4 justify-center items-center min-h-screen">
        <a href="/user" class="text-gray-400 text-sm hover:text-gray-500">Back</a>
        <h1 class="font-bold text-4xl">Trigger 3</h1>
        <div class="font-bold text-md text-gray-400">By Thorfinn Thorsson</div>
        <p class="max-w-xl text-sm">According to our ER model, each judoka in a match has one match score entity related to
            them. A match score can either be a 1v1 score or a kata score, represented by an is-a relationship
            in our ER model. We chose to translate the match score entity as a single relation PlayedScore
            having attributes representing both 1v1 and kata score, and requiring that one and only one of the
            types of attributes may be set on an instance. Before a row is inserted into PlayedScore, these
            triggers will ensure that this constraint is satisfied and reject the operation if not.</p>
        <form method="post" class="flex gap-2 items-end ">
            <button value="fire" type="submit" name="fire" class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">Test Trigger</button>
        </form>
        <div class="flex pt-20 flex-col items-center gap-4">
            <div class="font-bold text-2xl">Results</div>
            <div class="max-w-4xl">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab dolores commodi ipsum excepturi voluptatibus quibusdam harum eligendi, obcaecati repudiandae id alias pariatur ex, molestias quae maxime corrupti explicabo, aliquid tempora?</div>
        </div>
    </div>
</body>

</html>