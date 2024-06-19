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

    <!-- Form to update description -->
    <form action="RefactoringDataBase/index.php/update/description" method="post" novalidate>
        <h3>Update Description</h3>
        <label for="desc_name">Drug Name:</label>
        <input type="text" id="desc_name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Update Description</button>
    </form>
    <!-- Form to update image -->
    <form action="RefactoringDataBase/index.php/update/image" method="post" novalidate>
        <h3>Update Image</h3>
        <label for="image_name">Drug Name:</label>
        <input type="text" id="image_name" name="name" required>

        <label for="image">Image URL:</label>
        <input type="text" id="image" name="image" required>

        <button type="submit">Update Image</button>
    </form>
    <!-- Form to update type based on name -->
    <form action="RefactoringDataBase/index.php/update/type" method="post" novalidate>
        <h3>Update Type</h3>
        <label for="name">Name:</label>
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

        <button type="submit">Update Type</button>
    </form>
    <!-- Form to update name based on current name -->
    <form action="RefactoringDataBase/index.php/update/name" method="post" novalidate>
        <h3>Update Name</h3>
        <label for="current_name">Current Name:</label>
        <input type="text" id="current_name" name="current_name" required>

        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name" required>

        <button type="submit">Update Name</button>
    </form>


    <!-- Form to upload csv file -->
    <h2>Upload CSV File</h2>
    <form action="RefactoringDataBase/index.php/upload" method="POST"  enctype="multipart/form-data" novalidate>
        <label for="file">Upload CSV File:</label>
        <input type="file" id="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
</div>
</body>
</html>