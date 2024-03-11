<?php
$serverName = 'DESKTOP-D66BJBK\SQLEXPRESS';
//$username = 'DESKTOP-D66BJBK\José';
$database = 'formatosPrueba';
$username = 'sa';
$password = '26022022';
//$password = '';

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT HAS_PERMS_BY_NAME(DB_NAME(), 'DATABASE', 'BACKUP DATABASE') AS hasBackupPrivilege";
    $stmt = $conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['hasBackupPrivilege']) {
        echo "El usuario puede realizar backups.";
    } else {
        echo "El usuario no tiene los privilegios necesarios para realizar backups.";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

$conn = null;
?>
