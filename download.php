<?php
include('config.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Arsip Dokumen Kuliah</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div id="container">
        <div id="header">
            <h1>Arsip Dokumen Kuliah</h1>
            <span>Info"</span>
        </div>

        <div id="menu">
            <a href="index.php">Home</a>
            <a href="upload.php">Upload Data</a>
            <a href="download.php" class="active">Data Kuliah</a>
        </div>

        <div id="content">
            <h2>Data Kuliah</h2>

            <label for="semester">Pilih Semester:</label>
            <select name="semester" id="semester" onchange="changeSemester(this.value)">
                <option value="all">Semua Semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
                <option value="7">Sertifikat Seminar</option>
                <!-- Tambahkan semester lainnya sesuai kebutuhan -->
            </select>

            <p>
                <table class="table" width="100%" cellpadding="3" cellspacing="0">
                    <tr>
                        <th width="30">No.</th>
                        <th width="80">Tgl. Upload</th>
                        <th>Nama File</th>
                        <th width="70">Tipe</th>
                        <th width="70">Ukuran</th>
                        <th>Mata Kuliah</th>
                    </tr>
                    <?php
                    $selected_semester = isset($_GET['semester']) ? $_GET['semester'] : 'all';

                    $condition = ($selected_semester !== 'all') ? "WHERE semester = $selected_semester" : "";

                    $sql = mysqli_query($conn, "SELECT * FROM download $condition ORDER BY id DESC");
                    if (mysqli_num_rows($sql) > 0) {
                        $no = 1;
                        while ($data = mysqli_fetch_assoc($sql)) {
                            echo '
                            <tr bgcolor="#fff">
                                <td align="center">' . $no . '</td>
                                <td align="center">' . $data['tanggal_upload'] . '</td>
                                <td>
                                    <span>' . $data['nama_file'] . '</span>
                                    <div>
                                        <a href="files/' . $data['nama_file'] . '.' . $data['tipe_file'] . '" download>
                                            <button>Download</button>
                                        </a>
                                        <button onclick="confirmDelete(' . $data['id'] . ')">Hapus</button>
                                    </div>
                                </td>
                                <td align="center">' . $data['tipe_file'] . '</td>
                                <td align="center">' . formatBytes($data['ukuran_file']) . '</td>
                                <td>' . $data['mata_kuliah'] . '</td>
                            </tr>
                            ';
                            $no++;
                        }
                    } else {
                        echo '
                        <tr bgcolor="#fff">
                            <td align="center" colspan="5" align="center">Tidak ada data!</td>
                        </tr>
                        ';
                    }
                    ?>
                </table>
            </p>
        </div>
    </div>
    <script>
        function changeSemester(semester) {
            window.location.href = 'download.php?semester=' + semester;
        }

        function confirmDelete(id) {
            var confirmation = confirm("Anda yakin ingin menghapus file?");
            if (confirmation) {
                window.location.href = 'hapus.php?id=' + id;
            }
        }
    </script>

</body>

</html>
