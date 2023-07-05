
<?php
//1.  DB接続します
// （■■ryota>> DBに接続してデータを抽出しないといけないので）



try {
  $db_name = 'gs_db';    //データベース名
  $db_id   = 'root';      //アカウント名
  $db_pw   = '';      //パスワード：MAMPは'root'
  $db_host = 'localhost'; //DBホスト
  $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
  exit('DB Connection Error:' . $e->getMessage());
}


//２．データ取得SQL作成
// （■■ryota>> prepareでDBからデータを抜き出して、executeで実行する）
// （■■ryota>> 下の1行で、「gs_an_table」のデータすべて抽出してくれる）

// $stmt = $pdo->prepare("************* *****");
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute(); 

// テスト用（ちゃんとデータを取得しているか）
// var_dump($status);
// echo "<pre>";
// echo($status);
// echo "</pre>";
// exit();

?>
 <!-- ３．データ表示 -->

<header>
<div class="header">
<h2>***　過去記録　***</h2>
<a href="index.php"><h3>戻る</h3></a>
</header>
<div class="field">　　（日付）　　　（名前 ）　　　（睡眠時間）　　　　（体調）　　　　　（音楽タイトル）　　（アーティスト）　（ジャンル） 　　（１日の感想）</div>
</header>

<?php
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);



}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php

  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // $view .= "**********";
    //ryota>>■■.=の.は上書きされないようにするために付けているらしい

    $view .= "<p>";  

    // 下はformより誰でもデータを送信できるが、その中にタグなどでコードがまぎれていると、動作してしまうことがあり、それをふせぐためにhtmlspecialchrars関数を使うらしい。
    $view .= $result['id']  . '　 ';
    $view .= '<a href="detail.php?id=' .$result['id'] . '">';
    $view .= $result['date'];
    $view .= '</a>';

    $view .= '<a href="delete.php?id=' .$result['id'] . '">';
    $view .= '[削除]';
    $view .= '</a>';

    $view .= 
    $result['name']  . '　  (睡眠時間) '.
    $result['sleep_time']  . 'h　  (体調10段階) '.
    $result['today_condition']  . '　　'.
    $result['music_title']  . '　　'.
    $result['artist']  . '　　'.
    $result['music_mood']  . '　　'.
    $result['content'] ;
    
    // $result['date']  . ' : '. $result['name'] . " → " . $result['content']; //$resultの中身を追記する
    // $view .= htmlspecialchars($result['date'], ENT-QUOTES) . ' : ' . $result['name']; 
    // $view .= h($result['date'], ENT-QUOTES) . ' : ' . h($result['name']); 
    // $view .= "";
  }
}
?>

<!-- ■■ryota>> この1行のコードで全保存データを表示しているみたいだ！ -->

<div><?php echo $view; ?></div>

<!--  html  -->

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>過去記録</title>
<link rel="stylesheet" href="style1.css">
</head>
</html>
