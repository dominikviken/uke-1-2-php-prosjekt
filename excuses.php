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
    
    <!-- en tekstboks som kjører funksjonen søke som ligger på linje 72-->
    <input type="text" id="search" onkeyup="søke()" placeholder="Søk etter Unnskyldning..">
    <!-- lager en liste, der alt som har li taggen er inni -->
    <ul id='list'>

    <!-- form som sender informasjon, og brukeren av nettsiden til show.php -->
    <form action="/show.php/" method="get" id='form2'>
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

    // lagrer GET requestens sin value som id variabel 
    $id = $_GET["id"];

    $sql = "SELECT excuse, id FROM excuses WHERE parent_id = $id ORDER BY id ASC;";
    $conn->set_charset("utf8");

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo '<li><button id="btn" type="submit" form="form2" name="id" value=' . $row["id"] . '>' . $row["excuse"] . '</button></li>';
      }
    } else {
      echo "Ingen unnskyldninger funnet. Du kan legge til en ny en med tekstboksen under.";
    }

    if (isset($_POST["sendExc"])) {
      // sql kode som sender inn en unnskyldning som har id variabelen som situasjonen sin id, og postens value som unnskyldningen
      $excuseInsert = 'INSERT into excuses (parent_id, excuse) values (' . $id . ', "' . $_POST["sendExc"] . '")';
      if ($conn->query($excuseInsert) === TRUE) {
          header("Refresh:0");
      } else {
          echo 'FEIL, PRØV IGJEN';
      }
    }
    ?>
    </form>
    </ul>

    <!-- formen under gjør at man kan legge til unnskyldinger til situasjonen -->
    <form action="" method="post">
        <input type="text" autocomplete='off' placeholder="Skriv Her.." name="sendExc" value="" id="textbox"> <input type="submit" value="Send inn Unnskyldning">
    </form>

    <br>
    <!-- tibake knapp som gjør at om man trykker på den, blir man sendt til forrige fane i browserens historie -->
    <input type="button" value="<- Tilbake?" onclick="history.back()">
  </div>
</body>
<script>
  // søke funksjonen filtrerer ut alle knappene som har innholdet til søkeboksen i seg, ved å gjøre de som usynelige eller synelige
  function søke() {
    // lager variabler for søkeboksen, en filter, listenes innhold, knappene, i for for loopene, og txtvalue for knappenes innhold
    var input, filter, li, btn, i, txtValue;
    // input variabelen er lik en tekstboks med id-en search for å finne søkeboksen
    input = document.getElementById('search');
    // filteret gjør det som er i tekstboksen til store bokstaver for å gjøre at søkene ikke trenger å være veldig spesifike med store, og lille bokstaver
    filter = input.value.toUpperCase();
    list = document.getElementById("list");
    li = list.getElementsByTagName('li');

    // for mengden av knapper innenfor listen.. 
    for (i = 0; i < li.length; i++) {
      // lagrer knappen som btn variabel ved å ta inn indexen til lista..
      btn = li[i].getElementsByTagName("button")[0];
      // lagrer innholdet til knappen
      txtValue = btn.textContent || btn.innerText;
      // hvis innholdet i store bokstaver er i lista, og er større enn -1..
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        // blir knappene synelige..
        li[i].style.display = "";
      } 
      // hvis innholdet er ikke i lista, blir knappene usynelige
      else {
        li[i].style.display = "none";
      }
    }
  }
</script>
</html>