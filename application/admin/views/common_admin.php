<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- saved from url=(0114)http://www.17sucai.com/preview/266121/2015-10-20/%E5%90%8E%E5%8F%B0%E7%AE%A1%E7%90%86%E7%B3%BB%E7%BB%9F/index.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>彩票管理系统</title>

    <!-- 新 Bootstrap 核心 CSS 文件 -->
<!--    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">-->

    <!-- 可选的Bootstrap主题文件（一般不用引入） -->
<!--    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">-->

    <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
    <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<!--    <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->

    <link type="text/css" rel="stylesheet" href="/application/admin/views/css/style.css">
    <script type="text/javascript" src="/application/admin/views/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/application/admin/views/js/menu.js"></script>

<!--    <script type="text/javascript" src="/application/admin/views/js/DatePicker.js"></script>-->
    <script type="text/javascript" src="/application/admin/views/js/MY97DATEPICKER/WdatePicker.js"></script>
<!--表单验证-->
    <script type="text/javascript" src="/application/admin/views/js/Validform_v5.3.2_min.js"></script>

    <style>
        .pagination {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
            margin-left: 35px;
        }
        .pagination{
            float:right;
            margin-right: 35px;
        }
        .pagination>li {
            display: inline
        }
        .pagination>li>a, .pagination>li>span,.pagination>li>strong {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination>li>strong{
            color: red;
        }
    </style>
</head>

<body>
<div class="top"></div>
<div id="header">
    <div class="logo">彩票管理系统</div>
    <div class="navigation">
        <ul>
            <li>欢迎您！</li>
            <li><a href="">张孝全</a></li>
<!--            <li><a href="">修改密码</a></li>-->
<!--            <li><a href="">设置</a></li>-->
            <li><a href="<?php echo site_url('login/quit')?>">退出</a></li>
        </ul>
    </div>
</div>
<div id="content">
    <div class="left_menu">
        <ul id="nav_dot">

            <li <?php if($this->router->class == 'welcome') echo 'class="selected"'?> >
                <h4 class="M1"><span></span>系统公告</h4>
                <div class="list-item none" <?php if($this->router->class == 'welcome') echo 'style="display:block;"'?> >
                    <a href="<?php echo  site_url('welcome/index')?>">最新公告</a>

                </div>
            </li>
            <li <?php if($this->router->class == 'football') echo 'class="selected"'?> >
                <h4 class="M2"><span></span>竞彩足球</h4>
                <div class="list-item none" <?php if($this->router->class == 'football') echo 'style="display:block;"'?> >
                    <a href="<?php echo site_url('football/index');?>">列表管理</a>
                    <a href="<?php echo site_url('football/add');?>">新增记录</a>
                    <a href="<?php echo site_url('football/search');?>">查询记录</a>
                </div>
            </li>

           <!-- <li <?php /*if($this->router->class == 'collect') echo 'class="selected"'*/?> >
                <h4 class="M2"><span></span>采集管理</h4>
                <div class="list-item none" <?php /*if($this->router->class == 'collect') echo 'style="display:block;"'*/?> >
                    <a href="<?php /*echo site_url('collect/index');*/?>">采集管理</a>
                    <a href="<?php /*echo site_url('collect/add');*/?>">新增记录</a>
                </div>
            </li>-->

        </ul>
    </div>
    <div class="m-right">
        <div class="right-nav">
            <ul>
                <li><img src="/application/admin/views/img/home.png"></li>
                <li style="margin-left:25px;">您当前的位置：</li>
                <li><a href="#"><?php echo $this->name;?></a></li>
                <li>&gt;</li>
                <li><a href="#"><?php echo $nav2;?></a></li>
            </ul>
        </div>
        <div class="main">

            <?php $this->load->view($tpl);?>

        </div>
    </div>
</div>
<div class="bottom"></div>
<div id="footer"><p>Copyright©  2016 版权所有 京ICP备05019125号-10</p></div>

<script>
        navList(12);

        //表单验证。
        $("form").Validform();

</script>


</body></html>