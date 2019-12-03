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

function getComments($postId) {
    global $conn;
    $query = $conn->prepare("SELECT c.* FROM Comments c WHERE c.postId = :postId");
    $query->bindParam(":postId", $postId);
    $query->execute();
    return $query;
}

function getPosts($blogId) {
    global $conn;
    $query = $conn->prepare("SELECT p.*, u.name as authorName FROM Posts p JOIN Users u ON u.username = p.author WHERE blogId = :blogId");
    $query->bindParam(":blogId", $blogId);
    $query->execute();
    return $query;
}

function getPost($postId) {
    global $conn;
    $query = $conn->prepare("SELECT p.*, u.name as authorName FROM Posts p JOIN Users u ON u.username = p.author WHERE id = :postId");
    $query->bindParam(":postId", $postId);

    $query->execute();
    return $query->fetch();
}

function createPost($blogId, $post) {
    global $conn;
    $query = $conn->prepare("INSERT INTO Posts(blogId, title, content, author) VALUES (:blogId, :title, :content, :author)");
    $query->bindParam(":blogId", $blogId);
    $query->bindParam(":title", $post["title"]);
    $query->bindParam(":content", $post["content"]);
    $query->bindParam(":author", $post["author"]);

    $query->execute();
    return $conn->lastInsertId();
}

function updatePost($postId, $post) {
    global $conn;
    $query = $conn->prepare("UPDATE Posts SET title = :title, content = :content, author = :author WHERE id = :postId");
    $query->bindParam(":postId", $postId);
    $query->bindParam(":title", $post["title"]);
    $query->bindParam(":content", $post["content"]);
    $query->bindParam(":author", $post["author"]);

    $query->execute();
}

function deletePost($postId) {
    global $conn;
    $query = $conn->prepare("DELETE FROM Posts WHERE id = :postId");
    $query->bindParam(":postId", $postId);

    $query->execute();
}
