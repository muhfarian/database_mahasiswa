<?php
include 'connection.php';
// selectbyid.php
$conn = getConnection();

$nama_mahasiswa = $_GET["nama_mahasiswa"];

try {
    $statement = $conn->prepare("SELECT * FROM detail_mahasiswa WHERE nama_mahasiswa = :nama_mahasiswa;");
    $statement->bindParam(':nama_mahasiswa', $nama_mahasiswa);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_OBJ);
    $result = $statement->fetch();

    if($result){
        echo json_encode($result, JSON_PRETTY_PRINT);
    } else {
        http_response_code(404);
        $response["message"] = "Nama tidak ditemukan.";
        echo json_encode($response,JSON_PRETTY_PRINT);
    }

} catch (PDOException $e) {
    echo $e;
}