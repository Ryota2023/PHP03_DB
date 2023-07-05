<?php
/**
 * [ここでやりたいこと]
 * 1. クエリパラメータの確認 = GETで取得している内容を確認する
 * 2. select.phpのPHP<?php ?>の中身をコピー、貼り付け
 * 3. SQL部分にwhereを追加
 * 4. データ取得の箇所を修正。
 */

 $id = $_GET['id'];

 try {
    $db_name = 'gs_db'; //データベース名
    $db_id   = 'root'; //アカウント名
    $db_pw   = ''; //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

//３．データ登録SQL作成
$stmt = $pdo->prepare(
    'SELECT * FROM gs_bm_table WHERE id = :id');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行


$result = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    $result = $stmt->fetch();
    }


?>


<!DOCTYPE html>
<link rel="stylesheet" href="style.css">

<html lang="ja">
<div class="main1">
<?php


// ■■ryota>> 下記はすべてindex.phpから貼り付けました。

$filename = "name.txt"; // 名前を保存するファイルのパス

if (file_exists($filename) && is_readable($filename)) {
  $name_txt = trim(file_get_contents($filename));
} else {
  $name_txt = ""; // 名前の初期値を設定
}

// フォームが送信された場合、送信された名前を取得し、ファイルに保存
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // 名前が送信された場合
  if (isset($_POST["name"])) {
    $name_txt = $_POST["name"];

    // $email = $_POST["email"];
    // $content1 = $name_txt . " " . $email.  "\n"; // 名前とemailを1行で保存
    // $content1 = $name_txt;

    file_put_contents($filename, $name_txt);
  }



  // 曲名が送信された場合
  if (isset($_POST["song"])) {
    $song = $_POST["song"];
    $date = date("Y-m-d H:i:s"); // 現在の日付を取得
    $sleep = $_POST["sleep"];
    $condition = $_POST["condition"];
    $content2 = $date . " " . $song ." " . $sleep ." " .$condition .  "\n"; // 日付と曲名、睡眠時間、体調を1行で保存
    file_put_contents("dairy_song.txt", $content2, FILE_APPEND); // dairy_song.txtに追記
  }
}
    
// 名前が空の場合、名前の入力フォームを表示
if (empty($name_txt)) {
?>
  <title>名前の入力</title>
<!-- </head> -->
<body>
  <form method="post" action="<?php echo        htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    お名前: <input type="text" name="name">
    <input type="submit" value="送信">
  </form>

<?php } else { ?> 
  <div class="main_c">
    <h3>こんにちは、<?=$name_txt;?>さん！</h3>
       <p>今日も一日お疲れさまでした。</p>
       <p>今日はどんな音楽を聴きましたか？</p>
       <p>もしくはどんな曲を聴きたい気分ですか？</P>
       <p>1曲だけその曲名を教えて下さい！</p><br>
  </div>
</div>

<!-- ※form要素 input type="hidden" name="id" を１項目追加（非表示項目） -->
<!-- ※form要素 action="update.php"に変更 -->


<div class="main2">
<form method="POST" action="update.php">
    <div class="table">
        お名前：<input type="hidden" name="name" value="<?=$name_txt;?>" ><br>

        音楽のタイトル：<input type="text" name="music_title"
        value="<?= $result['music_title'] ?>"><br>

        アーティスト名：<input type="text" name="artist" value="<?= $result['artist'] ?>"><br>

        音楽のジャンル：<input type="text" name="music_mood" value="<?= $result['music_mood'] ?>"><br>

        睡眠時間: <input type="number" name="sleep_time" min="0" max="15" step="0.5" value="<?= $result['sleep_time'] ?>"><br>

        今日の体調 [1:悪い ～ 10:良い]:<input type="number" name="today_condition" min="1" max="10" step="1" value="<?= $result['today_condition'] ?>"><br>
        今日の感想：<textArea name="content" rows="3" cols="40"> <?= $result['content'] ?>
        </textArea><br>

        <input type="hidden" name="id" value="<?= $result['id'] ?>">

        <input type="submit" value="送信">
    </div>

    <p>過去に選んだ曲の記録を見てみる→  <a href="select.php">はい</a></p>
    <p>体調と睡眠時間の過去データを見てみる→  <a href="graph.php">はい</a></p>
  </form>
<?php
}
?>
</div>
</html>

