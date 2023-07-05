<!DOCTYPE html>
<link rel="stylesheet" href="style.css">

<html lang="ja">
<div class="main1">
<?php

// index.phpにアクセスしたときに、既に名前が登録されていれば、曲名入力の画面へ、始めてであれば名前の入力画面へ飛ぶようにしました。name.txtを読みに行くことでその判断をするようにしました。
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
<div class="main2">
<form method="POST" action="insert.php">
    <div class="table">
        <input type="hidden" name="name" value="<?=$name_txt;?>" ><br>
        音楽のタイトル：<input type="text" name="music_title"><br>
        アーティスト名：<input type="text" name="artist"><br>
        音楽のジャンル：<input type="text" name="music_mood"><br>
        睡眠時間: <input type="number" name="sleep_time" min="0" max="15" step="0.5"><br>
        今日の体調 [1:悪い ～ 10:良い]:<input type="number" name="today_condition" min="1" max="10" step="1"><br>
        今日の感想：<textArea name="content" rows="3" cols="40">
</textArea><br>
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

