<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */

//1. POSTデータ取得
$name = $_POST['name'];
$content = $_POST['content'];
$sleep_time = $_POST['sleep_time'];
$today_condition = $_POST['today_condition'];
$music_title = $_POST['music_title'];
$artist = $_POST['artist'];
$music_mood = $_POST['music_mood'];



//2. DB接続します(ryota>>■■gs_dbに接続という意味！●●●)
// DBへのユーザー名、PWは通常は'root,"なし"に設定されてるらしい
// ryota>>■■ try→catchはまだ覚えなくていいとのこと ■■

try {
  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意
// ■■ prepare（"●●●"）の中にSQLを入れる
// $stmt = $pdo->prepare(" 
//    INSERT INTO gs_bm_table
//      (id, name, email, content, date) VALUES
//       (NULL, :name, :email, :content, sysdate())");
 
      $stmt = $pdo->prepare(" 
      INSERT INTO gs_bm_table
      (id,date,name,content,sleep_time,today_condition,music_title,artist,music_mood)
      VALUES
      (NULL,sysdate(),:name,:content,:sleep_time,:today_condition,:music_title,:artist,:music_mood);
      ");

//  2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

// ■■■ここに指示を出す。↓3行このまま書き換えて！
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':sleep_time', $sleep_time, PDO::PARAM_INT);
$stmt->bindValue(':today_condition', $today_condition, PDO::PARAM_INT);
$stmt->bindValue(':music_title', $music_title, PDO::PARAM_STR);
$stmt->bindValue(':artist', $artist, PDO::PARAM_STR);
$stmt->bindValue(':music_mood', $music_mood, PDO::PARAM_STR);

//  3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．(登録が成功した場合の処理） index.phpへリダイレクト
  // ryota>>■■下のheader関数は単純に、index.phpに飛びますよ!という意味らしい。
// 　つまり結果的に、送信ボタンを押しても、そのままの画面のまま入力内容が消えるという意味でいいのかもしれない。
  header('Location: index.php');

}
?>
