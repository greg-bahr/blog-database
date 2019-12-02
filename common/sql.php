<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Blogs";

$conn = new PDO("mysql:dbname=".$dbname.";host=".$servername, $username, $password);

function getAllBlogs() {
    global $conn;
    $sql = "SELECT b.*, u.name as ownerName, u.email as ownerEmail FROM Blogs b JOIN Users u ON b.owner = u.username";

    return $conn->query($sql);
}

function getBlog($id) {
    global $conn;
    $query = $conn->prepare("SELECT b.*, u.name as ownerName, u.email as ownerEmail FROM Blogs b JOIN Users u ON b.owner = u.username WHERE b.id = :id");
    $query->bindParam(":id", $id);
    $query->execute();

    return $query->fetch();
}

function deleteBlog($id) {
    global $conn;
    $query = $conn->prepare("DELETE FROM Blogs WHERE id = :id");
    $query->bindParam(":id", $id);
    $query->execute();
}

function getPosts($blogId) {
    global $conn;
    $query = $conn->prepare("SELECT p.* FROM Posts p WHERE p.blogId = :blogId");
    $query->bindParam(":blogId", $blogId);
    $query->execute();
    return $query;
}

function getPost($id) {
    global $conn;
    $query = $conn->prepare("SELECT p.* FROM Posts p WHERE p.id = :id");
    $query->bindParam(":id", $id);
    $query->execute();
    return $query->fetch();
}

function getComments($postId) {
    global $conn;
    $query = $conn->prepare("SELECT c.* FROM Comments c WHERE c.postId = :postId");
    $query->bindParam(":postId", $postId);
    $query->execute();
    return $query;
}
