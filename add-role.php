<?php include 'includes/nav.php'; ?>
<?php
     $sql_pms = "SELECT * FROM permissions";
     $query_pms = mysqli_query($connect, $sql_pms);
     $num_rows_pms = mysqli_num_rows($query_pms);
     $permissions = array();
     if ($num_rows_pms > 0) {
         while ($row_pms = mysqli_fetch_array($query_pms)) {
             $permission_groups = $row_pms['permission_group'];
             $permissions[$permission_groups][] = [
                 'id' => $row_pms['id'], 'name' => $row_pms['name']
             ];
         }
     }
?>
<?php 
    $role_id = false; // tạo biến role_id
    $sql = "INSERT INTO roles(name,description) VALUE ('{$name}', '{$description}')";
    $insert = mysqli_query($connect, $sql);
    if ($insert == true) {
        $role_id = mysqli_insert_id($connect);
        if (count($in_permissions) > 0 && $role_id != false) {
            foreach($in_permissions as $pms_id) {
                mysqli_query($connect, "INSERT INTO
                    role_has_permissions(permission_id, role_id) VALUE('{$pms_id}', '{$role_id}')");
                }
        }
        header('Location: '.' roles.php');
        exit;
    } else {
        header('Location: '.$_SERVER['HTTP_REFERER']); // return back
        exit;
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
<div class="row">
    <div class="col-md-6">
        <h2> Thêm mới vai trò </h2>
    </div>
    <div class="col-md-6">
        <h2> Chọn quyền cho vai trò </h2>
    </div>
</div>
<form method="post">
    <div class="col-md-12" style="margin-top:30px;">
        <div class="col-md-6" style="max-width:500px;border:1px solid #eee;padding:20px;">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" name="description" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"> Chọn quyền: </div>
                    <div class="panel-body"> 
                        <?php // vòng lặp lấy tất cả các quyền trong hệ thống ?> 
                        <?php foreach ($permissions as $group) { ?>
                            <div class="form-group">
                                <label>
                                    <input name="permissions[]" type="checkbox" value="<?= $group['id'] ?>">
                                    <?= $group['name'] ?>
                                </label>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn btn-info" value="Thêm mới">
            <a class="btn btn-default" href="roles.php"> Hủy </a>
        </div>
</form>