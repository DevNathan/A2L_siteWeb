<?PHP
session_start();
if($_SESSION['NomAdmin'] != ""){?>
    <html>
        <head>
          <title>A2L</title>
            <meta http-equiv="refresh" content="0.1;URL=https://a2l-jl.com/ficheAdmin.php">
    </head>
<?PHP } else if ($_SESSION['NomAdherent'] != "") {?>
    <html>
        <head>
            <meta http-equiv="refresh" content="0.1;URL=https://a2l-jl.com/ficheAdherent.php">
    </head>
<?PHP } else {
  echo $_SESSION['NomAdherent'];
    ?>
    <html>
        <head>
            <meta http-equiv="refresh" content="0.1;URL=https://a2l-jl.com/homePageAdherent.php">
    </head>
<?PHP 
}
?>