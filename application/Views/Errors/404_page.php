<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titlePage; ?></title>
    <style>
        body{
            margin: 0;
            font-family: sans-serif;
        }
        .wrapper-error {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            overflow: hidden;
            background-color: #e9e9e9;}
        .wrapper-error .widget {
            margin: 70px auto;
            background-color: inherit;
            text-align: center;
            padding: 20px;  }
        .wrapper-error .widget .error-code {
            font-size: 170px;
            display: block;
            padding-bottom: 10px;
          font-family: cursive;
            line-height: .95;}
        .wrapper-error .widget .error-message {
            font-size: 22px;
            padding-bottom: 40px; }
        .wrapper-error .widget a {
            -webkit-box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12) !important;
            -moz-box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12) !important;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12) !important;
            background-color: #ffffff !important;
            color: #141414 !important;
            -webkit-transition: all .4s;
            -moz-transition: all .4s;
            -ms-transition: all .4s;
            -o-transition: all .4s;
            transition: all .4s;
            padding: 10px 24px;  }
        .wrapper-error .widget a:hover {
            background-color: #F44336 !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
<div class="wrapper-error">
    <div class="widget">
        <div class="error-code"><?php echo $titleCenter ?></div>
        <div class="error-message"><?php echo $subTitle; ?></div>
        <a href="<?php echo $buttonUrl; ?>" class="btn-small bg-color-white btn-shadow"><?php echo $buttonName; ?></a>
    </div>
</div>
</body>
</html>