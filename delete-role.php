<?php include 'includes/nav.php'; ?>
<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = mysqli_query($connect, $sql);
        if ($query) {
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit;
        } else {
            header('Location: '.$_SERVER['HTTP_REFERER']); //return back
            exit;
        }
    }
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> // tạo title
    <title> Danh sách thành viên - Hệ Thống Quản Trị </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>