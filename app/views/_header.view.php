<?php
    if (isset($bodyClass) === false) { $bodyClass = ""; }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="The Grub Hub">
        <meta name="author" content="Sam Butler">
        <meta name="keywords" content="recipe,food,sam butler">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <meta name="apple-touch-icon" href="/img/apple-touch-icon.png" />
        <meta name="apple-touch-startup-image" href="/img/apple-touch-startup.png" />
        
        <link href="/css/font-awesome.css" rel="stylesheet">
        <link href="/css/bootstrap_journal.css" rel="stylesheet">
        <link href="/css/fullcalendar.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet">
        <link rel="icon" type="image/ico" href="/img/favicon.ico">
        
        <title>The Grub Hub</title>
    </head>
    <body class=<?php echo "'" . $bodyClass . "'"; ?>>
