<?php
    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddDrug</title>
    <link rel="stylesheet" href="style2.css">

</head>
<body>
<div class="container">
    <h2>Add drug</h2>
    <form action="add_drugs_process.php" method="post" novalidate>
        <label for="name"> Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="type">Type:</label>
        <div id="type">
            <input type="checkbox" id="type1" name="type[]" value="CNS Depressant">
            <label for="type1">CNS Depressant</label>
            <input type="checkbox" id="type2" name="type[]" value="CNS Stimulants">
            <label for="type2">CNS Stimulants</label>
            <input type="checkbox" id="type3" name="type[]" value="Hallucinogens">
            <label for="type3">Hallucinogens</label>
            <input type="checkbox" id="type4" name="type[]" value="Dissociative Anesthetics">
            <label for="type4">Dissociative Anesthetics</label>
            <input type="checkbox" id="type5" name="type[]" value="Narcotic Analgesics">
            <label for="type5">Narcotic Analgesics</label>
            <input type="checkbox" id="type6" name="type[]" value="Inhalants">
            <label for="type6">Inhalants</label>
            <input type="checkbox" id="type7" name="type[]" value="Cannabis">
            <label for="type7">Cannabis</label>
        </div>

        <label for="image"> Image:</label>
        <input type="text" id="image" name="image" required>
        <label for="description"> Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>


        <button type="submit">Add</button>

    </form>
    <h2>Upload CSV File</h2>
    <form action="upload_csv.php" method="post" enctype="multipart/form-data" novalidate>
        <label for="file">Upload CSV File:</label>
        <input type="file" id="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</div>
</body>
</html>