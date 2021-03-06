
    <style>

        table {
            background-color: transparent;
            border-collapse: collapse;
        }

        caption {
            padding-top: 8px;
            padding-bottom: 8px;
            color: #777;
            text-align: left
        }

        th {
            text-align: left
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px
        }

        .table>tbody>tr>td,.table>tbody>tr>th,.table>tfoot>tr>td,.table>tfoot>tr>th,.table>thead>tr>td,.table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd
        }

        .table>thead>tr>th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd
        }

        .table>caption+thead>tr:first-child>td,.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>td,.table>thead:first-child>tr:first-child>th {
            border-top: 0
        }

        .table>tbody+tbody {
            border-top: 2px solid #ddd
        }

        .table .table {
            background-color: #fff
        }

        .table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th {
            padding: 5px
        }

        .table-bordered {
            border: 1px solid #ddd
        }

        .table-bordered>tbody>tr>td,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>td,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>thead>tr>th {
            border: 1px solid #ddd
        }

        .table-bordered>thead>tr>td,.table-bordered>thead>tr>th {
            border-bottom-width: 2px
        }

        .table-striped>tbody>tr:nth-of-type(odd) {
            background-color: #f9f9f9
        }

        .table-hover>tbody>tr:hover {
            background-color: #f5f5f5
        }

        tr,td{
           border-collapse: collapse;
       }


    </style>
    <form action="<?php echo site_url('football/index');?>">

        <input type="hidden" name="querystr" value="<?php echo $this->input->get('querystr');?>">
        <input type="hidden" name="rulestr" value="<?php echo $this->input->get('rulestr');?>">
        
        <div style="margin-left: 15px;line-height: 30px;">胜:
            <input type="text" name="football_peilv_win" id="" value="<?php echo $this->input->get('football_peilv_win');?>">平:
            <input type="text" name="football_peilv_draw" id="" value="<?php echo $this->input->get('football_peilv_draw');?>">负:
            <input type="text" name="football_peilv_fail" id="" value="<?php echo $this->input->get('football_peilv_fail');?>">
            <button type="submit">查询</button>
        </div>

    </form>



    <p style="margin-left: 15px;color: red"><?php echo $rulestr;?>    </p>



                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>赛事编号</th>
<!--                        <th>联赛</th>-->
                        <th>日期</th>
                        <th>主队&nbsp;VS&nbsp; 客队</th>
                        <th>赛季排名</th>
<!--                        <th>让球</th>-->
<!--                        <th>胜</th>-->
<!--                        <th>平</th>-->
<!--                        <th>负</th>-->
                        <th>比分</th>
                        <th>比赛结果</th>
                        <th>数据来源</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach($footballlist as $item){
                    ?>


                    <tr>
                        <th scope="row"><?php echo $item['id'];?></th>
                        <td><?php echo  $item['football_code'];?></td>
                        <td><?php echo date("Y-m-d H:i:s",$item['football_date']);?></td>
                        <th><?php echo $item['football_team1'];?>&nbsp;VS&nbsp;<?php echo $item['football_team2'];?> </th>
                        <th><?php echo $item['team1_rank'];?>&nbsp;VS&nbsp;<?php echo $item['team2_rank'];?></th>


<!--                        <th>--><?php //echo $item['id'];?><!--</th>-->
<!--                        -->
<!--                        <th>--><?php //echo $item['id'];?><!--</th>-->
<!--                        <th>--><?php //echo $item['id'];?><!--</th>-->
<!--                        <th>--><?php //echo $item['id'];?><!--</th>-->


                        <th><?php echo $item['football_score'];?></th>
                        <th><?php echo $item['football_result'];?></th>
                        <th><?php echo $item['data_from'] == 1?"采集":"人工";?></th>
                        <th>
                            <a href="<?php echo site_url('football/editor');?>?id=<?php echo $item['id'];?>">编辑</a>
<!--                            <a href="#">查看</a>-->
                            <a href="#" onClick="delcfm(this,<?php echo $item['id'];?>)">删除</a>
                            <a href="<?php echo site_url('football/peilv');?>?id=<?php echo $item['id'];?>">赔率</a>
                        </th>
                    </tr>

                    <?php
                    }
                    ?>

                    </tbody>
                </table>
                <?php echo $paginationstr; ?>




<script>


    function delcfm(obj,fid) {
        if (!confirm("确认要删除？")) {
            window.event.returnValue = false;
        }else{
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('football/delete')?>",
                data:{id:fid},
                success: function(data){
                    alert(data);
                    //删除当前a标签的祖先元素 的tr.
                    if (data =="删除成功"){
                        $(obj).parents("tr").remove();
                    }
                },
                dataType: "html"
            });

        }
    }


</script>

