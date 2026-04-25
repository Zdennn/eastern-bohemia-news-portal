<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Spectral:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <title>Kompas Východních Čech</title>
    
    <link rel="icon" type="image/x-icon" href="/assets/img/logo.png">

    <link rel="stylesheet" href="/assets/styly/main.css">
    <link rel="stylesheet" href="/assets/styly/loginRegister.css">

    <?= $this->controller->styl(); ?>

</head>

<body>

    <header>
        <a class="back" href="/"> <span class="material-symbols-outlined">arrow_back</span> Domů</a>
    </header>

    <?php $this->controller->zobraz(); ?>

</body>
<?= $this->controller->script(); ?>

</html>