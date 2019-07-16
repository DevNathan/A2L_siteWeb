<?PHP
header("Content-type: image/png");
$id = $_GET['id'];
$post = array(
    'idAdherent' => $id,
);
$data = http_build_query($post);
$content = file_get_contents(
    'https://a2l-jl.com/api/loadImage.php',
    FALSE,
    stream_context_create(
    array(
        'http' => array(
            'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($data) . "\r\n",
                'content' => $data,
            )
        )
    )
);
$imageData = json_decode($content);

if($imageData == "none" || base64_decode($imageData) == null){
    $path = 'images/avatar.png';
    $data = file_get_contents($path);
    echo $data;
} else {
    echo base64_decode($imageData);
}

?>