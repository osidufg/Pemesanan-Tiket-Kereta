<?php
session_start();
$username = $password = "";
// Include config file
require_once "config.php";
// Check if user is admin
if($_SESSION["role"] != "admin"){
  header("location: home.php");
}
?>

<html>
<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>booking kereta</title>
        <link rel="stylesheet" href="style.css" />
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>

    <body>
        <!--Navigation bar-->
        <div id="nav-placeholder">

        </div>

        <script>
        $(function(){
            $("#nav-placeholder").load("navAdmin.html");
        });
        </script>
        <!--end of Navigation bar-->

        <h2>(ADMIN) Edit Daftar Tiket</h2>
        <?php
          $sql = "SELECT * FROM tb_tiket WHERE status_data = 'aktif'";
          if($result = $mysqli->query($sql)){
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // change row berangkat_waktu and tiba_waktu to date format
                    $row["berangkat_waktu"] = date("d M Y H:i", strtotime($row["berangkat_waktu"]));
                    $row["tiba_waktu"] = date("d M Y H:i", strtotime($row["tiba_waktu"]));
                    // change row harga to currency format
                    $row["harga"] = number_format($row["harga"], 0, ',', '.');
                    echo "<div class='daftarPesanan'>";
                    echo "<div class='block1'>";
                    echo "<div class='keretaPesanan'>" . $row["nama_kereta"] . "</div>";
                    echo "<div class='jenisKereta'>" . $row["jenis_kereta"] . "</div>";
                    echo "</div>";
                    echo "<div class='block2'>";
                    echo "<div class='jadwalPesanan'>" . $row["berangkat_lokasi"] . " >>> " . $row["tiba_lokasi"]."</div>";
                    echo "<div class='waktuPesanan'>" . $row["berangkat_waktu"] . " >>> " . $row["tiba_waktu"] . "</div>";
                    echo "</div>";
                    echo "<div class='block3'>";
                    echo "<div class='hargaPesanan'>" . "Rp " . $row["harga"] . "</div>";
                    
                    echo "<form action='pesan.php' class='buttonPesananEdit'>
                      <a href='updateTiket.php?tiket=$row[id_tiket]' id='idButtonPesanan' value='Pesan Sekarang'>Edit Tiket</a>
                      </form>";
                    echo "<form action='pesan.php' class='buttonPesananHapus'>
                      <a href='deleteTiket.php?tiket=$row[id_tiket]' id='idButtonPesanan' value='Pesan Sekarang'>Hapus Tiket</a>
                      </form>";

                    echo "</div>";
                    echo "</div>";
                }
              } else {
                echo "<div class='noresult'>" . "Tidak Ada Hasil." . "</div>";
              }
            // }
          }
        ?>
    </body>

</html>
