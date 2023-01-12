<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pardon Me; en Ordbok for Unnskyldninger</title>
</head>
<link rel="stylesheet" href="/style.css">
<body>
  <div class="site">
    <h1>Unnskyldninger</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "excuses";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_GET["id"];
    
    date_default_timezone_set("Europe/Amsterdam");
    // lagrer datoen som en variabel
    $date = date(("Y-m-d-H:i"));

    $sql = "SELECT date, timesUsed FROM excuses WHERE id = $id";
    
    // sql kode for å oppdatere datoen funnet innenfor excuses tabellen i databasen, og plusse ganger du har brukt unnskyldningen med 1 der id-en er lik id fra get requesten fra excuses.php
    $sqlUpdateDate = "UPDATE excuses set date = '$date', timesUsed = timesUsed+1 where id = $id";

    $conn->set_charset("utf8");

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo "Du brukte denne unnskyldningen sist: ". $row["date"] . '<br>';
        // hvis unnskyldningen har blitt brukt bare 1 gang, vises det "gang"
        if ($row["timesUsed"] == 1) {
          echo "Du har brukt denne unnskyldningen " . $row["timesUsed"] . ' gang. <br>';
        }
        // ellers viser det "ganger"
        else {
          echo "Du har brukt denne unnskyldningen " . $row["timesUsed"] . ' ganger. <br>';
        }
      }
    } else {
      echo "Du har ikke brukt denne unnskyldningen før.";
    }


    if (isset($_POST["update"])) {
      if ($conn->query($sqlUpdateDate) === TRUE) {
      }
      header("Refresh:0");
    }
    ?>
    <br>
    <form action="" method="post">
      <input id="btn" type="submit" name="update" value="Trykk her for å bruke denne unnskyldningen" />
    </form>

    <br>
    
    <form>
      <input type="button" value="<- Tilbake?" onclick="history.back()">
    </form>
  </div>
</body>
</html>