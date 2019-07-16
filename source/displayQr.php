<?PHP
//
echo "entrée";
$data = $_GET['data'];
if($data == "" || $data == null){
    $path = 'images/unknown.png';
    $base64 = base64_encode(file_get_contents($path));
    echo $base64;
} else {
    $base64 = base64_encode(file_get_contents('https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $data . '&choe=UTF-8'));
    echo $base64;
}

?>