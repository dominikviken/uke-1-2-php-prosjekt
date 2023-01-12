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
        <h1>Pardon Me; en Ordbok for Unnskyldninger</h1>
        <h3>Velg en Situasjon</h3>
        <!-- en form med metode get som gjør det mulig å sende data over til excuses siden -->
        <form action="/excuses.php/" method="get" id='form1'>
        
        <?php
        // Viser datoen idag på siden, med tidsonen som er i Amsterdam
        date_default_timezone_set("Europe/Amsterdam");
        // datoen er i format ÅR, MÅNED, DAG, TIME i 24 formaten, og MINUTT ved å bruke date funksjonen
        echo 'Dagens dato og tid er: ' . date("Y-m-d-H:i") . '<br><br>';
            
        // Tar inn navnet til serveren, brukernavnet som serveren er registrert under, passordet, og navnet til databasen
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "excuses";

        // Skaper en connection mellom serveren og nettsiden
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Sjekker om connectionen er stabil, og om den ikke er det så skjer ikke connectionen
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // sql kode for å velge occasion og id fra occasions tabellen, som sorterer den i rekkefølgen til id fra 1 til hvahenn
        $sql = "SELECT occasion, id FROM occasions ORDER BY id ASC;";

        // gjør at connectionen bruker utf8 får å unngå at øæå blir gjort til spørsmålstegn
        $conn->set_charset("utf8");

        // kjører sql koden fra tidligere, og lagrer det i result variabelen som en tabell
        $result = $conn->query($sql);

        // Hvis result tabellens rader er større enn 0..
        if ($result->num_rows > 0) {
        // ..skaper en while loop en variabel som lagrer alt dataen som ligger i et av radene, også.. 
        while($row = $result->fetch_assoc()) {
            // ..brukes denne variabelen i echoen under til å lage en knapp som har value lik ID-en til raden, med occasion som dens tekst
            echo '<button type="submit" form="form1" name="id" value=' . $row["id"] . '>' . $row["occasion"] . '</button><br>';
            // disse knappene gjør det da mulig å sende over valuen dens til excuses siden ved bruk av get requesten
        }
        // hvis result tabellens rader er mindre enn 0, vises teksten under.
        } else {
        echo "Fant ingen unnskyldninger, Skriv noen inn med teksboksen under.";
        }

        // hvis koden tar inn en post request, med navn av sendSit..
        if (isset($_POST["sendSit"])) {
            // lagres noe sql kode som legger inn en ny situasjon med dens value som post requestens sin value
            $occasionInsert = 'INSERT into occasions (occasion) values ("' . $_POST["sendSit"] . '")';
            // om denne konneksjonen er skapt, så refresher siden som da legger til en ny situasjon i nettleseren
            if ($conn->query($occasionInsert) === TRUE) {
                header("Refresh:0");
            // hvis denne er ikke skapt, kommer det opp at noe var feil og at brukeren kan vennligst laste siden på nytt. Dette var mest for å debugge hvorfor konneksjonen gikk til dass
            } else {
                echo 'FEIL, LAST SIDEN PÅ NYTT, OG PRØV IGJEN';
            }
        }
        ?>
        
        </form>
        <br>
        <!-- en form med metode post som da gjør det mulig å sende det som er inni over til serverens database ved bruk av php koden over -->
        <form action="" method="post">
            <input type="text" autocomplete='off' placeholder="Skriv Her.." name="sendSit" value="" id="textbox"> <input type="submit" value="Send inn Situasjon">
        </form>
    </div>
</body>
</html>