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
            <input type="checkbox" id="type1" name="type[]" value="Type1">
            <label for="type1">Type 1</label>
            <input type="checkbox" id="type2" name="type[]" value="Type2">
            <label for="type2">Type 2</label>
            <input type="checkbox" id="type3" name="type[]" value="Type3">
            <label for="type3">Type 3</label>
            <input type="checkbox" id="type4" name="type[]" value="Type4">
            <label for="type4">Type 4</label>
            <input type="checkbox" id="type5" name="type[]" value="Type5">
            <label for="type5">Type 5</label>
            <input type="checkbox" id="type6" name="type[]" value="Type6">
            <label for="type6">Type 6</label>
            <input type="checkbox" id="type7" name="type[]" value="Type7">
            <label for="type7">Type 7</label>
        </div>

        <label for="image"> Image:</label>
        <input type="text" id="image" name="image" required>
        <label for="description"> Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea>


        <button type="submit">Add</button>
    </form>
</div>
</body>
</html>