<!DOCTYPE html>
<html lang="id">

<head>
    <title>Arsip Dokumen Kuliah</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div id="container">
        <div id="header">
            <h1>Arsip Dokumen Kuliah</h1>
            <span>@Arul</span>
        </div>

        <div id="menu">
            <a href="index.php">Home</a>
            <a href="upload.php" class="active">Upload Data</a>
            <a href="download.php">Data Kuliah</a>
        </div>

        <div id="content">
            <h2>Upload Data</h2>
            <p>Upload file Anda dengan melengkapi form di bawah ini. File yang bisa di Upload hanya file dengan ekstensi
                <b>.doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</b> dan besar file (file size) maksimal hanya
                15 MB.
            </p>

            <?php
            include('config.php');
            if (isset($_POST['upload'])) {
                $allowed_ext = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf', 'rar', 'zip');
                $file_name = $_FILES['file']['name'];
                $file_ext_array = explode('.', $file_name);
                $file_ext = strtolower(end($file_ext_array));
                $file_size = $_FILES['file']['size'];
                $file_tmp = $_FILES['file']['tmp_name'];
                $semester = $_POST['semester'];
                $mata_kuliah = $_POST['mata_kuliah'];

                $nama = $_POST['nama'];
                $tgl = date("Y-m-d");

                if (in_array($file_ext, $allowed_ext) === true) {
                    if ($file_size < 15728640) {
                        $lokasi_folder = __DIR__ . '/files/';
                        $lokasi = $lokasi_folder . $nama . '.' . $file_ext;

                        // Tambahkan kode berikut untuk memastikan bahwa direktori sudah ada
                        if (!is_dir($lokasi_folder)) {
                            mkdir($lokasi_folder, 0777, true);
                        }

                        move_uploaded_file($file_tmp, $lokasi);

                        $in = mysqli_query($conn, "INSERT INTO download VALUES(NULL, '$tgl', '$nama', '$file_ext', '$file_size', '$lokasi', '$semester', '$mata_kuliah')");
                        if ($in) {
                            echo '<div class="ok">SUCCESS: File berhasil di Upload!</div>';
                        } else {
                            echo '<div class="error">ERROR: Gagal upload file!</div>';
                        }
                    } else {
                        echo '<div class="error">ERROR: Besar ukuran file (file size) maksimal 5 Mb!</div>';
                    }
                } else {
                    echo '<div class="error">ERROR: Ekstensi file tidak di izinkan!</div>';
                }
            }
            ?>

            <p>
                <form action="" method="post" enctype="multipart/form-data">
                    <table width="100%" align="center" border="0" bgcolor="#eee" cellpadding="2" cellspacing="0">
                        <tr>
                            <td width="40%" align="right"><b>Nama File</b></td>
                            <td><b>:</b></td>
                            <td><input type="text" name="nama" size="40" required /></td>
                        </tr>
                        <tr>
                            <td width="40%" align="right"><b>Pilih File</b></td>
                            <td><b>:</b></td>
                            <td><input type="file" name="file" required /></td>
                        </tr>
                        <tr>
                            <td width="40%" align="right"><b>Semester</b></td>
                            <td><b>:</b></td>
                            <td>
                                <select name="semester">
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                    <option value="7">Sertifikat Seminar</option>
                                    <!-- Tambahkan semester lainnya sesuai kebutuhan -->
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="40%" align="right"><b>Mata Kuliah</b></td>
                            <td><b>:</b></td>
                            <td><input type="text" name="mata_kuliah" size="40" required /></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><input type="submit" name="upload" value="Upload" /></td>
                        </tr>
                    </table>
                </form>
            </p>
        </div>
    </div>

</body>

</html>
