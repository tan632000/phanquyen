<?php include 'includes/nav.php'; ?>
<?php
    $sql = "SELECT * FROM roles";
    $query = mysqli_query($connect, $sql);
    $num_rows = mysqli_num_rows($query);
    $roles = array();
    if ($num_rows > 0) {
        while ($row = mysqli_fetch_array($query)) {
            $roles[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description']
            ];
        }
    }
?>
<head>

    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title> Danh sách thành viên - Hệ Thống Quản Trị </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

</head>
<h2> Quản lý vai trò </h2>
<a href="add-role.php" class="btn btn-sm btn-info"> Thêm mới vai trò</a>
<table class="table table-bordered" style="margin-top:60px;border:1px solid #eee">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th style="width:200px"></th>
        </tr>
    </thead>
    <tbody>
        <?php //sử dụng vòng lặp để lấy tất cả các vai trò trong hệ thống ?>
        <?php foreach ($roles as $item) { ?>
            <tr>
                <td>
                    <?= $item['id']; ?>
                </td>
                <td>
                    <?= $item['name']; ?>
                </td>
                <td>
                    <?= $item['description']; ?>
                </td>
                <td style="width:200px;text-align:center">
                    <a href="edit-role.php?id=<?= $item['id']; ?>" class="btn btn-success btn-sm"> Sửa vai trò </a>
                    <a onclick="return confirm('Bạn có chắc xóa không?')" href="delete-role.php?id=<?= $item['id']; ?>" 
                    class="btn btn-warning btn-sm"> Xóa vai trò </a>
                </td>
            </tr>
            <?php } ?>
    </tbody>
</table>
</div>
}