    <?php

    require_once 'db_connect.php';
    global $dbConnection;

    echo "\n fisierul curent este : " . getcwd();
    // urgente-medicale
    function addUrgenteMedicale($year)
    {
        global $dbConnection;

        $filename = '/fisiere_date/urgente-medicale-droguri-2022.csv';
        $lineCounter = 0;

        // deschid fisierul CSV pentru citire
        $f = fopen($filename, 'r');
        if ($f === false) {
            die('Eroare la deschiderea fisierului ' . $filename);
        }

        $insert_sex = $dbConnection->prepare("INSERT INTO urgente_tip_sex (sex, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_varsta = $dbConnection->prepare("INSERT INTO urgente_tip_varsta (varsta, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_cale = $dbConnection->prepare("INSERT INTO urgente_tip_cale (cale, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_model = $dbConnection->prepare("INSERT INTO urgente_tip_model (model, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_diagnostic = $dbConnection->prepare("INSERT INTO urgente_tip_diagnostic (diagnostic, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");

        // citesc fiecare rand din fisier
        while (($row = fgetcsv($f)) !== false) {
            $lineCounter++;

            // sar peste primele linii nefolositoare
            if ($lineCounter <= 6 || $lineCounter == 10 || $lineCounter == 16 || $lineCounter == 22 || $lineCounter == 28) {
                continue;
            }

            // distributia pe tipul drogului si sex
            if ($lineCounter >= 7 && $lineCounter <= 8) {
                $sex = $row[0];
                $canabis = (int) $row[1];
                $stimulanti = (int) $row[2];
                $opiacee = (int) $row[3];
                $nsp = (int) $row[4];
                $insert_sex->execute([$sex, $canabis, $stimulanti, $opiacee, $nsp, $year]);
            }
            // distributia pe tipul drogului si varsta
            elseif ($lineCounter >= 11 && $lineCounter <= 13) {
                $varsta = $row[0];
                $canabis = (int) $row[1];
                $stimulanti = (int) $row[2];
                $opiacee = (int) $row[3];
                $nsp = (int) $row[4];
                $insert_varsta->execute([$varsta, $canabis, $stimulanti, $opiacee, $nsp, $year]);
            }
            // distributia pe tipul drogului si calea de administrare
            elseif ($lineCounter >= 17 && $lineCounter <= 19) {
                $cale = $row[0];
                $canabis = (int) $row[1];
                $stimulanti = (int) $row[2];
                $opiacee = (int) $row[3];
                $nsp = (int) $row[4];
                $insert_cale->execute([$cale, $canabis, $stimulanti, $opiacee, $nsp, $year]);
            }
            // distributia pe tipul drogului si modelul de consum
            elseif ($lineCounter >= 23 && $lineCounter <= 24) {
                $model = $row[0];
                $canabis = (int) $row[1];
                $stimulanti = (int) $row[2];
                $opiacee = (int) $row[3];
                $nsp = (int) $row[4];
                $insert_model->execute([$model, $canabis, $stimulanti, $opiacee, $nsp, $year]);
            }
            // distributia pe tipul drogului si diagnosticul de urgenta
            elseif ($lineCounter >= 29 && $lineCounter <= 36) {
                $diagnostic = $row[0];
                $canabis = (int) $row[1];
                $stimulanti = (int) $row[2];
                $opiacee = (int) $row[3];
                $nsp = (int) $row[4];
                $insert_diagnostic->execute([$diagnostic, $canabis, $stimulanti, $opiacee, $nsp, $year]);
            }
        }

        fclose($f);
    }

    // infractionalitate
    function addInfractionalitati($year)
    {
        global $dbConnection;

        $filename = '/fisiere_date/capturi-droguri-2022.csv';
        $lineCounter = 0;

        // deschid fisierul CSV pentru citire
        $f = fopen($filename, 'r');
        if ($f === false) {
            die('Eroare la deschiderea fisierului ' . $filename);
        }

        $insert_statement1 = $dbConnection->prepare("INSERT INTO persoane_cercetate_judecata_condamnate (categorie, numar, year) VALUES (?, ?, ?)");
        $insert_statement2 = $dbConnection->prepare("INSERT INTO persoane_condamnate_incadrarea_juridica (incadrare_juridica, numar, year) VALUES (?, ?, ?)");
        $insert_statement3 = $dbConnection->prepare("INSERT INTO persoane_condamnate_sexe (sex, majore, minore, year) VALUES (?, ?, ?, ?)");
        $insert_statement4 = $dbConnection->prepare("INSERT INTO grupari_infractionale (categorie, numar, year) VALUES (?, ?, ?)");
        $insert_statement5 = $dbConnection->prepare("INSERT INTO pedepse_aplicate (tip_pedeapsa, lege_143_2000, lege_194_2011, year) VALUES (?, ?, ?, ?)");

        // citesc fiecare rand din fisier
        while (($row = fgetcsv($f)) !== false) {
            $lineCounter++;
            if ($lineCounter >= 6) {
                // primul bloc de date
                if ($lineCounter == 6 || $lineCounter == 7 || $lineCounter == 8) {
                    $categorie = $row[0];
                    $numar = (int) $row[1];
                    $insert_statement1->execute([$categorie, $numar, $year]);
                }
                // al doilea bloc de date
                elseif ($lineCounter >= 12 && $lineCounter <= 15) {
                    $incadrare_juridica = $row[0];
                    $numar = (int) $row[1];
                    $insert_statement2->execute([$incadrare_juridica, $numar, $year]);
                }
                // al treilea bloc de date
                elseif ($lineCounter >= 19 && $lineCounter <= 20) {
                    $sex = $row[0];
                    $majore = (int) $row[1];
                    $minore = (int) $row[2];
                    $insert_statement3->execute([$sex, $majore, $minore, $year]);
                }
                // al patrulea bloc de date
                elseif ($lineCounter == 25 || $lineCounter == 26) {
                    $categorie = $row[0];
                    $numar = (int) $row[1];
                    $insert_statement4->execute([$categorie, $numar, $year]);
                }
                // al cincilea bloc de date
                elseif ($lineCounter >= 31 && $lineCounter <= 35) {
                    $tip_pedeapsa = $row[0];
                    $lege_143_2000 = (int) $row[1];
                    $lege_194_2011 = (int) $row[2];
                    $insert_statement5->execute([$tip_pedeapsa, $lege_143_2000, $lege_194_2011, $year]);
                }
            }
        }

        fclose($f);
    }

    // campanii si prevenire
    function addCampanii($year)
    {
        global $dbConnection;
        $filename = '/fisiere_date/proiecte-si-campanii-2022.csv';
        $lineCounter = 2;

        // deschid fisierul CSV pentru citire
        $f = fopen($filename, 'r');
        if ($f === false) {
            die('Eroare la deschiderea fisierului ' . $filename);
        }
        $insert_statement = $dbConnection->prepare("INSERT INTO campanii_prevenire (proiecte, nr_activitati, year) VALUES (?, ?, ?)");

        // citesc fiecare rand din fisier
        while (($row = fgetcsv($f)) !== false) {
            $atribut1 = $row[0];
            $atribut2 = $row[1];
            if ($lineCounter == 2) {
                // sar peste titlurile coloanelor
                $lineCounter = 0;
            } else if ($atribut1 != "" || $atribut2 != "") {
                // inserez datele din rand in baza de date
                $insert_statement->execute([$atribut1, $atribut2, $year]);
            } else {
                $lineCounter++;
            }
        }
        fclose($f);
    }

    // capturi droguri
    function addCapturiDroguri($year)
    {
        global $dbConnection;

        $filename = '/fisiere_date/capturi-droguri-2022.csv';
        $lineCounter = 0;

        // deschid fisierul CSV pentru citire
        $f = fopen($filename, 'r');
        if ($f === false) {
            die('Eroare la deschiderea fisierului ' . $filename);
        }

        $insert_statement = $dbConnection->prepare("INSERT INTO droguri_confiscate (id_drog_tip, name, grame, comprimate, doze_pe_buc, mililitri, capturi, year) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert_statement2 = $dbConnection->prepare("INSERT INTO drugstable (name, type, image, description) VALUES (?, ?, ?, ?)");

        // citesc fiecare rand din fisier
        while (($row = fgetcsv($f)) !== false) {
            $lineCounter++;
            if ($lineCounter >= 6) {
                // extrag fiecare atribut din randul citit
                $atribut1 = $row[0];
                $atribut2 = $row[1];
                $atribut3 = $row[2];
                $atribut4 = $row[3];
                $atribut5 = $row[4];
                $atribut6 = $row[5];

                // inserez si numele drogului daca nu exista
                if (!verifyIfDrogNameExist($atribut1)) {
                    $insert_statement2->execute([$atribut1]);
                }

                // obtin id-ul drogului inserat sau existent
                $drug_id = getIdDrog($atribut1);

                // inserez datele din rand in baza de date droguri_confiscate, folosind drug_id-ul obtinut
                $insert_statement->execute([$drug_id, $atribut2, $atribut3, $atribut4, $atribut5, $atribut6, $year]);
            }
        }
        fclose($f);
    }

    function verifyIfDrogNameExist($name)
    {
        global $dbConnection;
        $query = $dbConnection->prepare("SELECT * FROM drugstable WHERE name = ?");
        $query->execute([$name]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result > 0) {
            return true;
        }
        return false;
    }

    function getIdDrog($name)
    {
        global $dbConnection;
        $query = $dbConnection->prepare("SELECT id FROM drugstable WHERE name = ?");
        $query->execute([$name]);

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['id'];
    }

    //apelez func
    addUrgenteMedicale(2022);
    addInfractionalitati(2022);
    addCapturiDroguri(2022);
    addCampanii(2022);

    //codul de mai jos este pentru a adauga un nou medicament in baza de date
    $max_id_query = $dbConnection->query("SELECT MAX(id) AS max_id FROM drugstable");
    $max_id_row = $max_id_query->fetch(PDO::FETCH_ASSOC);
    $new_drug_id = $max_id_row['max_id'] + 1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['name']) && !empty($_POST['type']) && !empty($_POST['image']) && !empty($_POST['description'])) {
            $types = implode(',', $_POST['type']);

            $insert_statement = $dbConnection->prepare("INSERT INTO drugstable (id, name, type, image, description) VALUES (?, ?, ?, ?, ?)");
            $insert_statement->execute(array($new_drug_id, $_POST['name'], $types, $_POST['image'], $_POST['description']));

            echo "<p>Medicamentul a fost adăugat cu succes!</p>";

            header("refresh:3;url=add_drugs.php");
            exit();
        } else {
            echo "Toate câmpurile sunt obligatorii.";
        }
    }
    ?>
