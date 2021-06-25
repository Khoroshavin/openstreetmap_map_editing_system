<?php
require '../common.php';

// если не залогинены или роль не совпадает - уходим через принудительный логаут
if (empty($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: ../login/');
    exit;
}

$name = DB_NAME;
// отсылаем запрос на получения админов
$quantityAdmins = query("SELECT COUNT(id) FROM users WHERE role = 'admin'")->fetch_row()[0];
// отсылаем запрос на получения редакторов
$quantityRedactors = query("SELECT COUNT(id) FROM users WHERE role = 'redaktor'")->fetch_row()[0];

// отсылаем запрос на получения размера
$sql = "SELECT table_schema 'db_name', ROUND(SUM( data_length + index_length) / 1024 / 1024, 2) 'db_size_in_mb' FROM information_schema.TABLES WHERE table_schema='DB_NAME' GROUP BY table_schema ;";
$sizeDB = mysqli_fetch_array(query($sql))['db_size_in_mb'];

// Узнаём размер папки с изображениями
$path = '../vendor/tiny/images/';
$dirname = $path; // указываем полный путь до папки или файла 
$size = dir_size($dirname); //заносим в переменную размер папки или файла
$formSize = format_size($size); //форматируем вывод

// функция для просмотра всех подпапок и всех вложенных файлов
function dir_size($dirname) {
    $totalsize=0;
    if ($dirstream = @opendir($dirname)) {
    while (false !== ($filename = readdir($dirstream))) {
        // проверка на совпадения
        if ($filename!="." && $filename!="..")
        {
            if (is_file($dirname."/".$filename))
            $totalsize+=filesize($dirname."/".$filename);
    
            if (is_dir($dirname."/".$filename))
            $totalsize+=dir_size($dirname."/".$filename);
            }
        }
    }
    closedir($dirstream);
    return $totalsize;
}
// функция форматирует вывод размера
function format_size($size){
        $metric = 0;         
        while(floor($size) > 0){
            ++$metric;
            $size /= 1024;
        }        
        $ret =  round($size, 2);
    return $ret;
}
// переписаная функция, которая получает размер двух таблиц, и суммирует их
function get_tabel_size () {
    $first = mysqli_fetch_array(query('SELECT table_name AS `Table`, round(((data_length + index_length) / 1024 / 1024), 3) `size` FROM information_schema.TABLES WHERE table_schema = "DB_NAME" AND table_name = "markers"'))['size'];
    $second = mysqli_fetch_array(query('SELECT table_name AS `Table`, round(((data_length + index_length) / 1024 / 1024), 3) `size` FROM information_schema.TABLES WHERE table_schema = "DB_NAME" AND table_name = "users"'))['size'];
    $first = $first + 0;
    $second = $second + 0;
    return $first + $second;
}

?>


<!DOCTYPE html>
<html lang="cs-cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin info</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Administrátor</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<div class="container-fluid">
    <div class="row">

        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                <li class="nav-item">

                        <a class="nav-link" href="../">

                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-geo-alt" fill="currentColor"
                                 xmlns="http://www.w3.org/2000/svg">

                                <path fill-rule="evenodd"
                                      d="M12.166 8.94C12.696 7.867 13 6.862 13 6A5 5 0 0 0 3 6c0 .862.305 1.867.834 2.94.524 1.062 1.234 2.12 1.96 3.07A31.481 31.481 0 0 0 8 14.58l.208-.22a31.493 31.493 0 0 0 1.998-2.35c.726-.95 1.436-2.008 1.96-3.07zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>

                                <path fill-rule="evenodd"
                                      d="M8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>

                            </svg>

                            Prohlédnout mapu

                        </a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                <span data-feather="home">
                  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-people" fill="currentColor"
                       xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                  </svg></span>
                  Uživatelé
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pie-chart"
                                 fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd"
                                      d="M7.5 7.793V1h1v6.5H15v1H8.207l-4.853 4.854-.708-.708L7.5 7.793z"/>
                            </svg>
                            Informace
                        </a>
                    </li>

                    <li class="nav-item mt-2 ">
                        <a class="nav-link text-muted" href="#" data-toggle="modal" data-target="#logoutModal">
                        Odhlášení
                        </a>
                    </li>
                </ul>

                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

            <div class="container">
                <h1>Informace o systému</h1>
            </div>

            <div class="container grafy">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-3 shadow">
                            <div class="card-header">
                                <i class="fas fa-chart-pie"></i>Poměr uzivatelu
                            </div>
                            <div class="card-body">
                                <canvas id="myPieChart" width="100%" height="78%"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class=" card mb-3 shadow ">
                            <div class="card-header">
                                <i class="fas fa-chart-pie"></i>
                                Velikost databáze
                            </div>
                            <div class="card-body">
                                <?php echo get_tabel_size() ?> mb
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class=" card mb-3 shadow ">
                            <div class="card-header">
                                <i class="fas fa-chart-pie"></i>
                                Velikost složky obrázků
                            </div>
                            <div class="card-body">
                                <?php echo $formSize ?> mb
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            

        </main>

        <div class="modal" tabindex="-1" id="logoutModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Opravdu se chcete odhlásit?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne, zavřít</button>
                        <a href="../login/logout.php" type="button" class="btn btn-success">Odhlásit se</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<!-- jQuery and Bootstrap Bundle (includes Popper) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
</script>
<!-- VENDOR CHART JS -->
<script src="../vendor/chart.js/Chart.min.js"></script>
<!-- PIE-CHART.JS -->
<script src="../js/pie-chart.js"></script>

<script>
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Administrátori", "Správci"],
            datasets: [{
                data: [<?= $quantityAdmins ?>, <?= $quantityRedactors ?>],
                backgroundColor: ['#007bff', '#28a745'],
            }],
        },
    });

    var chartProgress = document.getElementById("chartProgress");
    if (chartProgress) {
        var myChartCircle = new Chart(chartProgress, {
            type: 'doughnut',
            data: {
                labels: ["Obsazeno", 'Zbyva'],
                datasets: [{
                    backgroundColor: ["#28a745"],
                    data: [68, 48]
                }]
            },
            plugins: [{
                beforeDraw: function (chart) {
                    var width = chart.chart.width,
                        height = chart.chart.height,
                        ctx = chart.chart.ctx;

                    ctx.restore();
                    var fontSize = (height / 150).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.fillStyle = "#9b9b9b";
                    ctx.textBaseline = "middle";

                    var text = "<?= $sizeDB ?>" + "MB",
                        textX = Math.round((width - ctx.measureText(text).width) / 2),
                        textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            }],
            options: {
                legend: {
                    display: false,
                },
                responsive: true,
                maintainAspectRatio: false,
                cutoutPercentage: 85
            }

        });


    }
</script>
<!-- DOUGHNUT-CHART -->
<!--<script src="../js/doughnut-chart.js"></script>-->
<script src="../js/script.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
</body>

</html>