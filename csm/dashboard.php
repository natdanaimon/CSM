<?php
@session_start();
error_reporting(E_ERROR | E_PARSE);
include './common/Permission.php';
include './common/FunctionCheckActive.php';
//include './controller/dashboardCSController.php';
//include './service/dashboardCSService.php';
//require_once('./common/ConnectDB.php');
ACTIVEPAGES(0);
?>
<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title><?= $_SESSION[title] ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="<?= $_SESSION[title_content] ?>"    name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="../assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        <div class="page-wrapper">
            <!-- BEGIN HEADER -->
            <?php include './templated/header.php'; ?>
            <!-- END HEADER -->
            <!-- BEGIN HEADER & CONTENT DIVIDER -->
            <div class="clearfix"> </div>
            <!-- END HEADER & CONTENT DIVIDER -->
            <!-- BEGIN CONTAINER -->
            <div class="page-container">
                <!-- BEGIN SIDEBAR -->
                <div class="page-sidebar-wrapper">
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <?php include './templated/menu.php'; ?>   
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->
                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
                        <!-- BEGIN PAGE HEADER-->
                        <!-- BEGIN THEME PANEL -->
                        <?php include './templated/theme_panel.php'; ?>
                        <!-- END THEME PANEL -->
                        <!-- BEGIN PAGE BAR -->
                        <div class="page-bar">
                            <ul class="page-breadcrumb">
                                
                                <li>
                                    <a href="dashboard.php"><?= $_SESSION[home_overview] ?></a>
                                </li>
                            </ul>

                        </div>
                        <!-- END PAGE BAR -->

                        <!-- END PAGE HEADER-->
                        <div class="row">
                            <br/>
                        </div>



                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

            </div>
            <!-- END CONTAINER -->








            <!-- BEGIN FOOTER -->
            <?php include './templated/footer.php'; ?>
            <!-- END FOOTER -->
        </div>
        <!-- BEGIN QUICK NAV -->
        <?php include './templated/quick_nav.php'; ?>
        <!-- END QUICK NAV -->



        <!-- BEGIN CORE PLUGINS -->
        <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <!--<script src="../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>-->
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->


        <script src="js/common/notify.js" type="text/javascript"></script>
        <link href="css/notify.css" rel="stylesheet" type="text/css" />
        <!--<script src="js/action/cs_dashboard.js" type="text/javascript"></script>-->



        <script>
            $(document).ready(function () {
//                chart_03();
//                chart_01();
                unloading();
            });
        </script>



        <?php $i = 9; ?>
        <script>
            function chart_01() {
                if (typeof (AmCharts) === 'undefined' || $('#dashboard_amchart_1').size() === 0) {
                    return;
                }

                var chartData = [{
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "townSize": pointSizeChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i) ?>),
                        "bulletClass": pointPingChart(<?= $controller->sumDP($i) ?>,<?= $controller->sumWD($i--) ?>),
                    }, {
                        "date": "<?= $controller->range_date($i) ?>",
                        "latitude":<?= $controller->sumDP($i) ?>,
                        "duration": <?= $controller->sumWD($i) ?>,
                        "distance": <?= $controller->sumDP($i) ?>,
                        "bulletClass": "lastBullet",
                    }];
                var chart = AmCharts.makeChart("dashboard_amchart_1", {
                    type: "serial",
                    fontSize: 12,
                    fontFamily: "Open Sans",
                    dataDateFormat: "YYYY-MM-DD",
                    dataProvider: chartData,
                    addClassNames: true,
                    startDuration: 1,
                    color: "#6c7b88",
                    marginLeft: 0,
                    categoryField: "date",
                    categoryAxis: {
                        parseDates: true,
                        minPeriod: "DD",
                        autoGridCount: false,
                        gridCount: 50,
                        gridAlpha: 0.1,
                        gridColor: "#FFFFFF",
                        axisColor: "#555555",
                        dateFormats: [{
                                period: 'DD',
                                format: 'DD'
                            }, {
                                period: 'WW',
                                format: 'MMM DD'
                            }, {
                                period: 'MM',
                                format: 'MMM'
                            }, {
                                period: 'YYYY',
                                format: 'YYYY'
                            }]
                    },
                    valueAxes: [{
                            id: "a1",
                            title: "distance",
                            gridAlpha: 0,
                            axisAlpha: 0
                        }, {
                            id: "a2",
                            position: "right",
                            gridAlpha: 0,
                            axisAlpha: 0,
                            labelsEnabled: false

                        }],
                    graphs: [{
                            id: "g1",
                            valueField: "distance",
                            title: "<?= $_SESSION[deposit] ?>",
                            type: "column",
                            fillAlphas: 0.7,
                            valueAxis: "a1",
                            balloonText: "<?= $_SESSION[deposit] ?> : [[value]] ฿",
                            legendValueText: ": [[value]] ฿",
                            legendPeriodValueText: "",
                            lineColor: "#08a3cc",
                            alphaField: "alpha",
                        }, {
                            id: "g2",
                            valueField: "latitude",
                            classNameField: "bulletClass",
                            title: "<?= $_SESSION[deposit] ?>",
                            type: "line",
                            valueAxis: "a2",
                            lineColor: "#786c56",
                            lineThickness: 1,
                            legendValueText: ": [[value]] ฿",
                            descriptionField: "townName",
                            bullet: "round",
                            bulletSizeField: "townSize",
                            bulletBorderColor: "#02617a",
                            bulletBorderAlpha: 1,
                            bulletBorderThickness: 2,
                            bulletColor: "#89c4f4",
                            labelText: "[[townName2]]",
                            labelPosition: "right",
                            balloonText: "<?= $_SESSION[deposit] ?> : [[value]] ฿",
                            showBalloon: true,
                            animationPlayed: true,
                        }, {
                            id: "g3",
                            title: "<?= $_SESSION[withdraw] ?>",
                            valueField: "duration",
                            type: "line",
                            valueAxis: "a3",
                            lineAlpha: 0.8,
                            lineColor: "#e26a6a",
                            balloonText: "<?= $_SESSION[withdraw] ?> : [[value]] ฿",
                            lineThickness: 1,
                            legendValueText: ": [[value]] ฿",
                            bullet: "square",
                            bulletBorderColor: "#e26a6a",
                            bulletBorderThickness: 1,
                            bulletBorderAlpha: 0.8,
                            dashLengthField: "dashLength",
                            animationPlayed: true
                        }],
                    chartCursor: {
                        zoomable: false,
                        categoryBalloonDateFormat: "DD",
                        cursorAlpha: 0,
                        categoryBalloonColor: "#e26a6a",
                        categoryBalloonAlpha: 0.8,
                        valueBalloonsEnabled: false
                    },
                    legend: {
                        bulletType: "round",
                        equalWidths: false,
                        valueWidth: 120,
                        useGraphSettings: true,
                        color: "#6c7b88"
                    }
                });
            }

            function pointSizeChart(deposit, withdraw) {
                if (deposit == withdraw) {
                    return 17;
                } else {
                    return 8;
                }
            }
            function pointPingChart(deposit, withdraw) {
                if (deposit > withdraw) {
                    return "lastBullet";
                } else {
                    return "";
                }
            }
        </script>



        <script>
            function chart_03() {
                if (typeof (AmCharts) === 'undefined' || $('#dashboard_amchart_3').size() === 0) {
                    return;
                }
                var chart = AmCharts.makeChart("dashboard_amchart_3", {
                    "type": "serial",
                    "addClassNames": true,
                    "theme": "light",
                    "path": "../assets/global/plugins/amcharts/ammap/images/",
                    "autoMargins": false,
                    "marginLeft": 70,
                    "marginRight": 0,
                    "marginTop": 10,
                    "marginBottom": 26,
                    "balloon": {
                        "adjustBorderColor": false,
                        "horizontalPadding": 10,
                        "verticalPadding": 8,
                        "color": "#ffffff"
                    },
                    "dataProvider": [{
                            "date": "<?= $controller->range_date(5) ?>",
                            "income": <?= $controller->sumDP(5) ?>,
                            "expenses": <?= $controller->sumWD(5) ?>
                        }, {
                            "date": "<?= $controller->range_date(4) ?>",
                            "income": <?= $controller->sumDP(4) ?>,
                            "expenses": <?= $controller->sumWD(4) ?>
                        }, {
                            "date": "<?= $controller->range_date(3) ?>",
                            "income": <?= $controller->sumDP(3) ?>,
                            "expenses": <?= $controller->sumWD(3) ?>
                        }, {
                            "date": "<?= $controller->range_date(2) ?>",
                            "income": <?= $controller->sumDP(2) ?>,
                            "expenses": <?= $controller->sumWD(2) ?>
                        }, {
                            "date": "<?= $controller->range_date(1) ?>",
                            "income": <?= $controller->sumDP(1) ?>,
                            "expenses": <?= $controller->sumWD(1) ?>
                        }, {
                            "date": "<?= $controller->range_date(0) ?>",
                            "income": <?= $controller->sumDP(0) ?>,
                            "expenses": <?= $controller->sumWD(0) ?>,
                            "dashLengthColumn": 5,
                            "alpha": 0.2,
                            "additional": "(<?= $_SESSION[today] ?>)"
                        }],
                    "valueAxes": [{
                            "axisAlpha": 0,
                            "position": "left"
                        }],
                    "startDuration": 1,
                    "graphs": [{
                            "alphaField": "alpha",
                            "balloonText": "<span style='font-size:12px;'>[[title]] <?= $_SESSION[in] ?> [[category]]:<br><span style='font-size:20px;'>[[value]] ฿</span> [[additional]]</span>",
                            "fillAlphas": 1,
                            "title": "<?= $_SESSION[deposit] ?>",
                            "type": "column",
                            "valueField": "income",
                            "dashLengthField": "dashLengthColumn"
                        }, {
                            "id": "graph2",
                            "balloonText": "<span style='font-size:12px;'>[[title]] <?= $_SESSION[in] ?> [[category]]:<br><span style='font-size:20px;'>[[value]] ฿</span> [[additional]]</span>",
                            "bullet": "round",
                            "lineThickness": 3,
                            "bulletSize": 7,
                            "bulletBorderAlpha": 1,
                            "bulletColor": "#FFFFFF",
                            "useLineColorForBulletBorder": true,
                            "bulletBorderThickness": 3,
                            "fillAlphas": 0,
                            "lineAlpha": 1,
                            "title": "<?= $_SESSION[withdraw] ?>",
                            "valueField": "expenses"
                        }],
                    "categoryField": "date",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "tickLength": 0
                    },
                    "export": {
                        "enabled": true
                    }
                });
            }
        </script>
    </body>

</html>