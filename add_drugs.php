<?php
    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddDrug</title>
    <link rel="stylesheet" href="styleAdd.css">

</head>
<body>
<div class="container">
    <h2>Add drug</h2>
    <form action="add_drugs_process.php" method="post" novalidate>
        <label for="name"> Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="type"> Type:</label>
        <input type="text" id="type" name="type" required>
        <label for="image"> Image:</label>
        <input type="text" id="image" name="image" required>
        <label for="description"> Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Add</button>
    </form>
</div>
</body>
</html>