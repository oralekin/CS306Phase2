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
    <a href="/user" class="text-indigo-400 text-sm hover:text-gray-500 underline ">Back</a>
    <h1 class="font-bold text-4xl flex gap-2 items-center justify-center">Trigger <div
        class="text-5xl text-red-400 rotate-45">3</div>
    </h1>
    <div class="font-bold text-md text-gray-400">by Ekin Oral</div>
    <p class="max-w-xl text-sm">According to our ER model, each judoka in a match has one match score entity related
      to
      them. A match score can either be a 1v1 score or a kata score, represented by an is-a relationship
      in our ER model. We chose to translate the match score entity as a single relation PlayedScore
      having attributes representing both 1v1 and kata score, and requiring that one and only one of the
      types of attributes may be set on an instance. Before a row is inserted into PlayedScore, these
      triggers will ensure that this constraint is satisfied and reject the operation if not.</p>
    <form method="post" class="flex gap-2 items-end ">
      <button value="query1" type="submit" name="query"
        class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">
        Invalid: No score attributes
      </button>
      <button value="query2" type="submit" name="query"
        class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">
        Invalid: Attributes of both
      </button>
      <button value="query3" type="submit" name="query"
        class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">
        Valid: 1v1 Score
      </button>
      <button value="query4" type="submit" name="query"
        class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">
        Valid: Kata score
      </button>
    </form>
    <div class="flex pt-20 flex-col items-center gap-4">
      <?php if (($_SERVER["REQUEST_METHOD"] == 'POST') && !empty($_POST['query'])) {
        ?>
        <div class="font-bold text-2xl">Results</div>
        <div class="max-w-4xl border-2 border-black rounded-xl px-15 py-10">
          <?php
          try {
            $conn = mysqli_connect(getenv("MYSQL_URL"), getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"), getenv("MYSQL_DATABASE"));
          } catch (Exception $e) { ?>
            Error: Unable to connect to MySQL. <br>
            Debugging errno: <?= mysqli_connect_errno() ?> <br>
            Debugging error: <?= mysqli_connect_error() ?> <br>
          <?php }
          if (isset($conn)) {
            $query_lists = [
              'query1' => [ // Invalid: No score attributes
                /* show  */ 'SELECT count(*) from PlayedScore;',
                /* pre   */ 'INSERT INTO PlayedScore (jId, mId, ippon, wazari, yuko, kScore, forfeit) VALUES (1, 11, NULL, NULL, NULL, NULL, FALSE);',
                /* show  */ 'SELECT count(*) from PlayedScore;',
              ],
              'query2' => [ // Invalid: Attributes of both
                /* show  */ 'SELECT count(*) from PlayedScore;',
                /* pre   */ 'INSERT INTO PlayedScore (jId, mId, ippon, wazari, yuko, kScore, forfeit) VALUES (1, 11, 1, 0, 0, 20, FALSE);',
                /* show  */ 'SELECT count(*) from PlayedScore;',
              ],
              'query3' => [ // Valid: 1v1 Score
                /* show  */ 'SELECT count(*) from PlayedScore;',
                /* pre   */ 'INSERT INTO PlayedScore (jId, mId, ippon, wazari, yuko, kScore, forfeit) VALUES (1, 11, 0, 2, 3, NULL, FALSE);',
                /* show  */ 'SELECT count(*) from PlayedScore;',
                /* clean */ 'DELETE FROM PlayedScore WHERE jId = 1 AND mId = 11;',
              ],
              'query4' => [ // Valid: Kata score
                /* show  */ 'SELECT count(*) from PlayedScore;',
                /* pre   */ 'INSERT INTO PlayedScore (jId, mId, ippon, wazari, yuko, kScore, forfeit) VALUES (1, 11, NULL, NULL, NULL, 10, FALSE);',
                /* show  */ 'SELECT count(*) from PlayedScore;',
                /* clean */ 'DELETE FROM PlayedScore WHERE jId = 1 AND mId = 11;',
              ],
            ];


            if (!isset($query_lists[$_POST['query']])) {
              echo "Something went wrong!";
            } else {
              foreach ($query_lists[$_POST['query']] as $query) {
                ?>
                <?= isset($first) ? '<hr>' : (($first = true) && '') ?>
                <div class="p-1 m-1">
                  <strong>Query:</strong><br><code class="ml-4"> <?= $query ?> </code><br>
                  <strong>Result:</strong>
                  <blockquote class="ml-4">
                    <?php
                    try {
                      $res = $conn->query($query);
                    } catch (Exception $e) {
                      $res = false;
                    }

                    if ($res == false) {
                      echo "<strong>Error:</strong> $conn->error";

                    } else {
                      echo "<strong>Success.</strong><br>";
                      if (!is_bool($res)) {
                        ?>
                        <table class="border border-2 border-collapse m-1">
                          <thead class="border border-b-2 border-gray-500">
                            <tr>
                              <?php foreach ($res->fetch_fields() as $field) { ?>
                                <th class="py-1 px-2"><?= $field->name ?></th>
                              <?php } ?>
                            </tr>
                          </thead>
                          <?php foreach ($res as $row) { ?>
                            <tr>
                              <?php foreach ($row as $cell) { ?>
                                <td class="py-1 px-2 border"><?= $cell ?></td>
                              <?php } ?>
                            </tr>
                          <?php } ?>
                        </table>

                        <?php
                      }
                    }
                    ?>
                  </blockquote>
                </div>
                <?php
              }
            }

            $conn->close();
          }


      }
      ?>
      </div>
    </div>
</body>

</html>