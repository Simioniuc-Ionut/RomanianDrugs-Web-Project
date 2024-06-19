    <?php

    require_once 'db_connect.php';
    global $dbConnection;

    echo "\n fisierul curent este : " . getcwd();
    // urgente-medicale
    function addUrgenteMedicale($year)
    {
        //strpos ,case sensitive (cauta un substring intr un string)
        //stripos ,nu este case sensitive
        global $dbConnection;

        $filename = "/fisiere_date/urgente_medicale_$year.csv";

        // Setez internal encoding pentru UTF-8
        mb_internal_encoding("UTF-8");

        // Deschid fisierul CSV pentru citire
        $f = fopen($filename, 'r');
        if ($f === false) {
            die('Eroare la deschiderea fisierului ' . $filename);
        }

        $insert_sex = $dbConnection->prepare("INSERT INTO urgente_tip_sex (sex, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_varsta = $dbConnection->prepare("INSERT INTO urgente_tip_varsta (varsta, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_cale = $dbConnection->prepare("INSERT INTO urgente_tip_cale (cale, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_model = $dbConnection->prepare("INSERT INTO urgente_tip_model (model, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");
        $insert_diagnostic = $dbConnection->prepare("INSERT INTO urgente_tip_diagnostic (diagnostic, canabis, stimulanti, opiacee, nsp, year) VALUES (?, ?, ?, ?, ?, ?)");

        $current_section = '';

        // Citesc fiecare rand din fisier
        while (($row = fgetcsv($f)) !== false) {
            // Convertim fiecare linie la UTF-8 dacă nu este deja
            $row = array_map(function($field) {
                return mb_convert_encoding($field, "UTF-8", "auto");
            }, $row);

            // Detectez sectiunile pe baza cuvintelor cheie din randuri
            if (stripos($row[0], 'sex') !== false) {
                $current_section = 'sex';
                continue;
            } elseif (stripos($row[0], 'vârstă') !== false) {
                $current_section = 'varsta';
                continue;
            } elseif (stripos($row[0], 'calea de administrare') !== false) {
                $current_section = 'cale';
                continue;
            } elseif (stripos($row[0], 'modelul de consum') !== false) {
                $current_section = 'model';
                continue;
            } elseif (stripos($row[0], 'diagnosticul de urgență') !== false) {
                $current_section = 'diagnostic';
                continue;
            }

            // Procesez datele in functie de sectiunea curenta
            switch ($current_section) {
                case 'sex':
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                        $sex = $row[0];
                        $canabis = (int) $row[1];
                        $stimulanti = (int) $row[2];
                        $opiacee = (int) $row[3];
                        $nsp = (int) $row[4];
                        $insert_sex->execute([$sex, $canabis, $stimulanti, $opiacee, $nsp, $year]);
                    }
                    break;

                case 'varsta':
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                        $varsta = $row[0];
                        $canabis = (int) $row[1];
                        $stimulanti = (int) $row[2];
                        $opiacee = (int) $row[3];
                        $nsp = (int) $row[4];
                        $insert_varsta->execute([$varsta, $canabis, $stimulanti, $opiacee, $nsp, $year]);
                    }
                    break;

                case 'cale':
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                        $cale = $row[0];
                        $canabis = (int) $row[1];
                        $stimulanti = (int) $row[2];
                        $opiacee = (int) $row[3];
                        $nsp = (int) $row[4];
                        $insert_cale->execute([$cale, $canabis, $stimulanti, $opiacee, $nsp, $year]);
                    }
                    break;

                case 'model':
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                        $model = $row[0];
                        $canabis = (int) $row[1];
                        $stimulanti = (int) $row[2];
                        $opiacee = (int) $row[3];
                        $nsp = (int) $row[4];
                        $insert_model->execute([$model, $canabis, $stimulanti, $opiacee, $nsp, $year]);
                    }
                    break;

                case 'diagnostic':
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                        $diagnostic = $row[0];
                        $canabis = (int) $row[1];
                        $stimulanti = (int) $row[2];
                        $opiacee = (int) $row[3];
                        $nsp = (int) $row[4];
                        $insert_diagnostic->execute([$diagnostic, $canabis, $stimulanti, $opiacee, $nsp, $year]);
                    }
                    break;
            }
        }

        fclose($f);
    }

    // infractionalitate
    function addInfractionalitati($year)
    {
        global $dbConnection;

        $filename = "/fisiere_date/capturi-droguri-$year.csv";

        // deschid fisierul CSV pentru citire
        $f = fopen($filename, 'r');
        if ($f === false) {
            die('Eroare la deschiderea fisierului ' . $filename);
        }

        // setez internal encoding pentru UTF-8
        mb_internal_encoding("UTF-8");

        $insert_statement1 = $dbConnection->prepare("INSERT INTO persoane_cercetate_judecata_condamnate (categorie, numar, year) VALUES (?, ?, ?)");
        $insert_statement2 = $dbConnection->prepare("INSERT INTO persoane_condamnate_incadrarea_juridica (incadrare_juridica, numar, year) VALUES (?, ?, ?)");
        $insert_statement3 = $dbConnection->prepare("INSERT INTO persoane_condamnate_sexe (sex, majore, minore, year) VALUES (?, ?, ?, ?)");
        $insert_statement4 = $dbConnection->prepare("INSERT INTO grupari_infractionale (categorie, numar, year) VALUES (?, ?, ?)");
        $insert_statement5 = $dbConnection->prepare("INSERT INTO pedepse_aplicate (tip_pedeapsa, lege_143_2000, lege_194_2011, year) VALUES (?, ?, ?, ?)");

        $current_section = '';

        // citesc fiecare rand din fisier
        while (($row = fgetcsv($f)) !== false) {
            // Convertim fiecare linie la UTF-8 dacă nu este deja
            $row = array_map(function($field) {
                return mb_convert_encoding($field, "UTF-8", "auto");
            }, $row);

            // detectez sectiunile pe baza continutului randurilor
            if (mb_strpos($row[0], 'PERSOANE CERCETATE') !== false) {
                $current_section = 'persoane_cercetate_judecata_condamnate';
                continue;
            } elseif (mb_strpos($row[0], 'PERSOANE CONDAMNATE') !== false && mb_strpos($row[0], 'PE SEXE') === false) {
                $current_section = 'persoane_condamnate_incadrarea_juridica';
                continue;
            } elseif (mb_strpos($row[0], 'PE SEXE') !== false) {
                $current_section = 'persoane_condamnate_sexe';
                continue;
            } elseif (mb_strpos($row[0], 'GRUPARILOR INFRACTIONALE') !== false) {
                $current_section = 'grupari_infractionale';
                continue;
            } elseif (mb_strpos($row[0], 'PEDEPSELOR APLICATE') !== false) {
                $current_section = 'pedepse_aplicate';
                continue;
            }

            // procesez datele in functie de sectiunea curenta
            switch ($current_section) {
                case 'persoane_cercetate_judecata_condamnate':
                    if (!empty($row[0]) && !empty($row[1])) {
                        $categorie = $row[0];
                        $numar = (int) $row[1];
                        $insert_statement1->execute([$categorie, $numar, $year]);
                    }
                    break;

                case 'persoane_condamnate_incadrarea_juridica':
                    if (!empty($row[0]) && !empty($row[1])) {
                        $incadrare_juridica = $row[0];
                        $numar = (int) $row[1];
                        $insert_statement2->execute([$incadrare_juridica, $numar, $year]);
                    }
                    break;

                case 'persoane_condamnate_sexe':
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                        $sex = $row[0];
                        $majore = (int) $row[1];
                        $minore = (int) $row[2];
                        $insert_statement3->execute([$sex, $majore, $minore, $year]);
                    }
                    break;

                case 'grupari_infractionale':
                    if (!empty($row[0]) && !empty($row[1])) {
                        $categorie = $row[0];
                        $numar = (int) $row[1];
                        $insert_statement4->execute([$categorie, $numar, $year]);
                    }
                    break;

                case 'pedepse_aplicate':
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                        $tip_pedeapsa = $row[0];
                        $lege_143_2000 = (int) $row[1];
                        $lege_194_2011 = (int) $row[2];
                        $insert_statement5->execute([$tip_pedeapsa, $lege_143_2000, $lege_194_2011, $year]);
                    }
                    break;
            }
        }

        fclose($f);
    }


    // campanii si prevenire
    function addCampanii($year)
    {
        global $dbConnection;
        $filename = "/fisiere_date/proiecte-si-campanii-$year.csv";
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

        $filename = "/fisiere_date/capturi-droguri-$year.csv";
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
   // addUrgenteMedicale(2022);
   // addInfractionalitati(2022);
   // addCapturiDroguri(2022);
   // addCampanii(2022);

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
