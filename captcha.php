<?php
session_start();
$captcha=substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"),0,6); // string yg akan diacak membentuk captcha 0-z dan sebanyak 6 karakter
$_SESSION['captcha']=$captcha;

$gambar=ImageCreate(100,30); // ukuran kotak width=60 dan height=20
$wk=ImageColorAllocate($gambar, 72,75,68); // membuat warna kotak -> Navajo White
$wt=ImageColorAllocate($gambar, 255, 255, 255); // membuat warna tulisan -> Putih
ImageFilledRectangle($gambar, 0, 0, 50, 20, $wk);
ImageString($gambar, 10, 3, 3, $captcha, $wt);
ImageJPEG($gambar); 
?>
