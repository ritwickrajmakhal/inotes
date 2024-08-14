<?php
require_once __DIR__ . "/connect.php";

$id = $_GET['id'];
$stmt = $conn->prepare('DELETE FROM ' . DATABASE_NAME . '.notes
                        WHERE id = :id');
$stmt->bindParam(":id", $id, PDO::PARAM_INT);
$stmt->execute();

header("Location:index.php");
exit();