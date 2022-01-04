<?php
    require 'vendor/autoload.php';

    $input = filter_input(1,"jadwal_id");
    if($input != null){
        $client = new MongoDB\Client(
            'mongodb+srv://Vincent:Tu70r14l@cluster0.zfifs.mongodb.net/fatsdb?retryWrites=true&w=majority');

        $collection_kehadiran = $client->fatsdb->kehadiran;
        $result_kehadiran = $collection_kehadiran->find( [ 'jadwal._id' => new MongoDB\BSON\ObjectId("$input") ] )->toArray();

        $collection_jadwal = $client->fatsdb->jadwal;
        $result_jadwal = $collection_jadwal->find( [ '_id' => new MongoDB\BSON\ObjectId("$input") ] )->toArray();
        
        $jadwal = $result_jadwal[0];

        // var_dump(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($result_jadwal)));
        ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Print Form</title>
        <link href="index.css" rel="stylesheet">
    </head>
    <body>
        <h2 class="layout">DAFTAR HADIR MAHASISWA UNIVERSITAS KRISTEN MARANATHA</h1>
        <div class="details layout">
            <div class="rodesc">
                <div class="desc left"><?php echo "<div class='nama'>Program Studi</div><div class='titikdua'>:</div><div class='info'>".$jadwal['program_studi']."</div>" ?></div>
                <div class="desc right"><?php echo "<div class='nama'>Mata Kuliah</div><div class='titikdua'>:</div><div class='info'>".$jadwal['mata_kuliah']."</div>" ?></div>
            </div>
            <div class="rodesc">
                <div class="desc left"><?php echo "<div class='nama'>Kelas</div><div class='titikdua'>:</div><div class='info'>".$jadwal['kelas']."</div>" ?></div>
                <div class="desc right"><?php echo "<div class='nama'>Semester</div><div class='titikdua'>:</div><div class='info'>".$jadwal['semester']."</div>" ?></div>
            </div>
            <div class="rodesc">
                <div class="desc left"><?php echo "<div class='nama'>Kode MK</div><div class='titikdua'>:</div><div class='info'>".$jadwal['kode_mk']."</div>" ?></div>
                <div class="desc right"><?php echo "<div class='nama'>Ruangan</div><div class='titikdua'>:</div><div class='info'>".$jadwal['ruang']."</div>" ?></div>
            </div>
            <div class="rodesc">
                <div class="desc left"><?php echo "<div class='nama'>Waktu</div><div class='titikdua'>:</div><div class='info'>".$jadwal['waktu']."</div>" ?></div>
                <div class="desc right"><?php echo "<div class='nama'>Dosen</div><div class='titikdua'>:</div><div class='info'>".$jadwal['dosen']['nama']."</div>" ?></div>
            </div>
        </div>
        <table>
            <tr>
                <th>No.</th>
                <th>Nama Lengkap</th>
                <?php
                    for ($i=0; $i < count($result_kehadiran); $i++) { 
                        echo "<th style='width:85px;'>".$result_kehadiran[$i]["date"]."</th>";
                    }
                    
                    for ($i=count($result_kehadiran)+1; $i <= 12; $i++) { 
                        // echo "<th>".$result_kehadiran[0]["date"]."</th>";
                        echo "<th style='width:85px;'>$i</th>";
                    }
                ?>
            </tr>
            <tr>
                <?php
                            // $mahasiswas = $result_kehadiran[$i]["jadwal"]["mahasiswas"];
                        // for ($i=0; $i < count($result_kehadiran); $i++) { 
                        //     array_push($mahasiswas,);
                        //     var_dump(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($mahasiswas)));
                        // }
                        // var_dump(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($mahasiswas)));
                            // for ($i=1; $i <= 12; $i++) {
                        $index=0; 
                        foreach($result_jadwal[0]["mahasiswas"] as $peserta_jadwal){
                            $index++;
                            echo "<tr>";
                            echo "<td>$index</td>";
                            echo "<td style='width:211px;'>".$peserta_jadwal["nama"]."</td>";
                            for ($i=0; $i < count($result_kehadiran); $i++) { 
                                $mahasiswas = $result_kehadiran[$i]["jadwal"]["mahasiswas"];
                                echo "<td>";
                                $sho="H";
                                if($mahasiswas[$index-1]["logged"]==false){
                                    $sho="A";
                                }
                                echo $sho;
                                echo "</td>";
                            }
                            for ($j=count($result_kehadiran)+1; $j <= 12; $j++) { 
                                echo "<td>";
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                        for ($j=count($result_jadwal[0]["mahasiswas"]); $j < 25; $j++) { 
                            $index++;
                            echo "<tr>";
                            echo "<td>$index</td>";
                            for ($k=0; $k <= 12; $k++) { 
                                echo "<td>";
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                    }
                ?>
            </tr>
        </table>
    </body>
    <!-- <script src="index.js"></script> -->
</html>