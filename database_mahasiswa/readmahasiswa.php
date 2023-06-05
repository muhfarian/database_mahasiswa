<?php
// readalldonasi.php
    include 'connection.php';

    $conn = getConnection();

    try {
        $statement = $conn->query("SELECT * FROM detail_mahasiswa;");
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $result = $statement->fetchAll();

        echo json_encode($result, JSON_PRETTY_PRINT);

    } catch (PDOException $e) {
        echo $e;
    }
?>