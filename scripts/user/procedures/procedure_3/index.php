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
    <h1 class="font-bold text-4xl flex gap-2 items-center justify-center">Procedure <div
        class="text-5xl text-red-400 rotate-45">3</div>
    </h1>
    <div class="font-bold text-md text-gray-400">By Ekin Oral</div>
    <p class="max-w-xl text-sm">This stored procedure returns the id, gross income, and name of judo event in the
      database
      that made the most gross income from participant entry fees. The gross income is found by
      multiplying the fee for the event with the number of approved requests to participate in the event.</p>
    <form method="post" class="flex gap-2 items-end ">
      <button value="query1" type="submit" name="query"
        class="bg-indigo-500 border-2 border-indigo-400  text-white p-2 cursor-pointer active:scale-95 rounded-xl font-bold">
        Demonstrate
      </button>
    </form>
    <div class="flex py-20 flex-col items-center gap-4">
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
                /* components */ 'SELECT R.eId, count(DISTINCT R.jId), JE.price, COUNT(R.rStatus) * JE.price FROM Request R, JudoEvents JE WHERE R.rStatus = \'approved\' AND JE.eId = R.eId GROUP BY R.eId, JE.eName ORDER BY COUNT(R.rStatus) * JE.price DESC;',
                /* procedure  */ 'CALL maxProfitEvent;',
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