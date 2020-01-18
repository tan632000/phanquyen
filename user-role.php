<?php include 'includes/nav.php'; ?>
<?php
    $sql_roles = "SELECT * FROM roles";
    $query_roles = mysqli_query($connect, $sql_roles);
    $num_rows_roles = mysqli_num_rows($query_roles);
    $roles = array();
    if ($num_rows_roles > 0) {
        while ($row = mysqli_fetch_array($query_roles)) {
            $roles[] = [
                'id' => $row['id'],
                'name' => $row['name'],
            ];
        }
    }
?>
<?php
    if (isset($_POST['user_name'])) {
        $user_name = explode('+', $_POST['user_name']);
        $us_name = $user_name[0];
        $us_id = $user_name[1];
    }
    if (isset($_POST['change_role']) && $_POST['change_role'] == 1) {
        $us_id = $_POST['us_id'];
        $role_checked = $_POST['role'];
        $remove = mysqli_query($connect, "DELETE FROM user_has_roles WHERE user_id = '$us_id'");
        foreach($role_checked as $rl_checked) {
            mysqli_query($connect, "INSERT INTO user_has_roles(role_id, user_id) VALUE('{$rl_checked}', '{$us_id}')");
        }
        header('Location: '.' users.php');
    } else {
        if (isset($_POST['role_group'])) {
            $role_group = explode(',', $_POST['role_group']);
        } else {
            header('Location: '.' users.php'); // quay về trang users
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
<div class="panel" style="box-shadow: none;">
    <h2> Chọn vai trò </h2>
    <div style="padding:20px;border:1px solid #eee" class="col-md-12">
        <form action="user-role.php" method="post" class="col-md-12">
            <input type="hidden" name="change_role" value="1">
            <input type="hidden" name="us_id" value="<?= $us_id ?>">
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">Thành viên</div>
                    <div class="panel-body">
                        <ul style="padding: 10px 20px;">
                            <li style="line-height: 25px;">
                                <p>
                                    <?= $us_name; ?>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-info">
                    <div class="panel-heading">Vai trò</div>
                    <div class="panel-body">
                        <?php foreach ($roles as $item) { ?>
                            <div class="form-group">
                                <input name="role[]" <?php if(in_array($item[ 'id'], $role_group)) echo 'checked'; ?> value="
                                <?= $item['id']; ?>" type="checkbox">
                                    <?= $item['name'] ?>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <a class="btn btn-sm btn-default" href="users.php"> Hủy </a>
            <button class="btn btn-sm btn-warning"> Lưu </button>
        </form>
    </div>
</div> 