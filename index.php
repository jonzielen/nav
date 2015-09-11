<?php
    include_once 'php/nav-array.php';
    include_once 'php/class.navbuilder.php';
    $navigation = new navbuilderjz\Navbuilder($nav);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>test nav</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-static-top navbar-inverse">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button class="visible-xs c-hamburger c-hamburger--htx" data-toggle="collapse" data-target="#mainNav" aria-expanded="false">
                        <span>toggle menu</span>
                    </button>
                  <a class="navbar-brand" href="/">NYCgo</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="mainNav">
                  <?php echo $navigation; ?>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
        </header>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="js/min/main.min.js"></script>
    </body>
</html>
