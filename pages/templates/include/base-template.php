<!DOCTYPE html>
<html lang="pt-br">
<head>
  <base href="<?=$data['base']?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="public/css/style.css">
  <?php include __DIR__.'/from-server-vars.php'; ?>
  <script src="public/js/script.js"></script>
  <link rel="icon" href="public/images/icons/favicon.png">
  <title><?=$data['title']?></title>
</head>
<body>
  
  <?=$data['get_body_content']($data)?>

</body>
</html>