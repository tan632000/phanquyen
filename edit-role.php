<?php include 'includes/nav.php'; ?>
<?php
    // Lấy tất cả quyền đổ ra checkbox
    $sql_pms = "SELECT * FROM permissions";
    $query_pms = mysqli_query($connect, $sql_pms);
    $num_rows_pms = mysqli_num_rows($query_pms);
    $permissions = array();
    if ($num_rows_pms > 0) {
        while ($row_pms = mysqli_fetch_array($query_pms)) {
            $permissions[] = [
                'id' => $row_pms['id'], 'name' => $row_pms['name']
            ];
        }
    }
?>
<?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query_role = mysqli_query($connect, "SELECT * FROM roles LEFT JOIN role_has_permissions ON 
            roles.id = role_has_permissions.role_id WHERE roles.id = '$id' ");
                $role_data = array();
                while ($data = mysqli_fetch_array($query_role)) {
                    $role_data['name'] = $data['name'];
                    $role_data['description'] = $data['description'];
                    $role_data['permission'][] = $data['permission_id'];
                }
            }
?>
<?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $description = isset($_POST['description']) ?
        $_POST['description'] : null;
        $in_permissions = isset($_POST['permissions']) ?
        $_POST['permissions'] : [];
    
        $name = trim($name);
        $description = trim($description);
        // Kiểm tra Vai trò đã có hay chưa?
        if (mysqli_num_rows(mysqli_query($connect, "SELECT name FROM roles WHERE name = '$name' AND id < > '$id'")) > 0) 
        {
            header('Location: '.$_SERVER['HTTP_REFERER']); // return
            exit;
        }
        $role_id = false; // tạo biến role_id
        $sql = "UPDATE roles SET name = '{$name}', description ='{$description}', updated_at = '{$date}' WHERE id = '$id'";
        $update = mysqli_query($connect, $sql);
        if ($update) {
            $role_id = $id;
            if (count($in_permissions) > 0) {
                $remove = mysqli_query($connect, "DELETE FROM role_has_permissions WHERE role_id = '$role_id' ");
                foreach($in_permissions as $pms_id) {
                    $update_rl_has_pms = mysqli_query($connect, "INSERT INTO role_has_permissions(permission_id, role_id) 
                    VALUE('{$pms_id}', '{$role_id}') ");
                }
            }
            header('Location: '.$_SERVER['HTTP_REFERER']); exit;
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
<h2> Chỉnh sửa vai trò </h2>
<form method="post">
    <div class="col-md-12" style="margin-top:30px;">
        <div class="col-md-6" style="max-width:500px;border:1px solid #eee;padding:20px;">
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" value="<?= $role_data['name']; ?>" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea class="form-control" name="description" cols="30" rows="10">
                    <?= $role_data['description']; ?>
                </textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading"> Chọn quyền </div>
                    <div class="panel-body">
                        <?php foreach ($permissions as $group) { ?>
                            <div class="form-group">
                                <label>
                                    <input name="permissions[]" <?php if(in_array($group[ 'id'], $role_data[ 'permission']))
                                     echo "checked"; ?> type="checkbox" value="
                                    <?= $group['id'] ?>">
                                        <?= $group['name'] ?>
                                </label>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <input type="submit" class="btn btn-info" value="Cập nhật">
        <a class="btn btn-default" href="roles.php"> Hủy </a>
    </div>
</form>