
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

        .caiji_ing{
            color: red;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }


    </style>



                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>

                        <th>采集编号</th>
                        <th>采集名称</th>
                        <th>采集方法</th>
                        <th>采集说明</th>
                        <th>添加时间</th>
                        <th>更新时间</th>
                        <th>采集类型</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    foreach($collectlist as $item){
                    ?>


                    <tr>
                        <th scope="row"><?php echo $item['id'];?></th>
                        <td><?php echo  $item['collect_code'];?></td>
                        <td><?php echo  $item['collect_title'];?></td>
                        <td><?php echo  $item['collect_method'];?></td>
                        <td><?php echo msubstr($item['collect_content'],0,10);?></td>
                        <th><?php echo date('Y-m-d',$item['add_time']);?> </th>
                        <th><?php echo date('Y-m-d',$item['update_time']);?> </th>
                        <th><?php echo $item['data_type'] == 1?"内置":"人工";?></th>
                        <th>
                            <a href="<?php echo site_url('collect/editor');?>?id=<?php echo $item['id'];?>">编辑</a>
                            <a href="#" onClick="delcfm(this,<?php echo $item['id'];?>)">删除</a>
                            <a href="#" onClick="caijicfm(this,'<?php echo $item['collect_method'];?>',<?php echo $item['id'];?>)">采集</a>
                            <a href="<?php echo site_url('football/peilv');?>?id=<?php echo $item['id'];?>">数据</a>
                        </th>
                    </tr>

                    <?php
                    }
                    ?>

                    </tbody>
                </table>
                <?php echo $paginationstr; ?>



    <div class="caiji_ing" style="display: none;">
        正在采集。。。请勿进行其他操作。
    </div>


<script>


    function delcfm(obj,fid) {
        if (!confirm("确认要删除？")) {
            window.event.returnValue = false;
        }else{



            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('collect/delete')?>",
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

    //采集确认。按钮要变成不可以点击，需要出现采集的进度条，等采集ok才恢复
    function caijicfm(obj,methodname,cid) {
        if (!confirm("确认要采集？")) {
            window.event.returnValue = false;
        }else{

            $(".caiji_ing").show();
//            window.location.href =  "<?php //echo site_url('collect');?>//"+"/"+methodname;
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('collect')?>"+"/"+methodname,
                data:{id:cid},
                success: function(data){
                    alert(data);
                    $(".caiji_ing").hide();
                },
                dataType: "html"
            });

        }
    }


</script>

