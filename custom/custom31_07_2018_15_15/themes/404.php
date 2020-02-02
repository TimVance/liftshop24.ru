<?php
if (! defined('DIAFAN'))
{
  $path = __FILE__; $i = 0;
  while(! file_exists($path.'/includes/404.php'))
  {
    if($i == 10) exit; $i++;
    $path = dirname($path);
  }
  include $path.'/includes/404.php';
}
?>
<!DOCTYPE html>
<head>
  <insert name="show_head">
  <insert name="show_css" files="style.css, media.css">
</head>
<body>
  <insert name="show_include" file="header">
  <main>
    <br /><br /><br /><br /><br /><br /><br />
    <div class="container flexWrap" style="text-align:center;font-size:24px;">
      Извините, страница не найдена! <br />
      <a href="/">Перейти на главную страницу</a>
    </div>
    <br /><br /><br /><br /><br /><br /><br />
  </main>
  <insert name="show_include" file="footer">
  <insert name="show_js">
  <script type="text/javascript" asyncsrc="<insert name="path">js/main.js" charset="UTF-8"></script>
</body>
</html>