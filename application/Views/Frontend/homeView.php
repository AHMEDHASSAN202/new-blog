<html>
<head>
    <meta charset="UTF-8">
    <?php foreach ($css AS $cssFile) : ?>
      <link rel="stylesheet" href="<?php echo $cssFile . '.css'; ?>">
    <?php endforeach; ?>
</head>
<body>
<?php
pre($units);
?>

  <?php foreach ($js AS $jsFile) : ?>
    <script src="<?php echo $jsFile . '.js'; ?>"></script>
  <?php endforeach; ?>
</body>
</html>