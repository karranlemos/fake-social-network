<!DOCTYPE html>
<html lang="pt-br">
<head>
  <base href="<?=$data['base']?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="public/css/style.css">
  <script src="public/js/script.js"></script>
  <title><?=$data['title']?></title>
</head>
<body>
  
  <?=$data['get_body_content']()?>

</body>
</html>