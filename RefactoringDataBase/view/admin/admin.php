<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: adminLogin.php');
    exit;
}

// Log out
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: adminLogin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Management</title>
    <link rel="stylesheet" href="../../../style2.css">
    <link rel="stylesheet" href="../../../style2_admin_button.scss">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('../../../RefactoringDataBase/index.php/get/drugsName')
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    const selects = document.querySelectorAll('select[name="name"], select[name="current_name"]');
                    selects.forEach(select => {
                        data.forEach(drug => {
                            const option = document.createElement('option');
                            option.value = drug.name;
                            option.textContent = drug.name;
                            select.appendChild(option);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching drugs:', error);
                });

            // Definează obiectele forms cu id-urile și URL-urile corespunzătoare
            const forms = [
                { id: 'addDrugForm', url: '../../index.php/add/drug' },
                { id: 'updateNameForm', url: '../../index.php/update/name' },
                { id: 'updateTypeForm', url: '../../index.php/update/type' },
                { id: 'updateImageForm', url: '../../index.php/update/image' },
                { id: 'updateDescriptionForm', url: '../../index.php/update/description' },
                { id: 'deleteDrugForm', url: '../../index.php/delete/drug' },
                { id: 'uploadFileForm', url: '../../index.php/upload' },
                { id: 'generateDataForm', url: '../../index.php/generateDataInJudete' },
                { id: 'generateCampaniiForm', url: '../../index.php/generateDataInCampanii' },
                { id: 'generateInfractionalitatiForm', url: '../../index.php/generateDataInInfractiuni'},
                {id: 'generateUrgenteMedicaleFrom', url: '../../index.php/generateDataInUrgenteMedicale'},
                {id: 'createAdminForm', url: 'createAdminAccount.php'}
            ];

            forms.forEach(form => {
                document.getElementById(form.id).addEventListener('submit', function(event) {
                    event.preventDefault();
                    const formData = new FormData(this);
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', form.url, true);
                    xhr.onload = function() {
                        const messageDiv = document.getElementById('message');
                        if (xhr.status >= 200 && xhr.status < 300) {
                            const response = JSON.parse(xhr.responseText);
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
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                        }, 5000);
                    };
                    console.info('Sending form data:', formData);
                    xhr.send(formData);
                });
            });
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
    <h1>Welcome to Admin Panel</h1>
    <hr> <!-- Bara orizontală -->
    <h2>Add Drug</h2>
    <div class="container">
        <form id="addDrugForm" novalidate>
            <label for="add_drug_name">Name:</label>
            <input type="text" id="add_drug_name" name="name" required>

            <label>Type:</label>
            <div id="add_drug_type">
                <input type="checkbox" id="add_type1" name="type[]" value="CNS Depressant">
                <label for="add_type1">CNS Depressant</label>
                <input type="checkbox" id="add_type2" name="type[]" value="CNS Stimulants">
                <label for="add_type2">CNS Stimulants</label>
                <input type="checkbox" id="add_type3" name="type[]" value="Hallucinogens">
                <label for="add_type3">Hallucinogens</label>
                <input type="checkbox" id="add_type4" name="type[]" value="Dissociative Anesthetics">
                <label for="add_type4">Dissociative Anesthetics</label>
                <input type="checkbox" id="add_type5" name="type[]" value="Narcotic Analgesics">
                <label for="add_type5">Narcotic Analgesics</label>
                <input type="checkbox" id="add_type6" name="type[]" value="Inhalants">
                <label for="add_type6">Inhalants</label>
                <input type="checkbox" id="add_type7" name="type[]" value="Cannabis">
                <label for="add_type7">Cannabis</label>
            </div>

            <label for="add_image">Image:</label>
            <input type="text" id="add_image" name="image" required>

            <label for="add_description">Description:</label>
            <textarea id="add_description" name="description" rows="4" required></textarea>

            <button type="submit">Add</button>
        </form>
    </div>
    <!-- Form to update description -->
    <hr> <!-- Bara orizontală -->
    <div class = "container">
        <form id="updateDescriptionForm" novalidate>
            <h2>Update Description</h2>
            <label for="desc_name">Drug Name:</label>
            <select id="desc_name" name="name" required>
                <!-- Options will be populated by JavaScript -->
            </select>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
            <button type="submit">Update Description</button>
        </form>
    </div>
    <!-- Form to update image -->
    <hr> <!-- Bara orizontală -->
    <div class = "container">
        <form id="updateImageForm" enctype="multipart/form-data" novalidate>
            <h2>Update Image</h2>
            <label for="image_name">Drug Name:</label>
            <select id="image_name" name="name" required>
                <!-- Options will be populated by JavaScript -->
            </select>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
            <button type="submit">Update Image</button>
        </form>
    </div>
    <!-- Form to update type based on name -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <form id="updateTypeForm" novalidate>
            <h2>Update Type</h2>
            <label for="name">Name:</label>
            <select id="name" name="name" required>
                <!-- Options will be populated by JavaScript -->
            </select>
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
    </div>
   <!-- Form to update name based on current name -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <form id="updateNameForm" novalidate>
            <h2>Update Name</h2>
            <label for="current_name">Current Name:</label>
            <select id="current_name" name="current_name" required>
                <!-- Options will be populated by JavaScript -->
            </select>
            <label for="new_name">New Name:</label>
            <input type="text" id="new_name" name="new_name" required>
            <button type="submit">Update Name</button>
        </form>
    </div>
    <!-- Form to delete a drug -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <form id="deleteDrugForm" novalidate>
            <h2>Delete Drug</h2>
            <label for="drug_name">Select Drug:</label>
            <select id="drug_name" name="name" required>
                <!-- Options will be populated by JavaScript -->
            </select>
            <button type="submit">Delete Drug</button>
        </form>
    </div>
    <!-- Form to upload csv file -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <h2>Upload CSV File</h2>
        <form id="uploadFileForm" enctype="multipart/form-data" novalidate>
            <label for="file">Upload CSV File:</label>
            <input type="file" id="file" name="file" required>
            <button type="submit">Upload</button>
        </form>
    </div>
    <!-- Formular pentru generarea datelor în județe -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <h2>Generate Data in Counties</h2>
        <form id="generateDataForm" novalidate enctype="multipart/form-data">
            <label for="select_year_counties">Select Year:</label>
            <input type="number" id="select_year_counties" name="year" min="2000" max="2100" required>
            <br><br>
            <label for="drug_name_counties">Select Drugs:</label>
            <select id="drug_name_counties" name="name" required>
                <!-- Options will be populated by JavaScript -->
            </select>
            <br><br>
            <button type="submit">Generate Data</button>
        </form>
    </div>

    <!-- Formular pentru generarea datelor în campanii -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <h2>Generate Data in Campanii</h2>
        <form id="generateCampaniiForm" method="post">
            <label for="year_campanii">Anul:</label>
            <input type="number" id="year_campanii" name="year" required>
            <button type="submit">Generate Data</button>
        </form>
    </div>
    <!-- Formular pentru generarea datelor in infractiuni -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <h2>Generate Data in Condamnari</h2>
        <form id="generateInfractionalitatiForm" method="post">
            <label for="year_infractiuni">Anul:</label>
            <input type="number" id="year_infractiuni" name="year" required>
            <button type="submit">Generate Data</button>
        </form>
    </div>

    <!-- Formular pentru generarea datelor in urgente medicale -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <h2>Generare Date Urgente Medicale</h2>
        <form id="generateUrgenteMedicaleFrom" method="post">
            <label for="year_urgente_medicale">Anul:</label>
            <input type="number" id="year_urgente_medicale" name="year" required>
            <button type="submit">Generate Data</button>
        </form>
    </div>
    <!-- Formular pentru crearea unui nou cont de admin -->
    <hr> <!-- Bara orizontală -->
    <div class="container">
        <form id="createAdminForm" method="post">
            <h2>Create New Admin Account</h2>
            <label for="new_username">Username:</label>
            <input type="text" id="new_username" name="new_username" required>
            <label for="new_password">Password:</label>
            <input type="password" id="new_password" name="new_password" required>
            <button type="submit">Create Account</button>
        </form>
    </div>
    <hr> <!-- Bara orizontală -->
</div>


<!-- Buton de Logout -->
<form action="" method="get">
    <button type="submit" name="logout" class="logout-button">Logout</button>
</form>

<!-- Button de back -->
<div id="message"></div>
<form action="../../view/homePage.php" method="get" id="backForm">
    <button type="submit" class="fixed-back-button">Back</button>
</form>

</body>
</html>
