<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>MyFitnessPal Konverter für Nährwertexport-Datei</title>
</head>
<body>

<h1>MyFitnessPal Konverter für Nährwertexport-Datei</h1>

<p>Bitte lade nur die Datei mit dem Namen „Nährwerte-Übersicht-….csv“ hoch. Andere Dateien werden nicht unterstützt.</p>

<form action="convert.php" method="post" enctype="multipart/form-data">

    <p><input type="file" name="uploadFile" id="uploadFile"></p>

    <p><input type="submit" id="submit"></p>
</form>
</body>
</html>