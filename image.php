<?php

//Importerar PDO
include 'sqlite.php';

//Hämtar ett requestId för att kunna veta vilken response vi ska köra
$requestId = $_REQUEST["requestId"];


//************************************************************************ */
//SHOW IMAGE RESULTS
if ($requestId == "showImages") {


    //Get the input
    $q = $_REQUEST["q"];

    //The response string
    $response = "";

    //Formaterar
    $qt = strtolower($q);
    $qt = trim($qt);

    //En array med varje ord separerat med " "
    $qArray = explode(" ", $qt);

    //itererar igenom arrayen
    for ($x = 0; $x < count($qArray); $x++) {

        //letar efter "och" och tar bort det
        if ($qArray[$x] == 'och') {
            //Tar bort "och" från arrayen
            unset($qArray[$x]);
            //Omordnar arryens indexering
            $qArray = array_values($qArray);
        }
    }

    //itererar igenom arrayen
    for ($x = 0; $x < count($qArray); $x++) {

        //letar efter "med" och tar bort det
        if ($qArray[$x] == 'med') {
            //Tar bort "och" från arrayen
            unset($qArray[$x]);
            //Omordnar arryens indexering
            $qArray = array_values($qArray);
        }
    }

    //Räknar hur många separata ord som söktes efter (antal element i arrayen)
    $count = count($qArray);


    //To avoid duplicates we create an array
    $usedBilder = array("test");


    //1 sökord
    if ($count === 1) {

        //SÄtter i till första (och enda) positionen i arryen
        $i = $qArray[0];
        //Lägger till en SQL-term för att funka med LIKE
        $i = "%" . $i . "%";
        //$z = "'" . $qArray[0] . "'";




        /*   $stmt1 = $pdo->query( "SELECT * 
                                FROM orginalbild ob 
                                JOIN kategorirad kr on ob.orginalbild_ID = kr.f_key_orginalbild 
                                JOIN kategori k on kr.f_key_kategori = k.kategori_ID 
                                WHERE k.KategoriNamn 
                                LIKE '$i%'; ");                               
        */

        $sql1 = "SELECT ob.rowid, * 
                FROM Orginalbild ob 
                INNER JOIN Kategorirad kr on ob.rowid = kr.fkey_Orginalbild 
                INNER JOIN Kategori k on kr.fkey_Kategori = k.Kategori_Id 
                WHERE k.KategoriNamn 
                LIKE ?;";

        $sql2 = "SELECT ob.rowid, * 
                FROM Orginalbild ob 
                INNER JOIN Nyckelordrad nr on ob.rowid = nr.fkey_Orginalbild 
                INNER JOIN Nyckelord n on nr.fkey_Nyckelord = n.rowid
                WHERE n.Ord 
                LIKE ?;";

        $stmt1 = $db->prepare($sql1);
        $stmt1->execute([$i]);

        //Går igenom alla rows som quarin gav en efter en
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {

            //Kollar ifall bilden (ID) redan blivit tillagd
            if (($key = array_search($row['rowid'], $usedBilder)) == false) {

                //Om svars-stängen är tom så läggs bara ordet till..
                if ($response === "") {
                    $response = $row['rowid'];

                    //..annars så läggs ett , till innan ordet.
                } else {
                    $response .= "," . $row['rowid'];
                }

                //Sparar bilden som lades till i listan av usedBilder
                array_push($usedBilder, $row['rowid']);
            }
        }

        //STMT 2

        $stmt2 = $db->prepare($sql2);
        $stmt2->execute([$i]);

        //Går igenom alla rows som quarin gav en efter en
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {

            //Kollar ifall bilden (ID) redan blivit tillagd
            if (($key = array_search($row['rowid'], $usedBilder)) == false) {

                //Om svars-stängen är tom så läggs bara ordet till..
                if ($response === "") {
                    $response = $row['rowid'];

                    //..annars så läggs ett , till innan ordet.
                } else {
                    $response .= "," . $row['rowid'];
                }

                //Sparar bilden som lades till i listan av usedBilder
                array_push($usedBilder, $row['rowid']);
            }
        }


        // 2 sökord 
    } else if ($count == 2) {


        //Förbereder för SQL "LIKE"
        $i = $qArray[1] . "%";


        //Denna tar emot 2 ord. Endast det sista ordet ska behandlas med LIKE, medans orden innan är ===
        $sql1 = "SELECT Kategorirad.fkey_Orginalbild, Orginalbild.Antalkategorier
                    FROM Orginalbild 
                    INNER JOIN Kategorirad ON Kategorirad.fkey_Orginalbild = Orginalbild.rowid 
                    INNER JOIN Kategori ON Kategorirad.fkey_Kategori = Kategori.Kategori_Id 
                    WHERE Kategori.KategoriNamn = ? 
                    OR Kategori.KategoriNamn LIKE ? 
                    GROUP BY Kategorirad.fkey_Orginalbild 
                    HAVING AntalKategorier = 2";



        $stmt1 = $db->prepare($sql1);
        //Tar första ordet i arrayen OCH $i som är sista positionen i arrayen behandlad för att klara av SQL's "LIKE"
        $stmt1->execute([$qArray[0], $i]);

        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {

            //Kollar ifall bilden (ID) redan blivit tillagd
            if (($key = array_search($row['fkey_Orginalbild'], $usedBilder)) == false) {

                //Om svars-stängen är tom så läggs bara ordet till..
                if ($response == "") {
                    $response = $row['fkey_Orginalbild'];

                    //..annars så läggs ett , till innan ordet.
                } else {
                    $response .= "," . $row['fkey_Orginalbild'];
                }

                //Sparar bilden som lades till i listan av usedBilder
                array_push($usedBilder, $row['fkey_Orginalbild']);
            }
        }




        //3 sökord EJ TESTAD
    } else if ($count === 3) {

        //Förbereder för SQL "LIKE"
        $i = $qArray[2] . "%";

        //Denna tar emot 2 ord. Endast det sista ordet ska behandlas med LIKE, medans orden innan är ===
        $sql3 = "SELECT Kategorirad.fkey_Orginalbild, Orginalbild.Antalkategorier
                    FROM Orginalbild 
                    INNER JOIN Kategorirad ON Kategorirad.fkey_Orginalbild = Orginalbild.Orginalbild_Id 
                    INNER JOIN Kategori ON Kategorirad.fkey_Kategori = Kategori.Kategori_Id 
                    WHERE Kategori.KategoriNamn = ? OR Kategori.KategoriNamn = ? OR Kategori.KategoriNamn LIKE ? 
                    GROUP BY Kategorirad.fkey_Orginalbild 
                    HAVING AntalKategorier = 3";



        $stmt2 = $db->prepare($sql3);
        //Tar första ordet i arrayen OCH $i som är sista positionen i arrayen behandlad för att klara av SQL's "LIKE"
        $stmt2->execute([$qArray[0], $qArray[1], $i]);

        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {

            //Kollar ifall bilden (ID) redan blivit tillagd
            if (($key = array_search($row['fkey_Orginalbild'], $usedBilder)) == false) {

                //Om svars-stängen är tom så läggs bara ordet till..
                if ($response == "") {
                    $response = $row['fkey_Orginalbild'];

                    //..annars så läggs ett , till innan ordet.
                } else {
                    $response .= "," . $row['fkey_Orginalbild'];
                }

                //Sparar bilden som lades till i listan av usedBilder
                array_push($usedBilder, $row['fkey_Orginalbild']);
            }
        }
    }


    //Echoar ut i URL'n 
    echo $response === "" ? "" : $response;



    //*********************************************************************************************** */
    //SHOW IMAGE DETAILS
} else if ($requestId == "showImageDetails") {


    //Get the input
    $ID = $_REQUEST["q"];

    //The response array
    $response = "";



    $sql1 = "SELECT rowid, * FROM Orginalbild WHERE Orginalbild.rowid = ?;";

    $stmt1 = $db->prepare($sql1);
    $stmt1->execute([$ID]);

    while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {

        $response = $row['rowid'] . "," . $row['Titel'] . "," . $row['AntalKategorier'] . "," . $row['Upplösning'] . "," . $row['BildStatus'] . "," . $row['AntalAnvändningar'] . "," . $row['Fotograf'] . "," . $row['Datum'] . "," . $row['Plats'] . "," . $row['GPS'] . "," . $row['Beskrivning'];
    }


    //Echoar ut i URL'n 
    echo $response === "" ? "" : $response;



    //*********************************************************************************************** */


    // SAVE THE WORD THAT MATCHED
} else if ($requestId == "m") {


    //Get the input
    $q = $_REQUEST["q"];

    //The response string
    $response = "";

    //Array
    $matchingWords = array("test");

    //Formaterar
    $qt = strtolower($q);
    $qt = trim($qt);

    //Gör stringen till array
    $array = explode(" ", $qt);

    //***************************1 ord******************************* */

    if (count($array) == 1) {

        //Förbereder för SQL "LIKE"
        $i = "%" . $array[0] . "%";


        //*********************KATEGORI************************* */

        $sqlmatch1 = "SELECT * 
        FROM Kategori k
        WHERE k.KategoriNamn 
        LIKE ?;";

        $match1 = $db->prepare($sqlmatch1);
        $match1->execute([$i]);

        //Går igenom alla rows som quarin gav en efter en
        while ($row = $match1->fetch(PDO::FETCH_ASSOC)) {

            //Sparar bilden som lades till i listan av usedBilder
            array_push($matchingWords, $row['KategoriNamn']);
        }



        //********************NYCKELORD**************************

        $sqlmatch2 = "SELECT * 
        FROM Nyckelord n
        WHERE n.Ord 
        LIKE ?;";

        $match2 = $db->prepare($sqlmatch2);
        $match2->execute([$i]);

        //Går igenom alla rows som quarin gav en efter en
        while ($row = $match2->fetch(PDO::FETCH_ASSOC)) {

            //Sparar bilden som lades till i listan av usedBilder
            array_push($matchingWords, $row['Ord']);
        }



        //En string med varje ord separerat med ", "
        for ($x = 1; $x < Count($matchingWords); $x++) {

            $response .= $matchingWords[$x] . ", ";
        }


        //***************************2 ord******************************* */

    } else if (count($array) == 2) {

        //Förbereder för SQL "LIKE"
        $i = "%" . $array[0] . "%"; 
        $z = "%" . $array[1] . "%";

        //*********************KATEGORI************************* */

        $sqlmatch1 = "SELECT * 
        FROM Kategori k
        WHERE k.KategoriNamn 
        LIKE ?;";

        $match1 = $db->prepare($sqlmatch1);
        $match1->execute([$i]);

        //Går igenom alla rows som quarin gav en efter en
        while ($row = $match1->fetch(PDO::FETCH_ASSOC)) {

            if (!array_search($row['KategoriNamn'], $matchingWords)){

                //Sparar bilden som lades till i listan av usedBilder
                array_push($matchingWords, $row['KategoriNamn']);
            }
        }

        $sqlmatch1 = "SELECT * 
        FROM Kategori k
        WHERE k.KategoriNamn 
        LIKE ?;";

        $match1 = $db->prepare($sqlmatch1);
        $match1->execute([$z]);

        //Går igenom alla rows som quarin gav en efter en
        while ($row = $match1->fetch(PDO::FETCH_ASSOC)) {

            if (!array_search($row['KategoriNamn'], $matchingWords)){

                //Sparar bilden som lades till i listan av usedBilder
                array_push($matchingWords, $row['KategoriNamn']);
            }
        }

         //En string med varje ord separerat med ", "
         for ($x = 1; $x < Count($matchingWords); $x++) {

            $response .= $matchingWords[$x] . ", ";
        }
    }

    //Echoar ut i URL'n 
    echo $response === "" ? "" : $response;
}
