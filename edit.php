<?php
require_once __DIR__ . "/connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $note_title = $_POST['note_title'];
    $note_desc = $_POST['note_desc'];

    $stmt = $conn->prepare("UPDATE " . DATABASE_NAME . ".notes SET
                        title = :title,
                        description = :description
                        WHERE id = :id");
    $stmt->bindParam(":title", $note_title, PDO::PARAM_STR);
    $stmt->bindParam(":description", $note_desc, PDO::PARAM_STR);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location:index.php");
    exit();
}
