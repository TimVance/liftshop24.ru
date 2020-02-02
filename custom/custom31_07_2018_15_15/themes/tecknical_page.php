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
        <insert name="show_css" files="style.css, media.css, slick.css, slick-theme.css">
            </head>
<body>
<insert name="show_include" file="header">
    <main>
        <div class="container">
            <insert name="show_breadcrumb" current="true">
                <div class="flexBetween">
                    <div class="left">
                        <insert name="show_search" module="shop">
                            <insert name="show_viewed" module="viewed" images="1" maxview="3">
                    </div>
                    <div class="right">
                        <?php

                            $rows = DB::query_fetch_all("
                                SELECT * FROM {shop} WHERE [name]
                                LIKE 'кнопк%'
                            ");
                            foreach ($rows as $row) {
                                echo $row["name1"].'<br />';
                            }
                            echo count($rows);
                        ?>
                    </div>
                </div>
        </div>
    </main>
    <insert name="show_include" file="footer">
        <insert name="show_js">
            <script type="text/javascript" asyncsrc="<insert name="custom" path="js/main.js" absolute="true" compress="js">" charset="UTF-8"></script>
            <!--[if lt IE 9]>
            <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
            <![endif]-->
</body>
</html>