<?php
    include_once 'includes/database.php';
    include_once 'includes/nav.php';
?>

<?php
    if(isset($_POST['add-permission-groups'])){
        $name = $_POST['name'];
        $description = $_POST['description'];
        $sql_insert = "INSERT INTO permission_groups(name,description) VALUES ('{$name}','$description')";
        $query_insert = mysqli_query($connect,$sql_insert);
        if($query_insert){  // nếu lưu thành công
            header('Location:' . '?page=dang-nhap'); // trở về login
            exit;
        }else{ // nếu thất bại
            header('Location:' . $_SERVER['HTTP_REFERER']); //back
            exit;
        }
    }
    $sql = "SELECT * FROM permissions";
    $query = mysqli_query($connect, $sql);
    $num_rows = mysqli_num_rows($query);
    $permissions = array();
    if ($num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $permissions[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description']
            ];
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
<h2>Quyền</h2>
<div class="col-md-6">
    <h3>Thêm mới</h3>
    <div class="panel">
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" name="name" required class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea name="description" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="add-permission" value="1">
                <input type="submit" class="btn btn-sm btn-warning" value="Thêm mới">
            </div>
        </form>
    </div> 
</div>
<div class="col-md-6">
    <table class="table table-bordered" style="margin-top:60px;border:1px solid #eee">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Mô tả</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($permissions as $item){
            ?>
            <tr>
                <td><?= $item['id'];?></td>
                <td><?= $item['name'];?></td>
                <td><?= $item['description'];?></td>
            </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>