<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//2. $id = $_POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更


//1. POSTデータ取得
$name = $_POST['name'];
$content = $_POST['content'];
$sleep_time = $_POST['sleep_time'];
$today_condition = $_POST['today_condition'];
$music_title = $_POST['music_title'];
$artist = $_POST['artist'];
$music_mood = $_POST['music_mood'];
$id = $_POST['id'];

try {
    $db_name = 'gs_db'; //データベース名
    $db_id   = 'root'; //アカウント名
    $db_pw   = ''; //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

// ■■ryota>> 書いていくイメージ
// UPDATE テーブル名 SET カラム1 = 1に保存したいもの、カラム２ = 2に保存したいもの、、、WHERE 条件 id = 送られてきたid

$stmt = $pdo->prepare('UPDATE gs_bm_table 
                SET
                name = :name,
                content = :content,
                sleep_time = :sleep_time,
                today_condition = :today_condition,                            
                music_title = :music_title,
                artist = :artist,
                music_mood = :music_mood,
                date = sysdate()
            WHERE id = :id;');

// var_dump($stmt);
// exit();

$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':sleep_time', $sleep_time, PDO::PARAM_INT);
$stmt->bindValue(':today_condition', $today_condition, PDO::PARAM_INT);
$stmt->bindValue(':music_title', $music_title, PDO::PARAM_STR);
$stmt->bindValue(':artist', $artist, PDO::PARAM_STR);
$stmt->bindValue(':music_mood', $music_mood, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_INT);

$status = $stmt->execute(); //実行

// var_dump($status);
// exit();

if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    header('Location: select.php');
    exit(); //■■ryota>> とりあえず、チューターさんここにexitいれました
    }

// var_dump($result);



