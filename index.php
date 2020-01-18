<?php
    include_once 'includes/database.php';
    include_once 'includes/nav.php';
?>
<?php
    $auth_id = $_SESSION['auth_user']['id']; // lấy session về
    $sql = "SELECT GROUP_CONCAT(permissions.name) as permission_name,
        user_has_roles.user_id,
        roles.name as role_name,
        roles.id as role_id
    FROM user_has_roles
    LEFT JOIN roles ON roles.id = user_has_roles.role_id
    LEFT JOIN role_has_permissions ON role_has_permissions.role_id = roles.id
    LEFT JOIN permissions ON role_has_permissions.permission_id = permissions.id
    WHERE user_has_roles.user_id = '$auth_id' GROUP BY roles.id ";
    $query = mysqli_query($connect, $sql);
    $num_rows = mysqli_num_rows($query);
    $data = array();
    if ($num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $data[] = [
                'role_name' => $row['role_name'],
                'permissions' => explode(',',
                    $row['permission_name'])
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
<h1 style="font-size: 20px;">Xin chào <?= $_SESSION['auth_user']['name'] ?>!</h1><?php // hiển thị tên người dùng ?>
<div class="panel" style="box-shadow: none;">
    <h2> Bạn có thể thực hiện: </h2>
    <div class="box__role_permission col-md-12" style="padding-top:30px;">
        <?php if(count($data) > 0) { ?>
            <?php foreach ($data['role_name'] as $key => $item) { ?>
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <?= $key; ?>
                        </div>
                        <div class="panel-body">
                            <?php foreach ($item['permission_group'] as $item_pms) { ?>
                                <div class="col-md-3">
                                    <h4><?= $item_pms['type']; ?>:</h4>
                                    <ul>
                                        <?php foreach ($item_pms['permissions'] as $pe) { ?>
                                            <li>
                                                <?= $pe; ?>
                                            </li>
                                            <?php } ?>
                                    </ul>
                                </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                    <?php } else { ?>
                        <p> Bạn không có vai trò nào trong hệ thống </p>
                        <?php } ?>
    </div>