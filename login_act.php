<?php
//最初にSESSIONを開始！！
session_start();

//0.外部ファイル読み込み
include('functions.php');

//1.  DB接続&送信データの受け取り
$pdo = db_conn();

$lid = $_POST['lid'];
$lpw = $_POST['lpw'];


//2. データ登録SQL作成
$sql = 'SELECT * FROM user_table WHERE lid=:lid AND lpw=:lpw AND life_flg=0';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$res = $stmt->execute();

//3. SQL実行時にエラーがある場合
if ($res==false) {
    queryError($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();

//5. 該当レコードがあればSESSIONに値を代入
if ($val['id'] != '' && $val['kanri_flg'] == 1) {
    $_SESSION = array();
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    $_SESSION['name'] = $val['name'];

    header('Location: user_index.php');

} elseif($val['id'] != '') {
    $_SESSION = array();
    $_SESSION['chk_ssid'] = session_id();
    $_SESSION['kanri_flg'] = $val['kanri_flg'];
    $_SESSION['name'] = $val['name'];

    header('Location: index.php');
} else {
    $alert = "<script type='text/javascript'>alert('ログインID、またはパスワードが違います。');</script>";
    echo $alert;

    $login = "<script type='text/javascript'>location.href='login.php';</script>";
    echo $login;
}

exit();

?>
