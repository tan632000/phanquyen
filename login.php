
<?php
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password = $password; // Mã hóa md5 mật khẩu
        $con = "SELECT users.email,users.id as user.id,users.name as user_name,GROUP_CONCAT(permissions.name) as permission_name,
            user_has_roles.user_id,roles.name as role_name,roles.id as role_id
            FROM users
            LEFT JOIN user_has_roles ON users.id = user_has_roles.user_id
            LEFT JOIN roles ON roles.id = user_has_roles.role_id
            LEFT JOIN role_has_permissions ON role_has_permissions.role_id = roles.id
            LEFT JOIN permissions ON role_has_permissions.permission_id = permissions.id
            WHERE email = '$email' AND password = '$password' GROUP BY roles.id";
        $query = mysqli_query($connect,$con);
        if(mysqli_num_rows($query) > 0){
            $permissions = '';
            while($row = mysqli_fetch_array($query)){
                $permissions .= $row['permission_name'];
                $_SESSION['auth_user'] = [
                    'id' => $row['user_id'],
                    'name' => $row['user_name'],
                    'email' => $row['email']
                ];
            }
            $_SESSION['auth_user']['permission_name'] = explode(',',$permissions);
            header('Location:' . 'index.php'); // return redirect về login
            exit();
        }
        else{
            header('Location:' . $_SERVER['HTTP_REFERER']); //return back
            exit;
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
<div class="container">
    <div class="row">
        <div id="formContent" style="max-width:350px; margin:0 auto;">
            <h1 style="font-size:25px;font-weight: 500;margin:30px 0 20px;text-align:center;">Đăng nhập hệ thong</h1>
            <form action="" method="post">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input class="form-control" type="email" id="login" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input id="password" class="form-control" type="password" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-sm btn-success" value="Đăng nhập">
                </div>
            </form>
        </div>
    </div>
</div>