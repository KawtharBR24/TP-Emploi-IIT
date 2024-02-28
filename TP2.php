<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du temps</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        td {
            background-color: #fff;
        }
        td:hover {
            background-color: #f2f2f2;
        }
        .delete-button {
            background-color: #ff0000;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }
        .delete-button:hover {
            background-color: #cc0000;
        }
        .add-button {
            background-color: #008000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }
        .add-button:hover {
            background-color: #006400;
        }
        .print-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #print-section, #print-section * {
                visibility: visible;
            }
            #print-section {
                position: absolute;
                left: 0;
                top: 0;
            }
            #supprimerbtn {
                visibility: hidden;
            }
        }
    </style>
</head>
<body>
<div class="container">
<?php
session_start();
if(isset($_GET['action']) && $_GET['action'] == "delmat" && isset($_GET['jour'], $_GET['heure'])){
    unset($_SESSION['tab_mat'][$_GET['jour']][$_GET['heure']]);
    header("location:TP2.php");
    exit();
}
if(isset($_GET['action']) && $_GET['action'] == "videremploi"){
    unset($_SESSION['tab_mat']);
    header("location:TP2.php");
    exit();
}

$tab_mat = $_SESSION['tab_mat'] ?? [];

if(isset($_POST["submit"])){
    $tab_mat[$_POST["jour"]][$_POST["heure"]] = $_POST["matiere"];
    $_SESSION['tab_mat'] = $tab_mat;
}

$heures = ['08-09','09-10','10-11','11-12','12-13','13-14','14-15','15-16','16-17'];
$jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi'];
?>

<form action="TP2.php" method="post">
    <label for="jour">Jour</label>
    <select name="jour" id="jour" required>
        <option value="">---Choisir le jour---</option>
        <?php foreach ($jours as $jour) { ?>
            <option value="<?= $jour ?>"><?= $jour ?></option>
        <?php } ?>
    </select>
    <label for="heure">Heure</label>
    <select name="heure" id="heure" required>
        <option value="">---Choisir l'heure---</option>
        <?php foreach ($heures as $heure) { ?>
            <option value="<?= $heure ?>"><?= $heure ?></option>
        <?php } ?>
    </select>
    <label for="matiere">Matière</label>
    <input type="text" name="matiere" required>
    <button type="submit" name="submit" class="add-button">Ajouter Emploi</button>
</form>
<button type="button" onclick="window.print()" class="print-button">Imprimer emploi</button>
<button type="button" onclick="window.location.href='TP2.php?action=videremploi'" class="add-button">Nouveau emploi</button>

<hr>

<div id="print-section">
    <h1>Emploi du temps</h1>
    <small><?= date("d/m/Y H:i:s") ?></small>
    <table border="1">
        <tr><td></td>
            <?php foreach($heures as $heure) { echo "<td>$heure</td>"; } ?>
        </tr>
        <?php foreach ($jours as $jour) { ?>
            <tr><td><?= $jour ?></td>
                <?php foreach($heures as $heure) { ?>
                    <td>
                        <?php if(isset($tab_mat[$jour][$heure])) { ?>
                            <?= $tab_mat[$jour][$heure] ?>
                            <a href='TP2.php?jour=<?= $jour ?>&heure=<?= $heure ?>&action=delmat'><button id="supprimerbtn" class="delete-button">X</button></a> <!-- Button to delete specific subject -->
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
        <?php } ?>
    </table>
</div>
</div>
</body>
</html>
