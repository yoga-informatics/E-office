<?php
include 'koneksi.php';

if (isset($_POST['id_sm'])) {
    $id_sm = $_POST['id_sm'];
    
    $query = "SELECT kode_surat, nomor_surat, tgl_sm, pengirim FROM tb_sm WHERE id_sm = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_sm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    }
    
    $stmt->close();
}
?>
