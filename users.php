<?php include 'includes/nav.php'; ?>
<?php
    $sql = "SELECT GROUP_CONCAT(roles.name) as name,
    GROUP_CONCAT(roles.id) as role_id, users.id AS user_id, email, users.NAME AS user_name
    FROM users
    LEFT JOIN user_has_roles ON users.id = user_has_roles.user_id
    LEFT JOIN roles ON roles.id = user_has_roles.role_id GROUP BY users.id ";
    $query = mysqli_query($connect, $sql);
    $num_rows = mysqli_num_rows($query); // đếm số bản ghi
    $list_user = array(); // tạo mảng chứa dữ liệu trả về
    if ($num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $list_user[] = [
                'id' => $row['user_id'],
                'name' => $row['user_name'],
                'email' => $row['email'],
                'role_id' => $row['role_id'],
                'role_name' => ($row['name']) ? $row['name'] : 'Chưa có vai trò '
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
<div class="panel" style="box-shadow: none;">
    <h2> Quản lý thành viên </h2>
    <a class="btn btn-sm btn-primary" href="add-user.php"> Thêm thành viên </a>
    <table class="table table-bordered" style="margin-top: 60px;border:1px solid #eee; width: 800px">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th style="width:50px">Chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list_user as $item) { ?>
                <tr class="item__user" data-name="<?= $item['name']; ?>">
                    <td>
                        <?= $item['id']; ?>
                    </td>
                    <td>
                        <?= $item['name']; ?>
                    </td>
                    <td>
                        <?= $item['email']; ?>
                    </td>
                    <td>
                        <?= $item['role_name']; ?>
                    </td>
                    <td style="text-align:center">
                        <form action="user-role.php" method="post">
                            <input type="hidden" name="role_group" value="<?= $item['role_id']; ?>">
                            <input type="hidden" name="user_name" value="<?= $item['name'].'+'.$item['id']; ?>">
                            <button class="btn btn-sm btninfo"> Chọn vai trò </button>
                        </form>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>