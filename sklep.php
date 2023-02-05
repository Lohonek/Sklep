<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<style>
    body{
        background-color: #6096B4;
    }


    .center{
        display: flex;
        margin: 10% 10%;
    }

    .left{
        width: 50%;
        text-align:center;
        margin: 4% 0;
    }

    .right{
        width: 50%;
        text-align:center;
        background-color: #93BFCF;
    }

    .wynik{
        text-align:center;
        margin-left:25%;
        margin-right:25%;

    }
    table {
        color: #333;
        background: white;
        border: 1px solid grey;
        font-size: 12pt;
        border-collapse: collapse;
    }

    table th,
    table td {
        padding: .5em;
        border: 1px solid lightgrey;
    }
    input {
    width: 120px;
    margin: 5px;
    font-size: 20px;
    border: 2px solid #000;
    border-radius: 5px;
    }   


    #cena{
        font-size:26px;
    }


</style>

<?php
error_reporting(E_ERROR | E_PARSE);


@$chleb = $_POST['chleb'];
@$bulka = $_POST['bulka'];
@$maslo = $_POST['maslo'];
@$mleko = $_POST['mleko'];
@$woda = $_POST['woda'];
@$sok = $_POST['sok'];
@$staly = $_POST['staly'];
@$upust = $_POST['upust'];



$ck = ($chleb * 2.58) + ($bulka * 1.67) + ($maslo * 3.99) + ($mleko * 3.32) + ($woda * 0.99 + $sok * 2.11);


if ($staly) {
  $ck = $ck * 0.97;
}

if($upust == "5"){
   $ck = $ck * 0.95;
} elseif ($upust == "10"){
  $ck = $ck  * 0.90;
} elseif($upust == "15"){
  $ck = $ck * 0.85;
}



@$imie = $_POST['imie'];
@$nazwisko = $_POST['nazwisko'];
@$kodpocztowy = $_POST['kodpocztowy'];
@$ulica = $_POST['ulica'];
@$miejscowosc = $_POST['miejscowosc'];
@$telefon = $_POST['telefon'];



    if($_POST["button1"]) {

        if(empty($imie) or empty($nazwisko) or empty($kodpocztowy) or empty($ulica) or empty($miejscowosc) or empty($telefon)){
            echo 'Uzupelnij wszystkie dane';
        } else {

        $polacz = mysqli_connect("localhost", "root", "");
        $db = mysqli_select_db($polacz, "mojsklep");
        $kwer = "INSERT INTO dane (imie,nazwisko,kodpocztowy,ulica,miejscowosc,telefon,cenakoncowa) VALUES ('$imie', '$nazwisko', '$kodpocztowy', '$ulica', '$miejscowosc', '$telefon', '$ck');";
        $wykonanie = mysqli_query($polacz, $kwer);

        mysqli_close($polacz);

            }
        
    }



?>
<div class="center">
<div class="left">
<form action="" method="post">

    <table border="1">
        <tr>
            <td>Nazwa</td>
            <td>Cena</td>
            <td id="ilosc">Ilość</td>
        </tr>
        <tr>
            <td>Chleb</td>
            <td>2,58</td>
            <td id="ilosc"><input type="number" name="chleb" value="0"></td>
        </tr>
        <tr>
            <td>Bulka</td>
            <td>1,67</td>
            <td id="ilosc"><input type="number" name="bulka" value="0"></td>
        </tr>
        <tr>
            <td>Maslo</td>
            <td>3,99</td>
            <td id="ilosc"><input type="number" name="maslo" value="0"></td>
        </tr>
        <tr>
            <td>Mleko</td>
            <td>3,32</td>
            <td id="ilosc"><input type="number" name="mleko"value="0"></td>
        </tr>
        <tr>
            <td>Woda</td>
            <td>0.99</td>
            <td id="ilosc"><input type="number" name="woda" value="0"></td>
        </tr>
        <tr>
            <td>Sok</td>
            <td>2,11</td>
            <td id="ilosc"><input type="number" name="sok" value="0"></td>
        </tr>
    </table>
    </div>
    <div class="right">
        <br>
        <br>
        <label for="staly">Stały Klient?</label>
        <input type="checkbox" id="staly" name="staly">
        <br><br>
        <label for="0">Upust :5%</label>
        <input type="radio" value="5" name="upust" id="0">
        <label for="0">10%</label>
        <input type="radio" value="10" name="upust" id="5">
        <label for="0">15%</label>
        <input type="radio" value="15" name="upust" id="10">


        <br><br>
        <label for="imie">Imię</label>
        <input type="text" id="imie" name="imie"    >
        <br>
        <label for="nazwisko">Nazwisko</label>
        <input type="text" id="nazwisko" name="nazwisko">
        <br>
        <label for="kodpocztowy">Kod Pocztowy</label>
        <input type="text" id="kodpocztowy" name="kodpocztowy">
        <br>
        <label for="ulica">Ulica</label>
        <input type="text" id="ulica" name="ulica">
        <br>
        <label for="miejscowosc">Miejscowość</label>
        <input type="text" id="miejscowosc" name="miejscowosc">
        <br>
        <label for="telefon">Telefon</label>
        <input type="text" id="telefon" name="telefon" value="">

        <br><br>
        <input type="submit" value="Kup" name="button1">
        <input type="submit" value="Zamowienia" name="button2">
    </form>
    </div>
    </div>
    <div class="wynik">
    <?php
        echo "<span id='cena'>Razem: $ck zł</span>";

        $polacz = mysqli_connect("localhost", "root", "");
        $db = mysqli_select_db($polacz, "mojsklep");
        $kwer = "SELECT imie,nazwisko,kodpocztowy,ulica,miejscowosc,telefon,cenakoncowa FROM dane";
        $wynik = mysqli_query($polacz, $kwer);


        if($_POST["button2"]) {
            if ($wynik->num_rows > 0) {
                echo "<table><tr><th>Imie</th><th>Nazwisko</th><th>Kod Pocztowy</th><th>Ulica</th><th>Miejscowość</th><th>Telefon</th><th>Cena zamowienia</th></tr>";

                while($row = $wynik->fetch_assoc()) {
                echo "<tr><td>".$row["imie"]."</td><td>".$row["nazwisko"]."</td><td>".$row["kodpocztowy"]."</td><td>".$row["ulica"]."</td><td>".$row["miejscowosc"]."</td><td>".$row["telefon"]."</td><td>".$row["cenakoncowa"]."</td></tr>";
                }
                echo "</table>";
            }
        }

    ?>
    </div>
</body>
</html>