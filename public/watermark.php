<?php
// スタンプと、それをすかしとして適用する写真を読み込みます
$stamp = imagecreatefromjpeg('http://localhost/image/a.jpg');
$im = imagecreatefromjpeg('http://localhost/image/c.jpg');

// スタンプの余白を設定し、スタンプ画像の幅と高さを取得します
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// スタンプ画像を写真の上にコピーします。余白の値と
// 写真の幅を元にスタンプの位置を決定します
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

// 出力し、メモリを開放します
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
