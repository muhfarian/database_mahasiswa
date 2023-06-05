
<?php
// insertmahasiswa.php
include 'connection.php';

// INSERT INTO `detail_mahasiswa`(`nim`, `nama_mahasiswa`, `jenis_kelamin`, `agama`, `tempat_lahir`, `tanggal_lahir`, `jurusan`, `angkatan`, `semester`, `motto_hidup`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]')
// prepare > bind > execute

$conn = getConnection();

try {
    if($_POST){
        $nim = $_POST["nim"];
        $nama_mahasiswa = $_POST["nama_mahasiswa"];
        $jenis_kelamin = $_POST["jenis_kelamin"];
        $agama = $_POST["agama"];
        $tempat_lahir = $_POST["tempat_lahir"];
        $tanggal_lahir = $_POST["tanggal_lahir"];
        $jurusan = $_POST["jurusan"];
        $angkatan = $_POST["angkatan"];
        $semester = $_POST["semester"];

        if(isset($_FILES["keterangan"]["name"])){
            $image_name = $_FILES["keterangan"]["name"];
            $extensions = ["jpg", "png", "jpeg"];
            $extension = pathinfo($image_name, PATHINFO_EXTENSION);
            
            if (in_array($extension, $extensions)){
                $upload_path = 'upload/' . $image_name;

                if(move_uploaded_file($_FILES["keterangan"]["tmp_name"], $upload_path)){

                    $keterangan = "http://localhost/database_mahasiswa/" . $upload_path; 

                    $statement = $conn->prepare("INSERT INTO `detail_mahasiswa`(`nim`, `nama_mahasiswa`, `jenis_kelamin`, `agama`, `tempat_lahir`, `tanggal_lahir`, `jurusan`, `angkatan`, `semester`, `keterangan`) VALUES (:nim,:nama_mahasiswa,:jenis_kelamin,:agama,:tempat_lahir,:tanggal_lahir,:jurusan,:angkatan,:semester,:keterangan);");

                    $statement->bindParam(':nim',$nim);
                    $statement->bindParam(':nama_mahasiswa', $nama_mahasiswa);
                    $statement->bindParam(':jenis_kelamin',$jenis_kelamin);
                    $statement->bindParam(':agama',$agama);
                    $statement->bindParam(':tempat_lahir',$tempat_lahir);
                    $statement->bindParam(':tanggal_lahir',$tanggal_lahir);
                    $statement->bindParam(':jurusan',$jurusan);
                    $statement->bindParam(':angkatan',$angkatan);
                    $statement->bindParam(':semester',$semester);
                    $statement->bindParam(':keterangan',$keterangan);
            
                    $statement->execute();
        
                    $response["message"] = "Data berhasil direcord";
                    
                } else {
                    echo "gagal memindahkan file";
                }
            } else {
                $response["message"] = "Hanya diperbolehkan menginput keterangan gambar!";
            }
        } else {
            $statement = $conn->prepare("INSERT INTO `detail_mahasiswa`(`nim`, `nama_mahasiswa`, `jenis_kelamin`, `agama`, `tempat_lahir`, `tanggal_lahir`, `jurusan`, `angkatan`, `semester`, `keterangan`) VALUES (:nim,:nama_mahasiswa,:jenis_kelamin,:agama,:tempat_lahir,:tanggal_lahir,:jurusan,:angkatan,:semester,:keterangan);");

            $statement->bindParam(':nim',$nim);
            $statement->bindParam(':nama_mahasiswa', $nama_mahasiswa);
            $statement->bindParam(':jenis_kelamin',$jenis_kelamin);
            $statement->bindParam(':agama',$agama);
            $statement->bindParam(':tempat_lahir',$tempat_lahir);
            $statement->bindParam(':tanggal_lahir',$tanggal_lahir);
            $statement->bindParam(':jurusan',$jurusan);
            $statement->bindParam(':angkatan',$angkatan);
            $statement->bindParam(':semester',$semester);
            $statement->bindParam(':keterangan',$keterangan);
    
            $statement->execute();

            $response["message"] = "Data berhasil direcord";
        }
    }

}
catch (PDOException $e){
        $response["message"] = "Error: " . $e->getMessage();
} echo json_encode($response, JSON_PRETTY_PRINT);