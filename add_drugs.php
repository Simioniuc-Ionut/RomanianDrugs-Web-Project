<?php
    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddDrug</title>
    <link rel="stylesheet" href="style2.css">
    <title>Delete Drug</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('RefactoringDataBase/index.php/get/drugs')
                .then(response => response.json())
                .then(data => {
                    console.log('Data fetched:', data);
                    const select = document.getElementById('drug_name');
                    data.forEach(drug => {
                        const option = document.createElement('option');
                        option.value = drug.name;
                        option.textContent = drug.name;
                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching drugs:', error);
                    console.log(error); // Afișează eroarea exactă
                });
        });
    </script>
    <script>
        document.getElementById('addDrugForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'RefactoringDataBase/index.php/add/drug', true);
            xhr.onload = function() {
                var messageDiv = document.getElementById('message');
                if (xhr.status >= 200 && xhr.status < 300) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        messageDiv.textContent = response.message;
                        messageDiv.style.backgroundColor = '#d4edda';
                        messageDiv.style.borderColor = '#c3e6cb';
                    } else if (response.error) {
                        messageDiv.textContent = response.error;
                        messageDiv.style.backgroundColor = '#f8d7da';
                        messageDiv.style.borderColor = '#f5c6cb';
                    }
                } else {
                    messageDiv.textContent = 'An error occurred.';
                    messageDiv.style.backgroundColor = '#f8d7da';
                    messageDiv.style.borderColor = '#f5c6cb';
                }
                messageDiv.style.display = 'block';
                setTimeout(function() {
                    messageDiv.style.display = 'none';
                }, 5000);
            };
            xhr.send(formData);
        });
    </script>
    <style>
        #message {
            position: fixed;
            bottom: 10px;
            right: 10px;
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px solid #ccc;
            display: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Add drug</h2>
    <form action="RefactoringDataBase/index.php/add/drug" method="post" novalidate>
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

        <label for="image">Image:</label>
        <input type="text" id="image" name="image" required>

        <label for="description">Description:</label>
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
    <form action="RefactoringDataBase/index.php/update/image" method="post" enctype="multipart/form-data" novalidate>
        <h3>Update Image</h3>
        <label for="image_name">Drug Name:</label>
        <input type="text" id="image_name" name="name" required>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

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
    <!-- Form to delete a drug -->
    <form action="RefactoringDataBase/index.php/delete/drug" method="post" novalidate>
        <h3>Delete Drug</h3>
        <label for="drug_name">Select Drug:</label>
        <select id="drug_name" name="name" required>
            <!-- Options will be populated by JavaScript -->
        </select>
        <button type="submit">Delete Drug</button>
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