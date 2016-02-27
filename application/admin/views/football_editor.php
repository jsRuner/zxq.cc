<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


    <style>





        textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"],.uneditable-input {
            background-color: #fff;
            border: 1px solid #ccc;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
            -moz-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
            box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
            -webkit-transition: border linear .2s,box-shadow linear .2s;
            -moz-transition: border linear .2s,box-shadow linear .2s;
            -ms-transition: border linear .2s,box-shadow linear .2s;
            -o-transition: border linear .2s,box-shadow linear .2s;
            transition: border linear .2s,box-shadow linear .2s
        }

        select,textarea,input[type="text"],input[type="password"],input[type="datetime"],input[type="datetime-local"],input[type="date"],input[type="month"],input[type="time"],input[type="week"],input[type="number"],input[type="email"],input[type="url"],input[type="search"],input[type="tel"],input[type="color"],.uneditable-input {
            display: inline-block;
            /*height: 18px;*/
            padding: 4px;
            margin-bottom: 9px;
            font-size: 13px;
            line-height: 18px;
            color: #555
        }

        .input-xlarge {
            width: 270px
        }


        .help-block,.help-inline {
            color: #555
        }

        .help-block {
            display: block;
            margin-bottom: 9px
        }

        .help-inline {
            display: inline-block;
            *display: inline;
            padding-left: 5px;
            vertical-align: middle;
            *zoom:1}



        #target {
            min-height: 200px;
            /*border: 1px solid #ccc;*/
            padding: 5px;
        }
        #target{
            font-size: 16px;
            font-weight: normal;
            line-height: 18px;
        }

        .form-horizontal .control-label {
            float: left;
            width: 140px;
            padding-top: 5px;
            text-align: right;
        }
        .form-horizontal .controls {
            margin-left: 160px;
        }
        .form-horizontal input{
            display: inline-block;
            margin-bottom: 0;
        }

        .form-horizontal .help-block {
            margin-top: 9px;
            margin-bottom: 0
        }

        .form-horizontal .control-group {
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            *display: inline;
            padding: 4px 10px 4px;
            margin-bottom: 0;
            *margin-left: .3em;
            font-size: 13px;
            line-height: 18px;
            *line-height: 20px;
            color: #333;
            text-align: center;
            text-shadow: 0 1px 1px rgba(255,255,255,0.75);
            vertical-align: middle;
            cursor: pointer;
            background-color: #f5f5f5;
            *background-color: #e6e6e6;
            background-image: -ms-linear-gradient(top,#fff,#e6e6e6);
            background-image: -webkit-gradient(linear,0 0,0 100%,from(#fff),to(#e6e6e6));
            background-image: -webkit-linear-gradient(top,#fff,#e6e6e6);
            background-image: -o-linear-gradient(top,#fff,#e6e6e6);
            background-image: linear-gradient(top,#fff,#e6e6e6);
            background-image: -moz-linear-gradient(top,#fff,#e6e6e6);
            background-repeat: repeat-x;
            border: 1px solid #ccc;
            *border: 0;
            border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
            border-color: #e6e6e6 #e6e6e6 #bfbfbf;
            border-bottom-color: #b3b3b3;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            filter: progid:dximagetransform.microsoft.gradient(startColorstr='#ffffff',endColorstr='#e6e6e6',GradientType=0);
            filter: progid:dximagetransform.microsoft.gradient(enabled=false);
            *zoom:1;-webkit-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
            -moz-box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2),0 1px 2px rgba(0,0,0,0.05)
        }

        .btn-success {
            background-color: #5bb75b;
            *background-color: #51a351;
            background-image: -ms-linear-gradient(top,#62c462,#51a351);
            background-image: -webkit-gradient(linear,0 0,0 100%,from(#62c462),to(#51a351));
            background-image: -webkit-linear-gradient(top,#62c462,#51a351);
            background-image: -o-linear-gradient(top,#62c462,#51a351);
            background-image: -moz-linear-gradient(top,#62c462,#51a351);
            background-image: linear-gradient(top,#62c462,#51a351);
            background-repeat: repeat-x;
            border-color: #51a351 #51a351 #387038;
            border-color: rgba(0,0,0,0.1) rgba(0,0,0,0.1) rgba(0,0,0,0.25);
            filter: progid:dximagetransform.microsoft.gradient(startColorstr='#62c462',endColorstr='#51a351',GradientType=0);
            filter: progid:dximagetransform.microsoft.gradient(enabled=false)
        }



    </style>





                        <form id="target" class="form-horizontal" method="post" action="<?php echo site_url("football/editor_form");?>">

                            <input type="hidden" name="fid" value="<?php echo $footballinfo['id'];?>">

                            <fieldset>
                                <div id="legend" class="">
                                    <legend style="color:red;margin-left: 120px;padding-bottom: 10px;">
                                        <?php echo validation_errors(); ?>

                                    </legend>
                                </div>


                                <div class="control-group">

                                    <!-- Text input-->
                                    <label class="control-label" for="input01">比赛编号</label>
                                    <div class="controls">
                                        <input type="text" placeholder="比赛编号" class="input-xlarge" name="football_code" value="<?php echo $footballinfo['football_code'];?>">
                                        <p class="help-block">请输入比赛编号</p>
                                    </div>
                                </div>

                                <div class="control-group">

                                    <!-- Text input-->
                                    <label class="control-label" for="input01">日期</label>
                                    <div class="controls">
                                        <input type="text" placeholder="2016年2月25日" class="input-xlarge" name="football_date" onfocus="setday(this)" readonly="readonly" value="<?php echo date('Y-m-d',$footballinfo['football_date']);?>">
                                        <p class="help-block">请输入日期</p>
                                    </div>
                                </div>



                                <div class="control-group">

                                    <!-- Text input-->
                                    <label class="control-label" for="input01">主队</label>
                                    <div class="controls">
                                        <input type="text" placeholder="比赛球队" class="input-xlarge" name="football_team1" value="<?php echo $footballinfo['football_team1'];?>">
                                        <p class="help-block">请输入比赛球队</p>
                                    </div>
                                </div>

                                <div class="control-group">

                                    <!-- Text input-->
                                    <label class="control-label" for="input01">主队排名</label>
                                    <div class="controls">
                                        <input type="text" placeholder="主队排名" class="input-xlarge" name="team1_rank" value="<?php echo $footballinfo['team1_rank'];?>">
                                        <p class="help-block">主队排名</p>
                                    </div>
                                </div>


                                <div class="control-group">

                                    <!-- Text input-->
                                    <label class="control-label" for="input01">客队</label>
                                    <div class="controls">
                                        <input type="text" placeholder="比赛球队" class="input-xlarge" name="football_team2" value="<?php echo $footballinfo['football_team2'];?>">
                                        <p class="help-block">请输入比赛球队</p>
                                    </div>
                                </div>

                                <div class="control-group">

                                    <!-- Text input-->
                                    <label class="control-label" for="input01">客队排名</label>
                                    <div class="controls">
                                        <input type="text" placeholder="客队排名" class="input-xlarge" name="team2_rank" value="<?php echo $footballinfo['team2_rank'];?>">
                                        <p class="help-block">客队排名</p>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="input01">比分</label>
                                    <div class="controls">
                                        <input type="text" placeholder="比分" class="input-xlarge" name="football_score" value="<?php echo $footballinfo['football_score'];?>">
                                        <p class="help-block">比分</p>
                                    </div>
                                </div>

                                <div class="control-group">

                                    <!-- Text input-->
                                    <label class="control-label" for="input01">比赛结果</label>
                                    <div class="controls">
                                        <input type="text" placeholder="比赛结果" class="input-xlarge" name="football_result" value="<?php echo $footballinfo['football_result'];?>">
                                        <p class="help-block">比赛结果</p>
                                    </div>
                                </div>

                               <!-- <div class="control-group">

                                    <label class="control-label" for="input01">赔率</label>
                                    <div class="controls">
                                        <input type="text" placeholder="赔率" class="input-xlarge">
                                        <p class="help-block">赔率</p>
                                    </div>
                                </div>-->

                                <div class="control-group">
                                    <label class="control-label">保存</label>

                                    <!-- Button -->
                                    <div class="controls">
                                        <button class="btn btn-success">提交</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>


