<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付 hi_php@163.com
 * Date: 2016/2/25
 * Time: 16:17
 * description:
 *////////////////////////////////////////////////////////////////////
//                            _ooOoo_                             //
//                           o8888888o                            //
//                           88" . "88                            //
//                           (| ^_^ |)                            //
//                           O\  =  /O                            //
//                        ____/`---'\____                         //
//                      .'  \\|     |//  `.                       //
//                     /  \\|||  :  |||//  \                      //
//                    /  _||||| -:- |||||-  \                     //
//                    |   | \\\  -  /// |   |                     //
//                    | \_|  ''\---/''  |   |                     //
//                    \  .-\__  `-`  ___/-. /                     //
//                  ___`. .'  /--.--\  `. . ___                   //
//                ."" '<  `.___\_<|>_/___.'  >'"".                //
//              | | :  `- \`.;`\ _ /`;.`/ - ` : | |               //
//              \  \ `-.   \_ __\ /__ _/   .-` /  /               //
//        ========`-.____`-.___\_____/___.-`____.-'========       //
//                             `=---='                            //
//        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^      //
//         佛祖保佑       永无BUG        永不修改                    //
//////////////////////////////////////////////////////////////////// 
class Football extends Admin_Controller
{

    public $name = "";


    public function __construct()
    {
        parent::__construct();
        $this->load->model('football_model','football');
        $this->load->model('football_peilv_model','football_peilv');

        $this->name = "竞彩足球";

    }

    //2016年2月27日 todo 需要增加显示最后一次的赔率。

    public function index(){

        $querystr = $this->input->get('querystr');
        $rulestr = $this->input->get('rulestr');

//      该查询与赔率查询是独立的。
        $football_peilv_win = $this->input->get('football_peilv_win');
        $football_peilv_draw = $this->input->get('football_peilv_draw');
        $football_peilv_fail = $this->input->get('football_peilv_fail');


        $football_peilv_where= array();
        if($football_peilv_win){
            $football_peilv_where['where']['peilv_win'] = $football_peilv_win;
        }
        if($football_peilv_draw){
            $football_peilv_where['where']['peilv_draw'] = $football_peilv_draw;
        }
        if($football_peilv_fail){
            $football_peilv_where['where']['peilv_fail'] = $football_peilv_fail;
        }
        //先查询出符合的条件的比赛id.
        $okfids_peilv = array();
        if(!empty($football_peilv_where)){
            $okfids_peilv = $this->football_peilv->find_fids_by_peilv($football_peilv_where);
        }

//        wwf_dump($okfids_peilv);
//        exit(0);

        if($rulestr){
            $data['rulestr'] = $rulestr;
            if($football_peilv_win){
                $data['rulestr'] .= '胜的赔率值:'.$football_peilv_win;
            }
            if($football_peilv_draw){
                $data['rulestr'] .= '平的赔率值:'.$football_peilv_draw;
            }
            if($football_peilv_fail){
                $data['rulestr'] .= '胜的赔率值:'.$football_peilv_fail;
            }



        }else{
            $data['rulestr'] = "";
            if($football_peilv_win){
                $data['rulestr'] .= '胜的赔率值:'.$football_peilv_win;
            }
            if($football_peilv_draw){
                $data['rulestr'] .= '平的赔率值:'.$football_peilv_draw;
            }
            if($football_peilv_fail){
                $data['rulestr'] .= '负的赔率值:'.$football_peilv_fail;
            }

            if(!empty($data['rulestr'])){
                $data['rulestr'] = '当前的查询条件:'.$data['rulestr'];
            }

        }

        if($querystr){
            $okfids = json_decode($querystr);

            //如果有二级查询，则合并id。
            if(!empty($okfids_peilv)){
                $okfids = array_merge($okfids,$okfids_peilv);
            }
        }

        //查询条件。todo:
        $limit =  15;
        $offset = intval($this->input->get('per_page'));

        //存在赔率变化查询。则
        if($querystr){
            $result = $this->football->select_list_option($limit,$offset,$okfids);
            //存在二次查询。
        }elseif($football_peilv_win ||$football_peilv_draw||$football_peilv_fail){
            //如果存在这个。
            if(empty($okfids_peilv)){
                $okfids_peilv = array('-1');
            }
            $result = $this->football->select_list_option($limit,$offset,$okfids_peilv);
        }else{
            $result = $this->football->select_list($limit,$offset);
        }
        $this->load->library('pagination');
        $config['base_url'] = "http://zxq.cc/admin.php/football/index";

        if($querystr){
            //数组。
            $config['total_rows'] = $this->football->count(array('where_in'=>array('id',$okfids)));

        }elseif(!empty($okfids_peilv)){
            //如果存在这个。
            $config['total_rows'] = $this->football->count(array('where_in'=>array('id',$okfids_peilv)));
        }else{
            $config['total_rows'] = $this->football->count();
        }


        $this->pagination->initialize($config);
        $data['paginationstr'] = $this->pagination->create_links();


        $data['footballlist'] = $result;




        $data['tpl'] = "football_index";
        $data['nav2'] ="列表管理";
        $this->load->view('common_admin',$data);





    }

    public function add(){

        $data['tpl'] = "football_add";
        $data['nav2'] ="新建记录";
        $this->load->view('common_admin',$data);
    }

    public function delete(){
        $id = $this->input->post('id');

        //检查是否存在赔率。
        $peilvlist = $this->football_peilv->select_list_by_fid($id);
        if (is_array($peilvlist) && count($peilvlist) >0){
            echo "删除失败:该比赛下还存在赔率记录。请先去删除赔率信息";
            exit(0);
        }


        $result = $this->football->delete($id);
        if($result){
            echo "删除成功";
        }else{
            echo "删除失败";
        }

    }

    //编辑。
    public function editor(){
        $fid = $this->input->get('id');
        //赛事信息
        $footballinfo = $this->football->find($fid);
        $data['footballinfo'] = $footballinfo;

        $data['tpl'] = "football_editor";
        $data['nav2'] ="编辑记录";
        $this->load->view('common_admin',$data);

    }

    //编辑表单.处理请求。
    public function editor_form(){
        $this->form_validation->set_message('required', '{field} 必须不为空.');
        $this->form_validation->set_rules('football_code', '比赛编码', 'required');

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('football_editor');
            return;
        }

        //比赛的fid
        $fid = $this->input->post('fid');

        $data = $this->input->post();
        //转换日期。
        $data['football_date'] = strtotime($data['football_date']);

        unset($data['fid']);
        $result = $this->football->editor($fid,$data);
        //success
        if ($result){
            redirect("football/index");
        }else{
            show_error("编辑比赛出错","200","呃呃呃。。。系统出现错误。");
        }

    }



//    处理表单。
    public function add_form(){

        $this->form_validation->set_message('required', '{field} 必须不为空.');
        $this->form_validation->set_rules('football_code', '比赛编码', 'required');

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('football_add');
            return;
        }

        $data = $this->input->post();
        //转换日期。
        $data['football_date'] = strtotime($data['football_date']);

        $result = $this->football->add($data);
        //success
        if ($result){
            redirect("football/index");
        }else{
            show_error("添加比赛出错","200","呃呃呃。。。系统出现错误。");
        }
    }

    //赔率列表。无需分页。赔率没有那么多记录。
    public function peilv(){
        $data = array();

        $fid = $this->input->get('id');

        //赛事信息
        $footballinfo = $this->football->find($fid);
        $data['footballinfo'] = $footballinfo;

        //赔率列表
        $peilvlist = $this->football_peilv->select_list_by_fid_order($fid);






        $data['peilvlist'] = $peilvlist;
//        wwf_dump($data);
//        exit(0);

        $data['tpl'] = "football_peilv";
        $data['nav2'] ="赔率列表";
        $this->load->view('common_admin',$data);

//        $this->load->view('football_peilv',$data);
    }

    public function peilv_delete(){

        $id = $this->input->post('id');

        $data = $this->football_peilv->find($id);
        //需要删除关联的赔率。
        //头部赔率。则下家的趋势需要重新计算。则下家的趋势为10000. 同时上级id为0
        if($data['peilv_trend_id_prev'] == 0 && $data['peilv_trend_id_next'] != 0 ){
            //查询下一条。重新计算自身的趋势
            $next_peilv = $this->football_peilv->find($data['peilv_trend_id_next']);
            $next_peilv['peilv_trend_win'] = 10000;
            $next_peilv['peilv_trend_draw'] = 10000;
            $next_peilv['peilv_trend_fail'] = 10000;
            $next_peilv['peilv_trend_id_prev'] = 0;
//            unset($next_peilv['id']);
            //更新。
            $this->football_peilv->editor($next_peilv['id'],$next_peilv);

        }
        //尾部赔率。
        if($data['peilv_trend_id_prev'] != 0 && $data['peilv_trend_id_next'] == 0 ){
            //查询上一条。修改上一条的记录中的下家id为0
            $prev_peilv = $this->football_peilv->find($data['peilv_trend_id_prev']);
            $prev_peilv['peilv_trend_id_next'] = 0;
//            unset($next_peilv['id']);
            //更新。
            $this->football_peilv->editor($prev_peilv['id'],$prev_peilv);
        }
        //中间的赔率。如果是中间的话。则需要修改关联前后2个id。
        if($data['peilv_trend_id_prev'] != 0 && $data['peilv_trend_id_next'] != 0 ){

            //取得上一条。只需要更新管理的下一条id
            $prev_peilv = $this->football_peilv->find($data['peilv_trend_id_prev']);
            $next_peilv = $this->football_peilv->find($data['peilv_trend_id_next']);
            $prev_peilv['peilv_trend_id_next'] = $next_peilv['id'];
            //更新。
            $this->football_peilv->editor($prev_peilv['id'],$prev_peilv);

            //更新下一条的趋势。
            $next_peilv['peilv_trend_win'] = $next_peilv['peilv_win']- $prev_peilv['peilv_win'];
            $next_peilv['peilv_trend_draw'] = $next_peilv['peilv_draw']- $prev_peilv['peilv_draw'];
            $next_peilv['peilv_trend_fail'] = $next_peilv['peilv_fail']- $prev_peilv['peilv_fail'];
            $next_peilv['peilv_trend_id_prev'] = $prev_peilv['id'];
            $this->football_peilv->editor($next_peilv['id'],$next_peilv);

        }






        $result = $this->football_peilv->delete($id);





        if($result){
            echo "删除成功";
        }else{
            echo "删除失败";
        }
    }




    #新增赔率。参数是比赛的id
    public function peilv_add(){
        $data = array();
        $id = $this->input->get('id');
        $footballinfo = $this->football->find($id);
        $data['footballinfo'] = $footballinfo;

        $data['tpl'] = "football_peilv_add";
        $data['nav2'] ="新增赔率";
        $this->load->view('common_admin',$data);

//        $this->load->view('football_peilv_add',$data);
    }


    public function peilv_add_form(){

        $this->form_validation->set_message('required', '{field} 必须不为空.');
        $this->form_validation->set_rules('peilv_type', '让球数', 'required');
        $this->form_validation->set_rules('peilv_date', '赔率时间', 'required');

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('football_peilv_add');
            return;
        }

        $data = $this->input->post();

        //转换日期。
        $data['peilv_date'] = strtotime($data['peilv_date']);

        //计算趋势。peilv_trend 如果存在前一次的赔率。则需要计算。根据fid peilv_type查询。取得最新的。
        $last_peilv = $this->football_peilv->find_last($data['fid'],$data['peilv_type']);
        if ($last_peilv ){
            //计算出差值。
            $data['peilv_trend_win'] = $data['peilv_win'] - $last_peilv['peilv_win'];
            $data['peilv_trend_draw'] = $data['peilv_draw'] - $last_peilv['peilv_draw'];
            $data['peilv_trend_fail'] = $data['peilv_fail'] - $last_peilv['peilv_fail'];
            $data['peilv_trend_id_prev'] = $last_peilv['id'];
        }

//        wwf_dump($data);
//        exit(0);



        //比赛的id。
        $fid = $data['fid'];
        //修改fid为football_id。
        $data['football_id'] = $data['fid'];
        unset($data['fid']);
//        var_dump($data);
        $result = $this->football_peilv->add($data);

        //这里还得将该结果保存到关联的记录中取。
        if ($last_peilv){
            $id = $this->db->insert_id();
            $this->football_peilv->editor($last_peilv['id'],array('peilv_trend_id_next'=>$id));
        }

        //success
        if ($result){
            redirect("football/peilv?id=".$fid);
        }else{
            show_error("添加比赛出错","200","呃呃呃。。。系统出现错误。");
        }

    }

    //编辑赔率
    public function peilv_editor(){
        $data = array();
        $fid = $this->input->get('fid');
        $footballinfo = $this->football->find($fid);
        $data['footballinfo'] = $footballinfo;
        //赔率的id
        $id = $this->input->get('id');
        $football_peilvinfo = $this->football_peilv->find($id);
        $data['football_peilvinfo'] = $football_peilvinfo;

        $data['tpl'] = "football_peilv_editor";
        $data['nav2'] ="编辑赔率";
        $this->load->view('common_admin',$data);


//        $this->load->view('football_peilv_editor',$data);
    }

    //处理赔率表单
    public function peilv_editor_form(){

//        wwf_dump($this->input->post());
//        exit(0);

        $this->form_validation->set_message('required', '{field} 必须不为空.');
        $this->form_validation->set_rules('peilv_type', '让球数', 'required');

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('football_peilv_editor');
            return;
        }

        $data = $this->input->post();

        //转换日期。
        $data['peilv_date'] = strtotime($data['peilv_date']);

        //这里重新计算赔率趋势。先查询关联的赔率记录。
        if ($data['peilv_trend_id_prev'] != 0){
            //查询上一条。重新计算自身的趋势
            $prev_peilv = $this->football_peilv->find($data['peilv_trend_id_prev']);
            $data['peilv_trend_win'] = $data['peilv_win'] - $prev_peilv['peilv_win'];
            $data['peilv_trend_draw'] = $data['peilv_draw'] - $prev_peilv['peilv_draw'];
            $data['peilv_trend_fail'] = $data['peilv_fail'] - $prev_peilv['peilv_fail'];
        }

        //查询下一条记录。改变下一条记录的趋势
        if($data['peilv_trend_id_next'] != 0 ){
            //查询下一条。重新计算自身的趋势
            $next_peilv = $this->football_peilv->find($data['peilv_trend_id_next']);
            $next_peilv['peilv_trend_win'] = $next_peilv['peilv_win'] - $data['peilv_win'];
            $next_peilv['peilv_trend_draw'] = $next_peilv['peilv_draw'] - $data['peilv_draw'];
            $next_peilv['peilv_trend_fail'] = $next_peilv['peilv_fail'] - $data['peilv_fail'];
//            unset($next_peilv['id']);
            //更新。
            $this->football_peilv->editor($next_peilv['id'],$next_peilv);
        }

        //赔率的id
        $id = $data['id'];
        //比赛的id。
        $fid = $data['fid'];
        unset($data['fid']);

        $result = $this->football_peilv->editor($id,$data);


        //success
        if ($result){
            redirect("football/peilv?id=".$fid);
        }else{
            show_error("编辑比赛赔率出错","200","呃呃呃。。。系统出现错误。");
        }

    }

    //查询的表单
    public function search()
    {
        $data['tpl'] = "football_search";
        $data['nav2'] ="查询记录";
        $this->load->view('common_admin',$data);

    }
    //先检查符合变化次数的记录。如果要变化3次，则对应的记录需要4条。
    //
    public function search_form(){
        $data = $this->input->post();
        //同一个football_id peilv_type 统计数量。
         $result = $this->football_peilv->select_list_num_group_fid_type($data['peilv_type']);
        //筛选出符合要求的记录。
        $fids = array();
        foreach($result as $item){
            if($item['peilv_change_num'] > $data['peilv_change_num']){
                $fids[] = $item['football_id'];
            }
        }
        if(count($fids) <= 0){
            show_error("查询记录为空","200","呃呃呃。。。系统出现错误。");
            return;
        }

        //查询所有符合条件的赔率记录。根据fid进行分组。如果是111.则查询条件是。
        //依次检查对应的比赛是否可以。如果可以。则存储该比赛id。
        $okfids = array();
        foreach($fids as $fid){
            //查询该比赛的下的peilv_type记录。然后依次检查是否符合要求。
             $temp = $this->football_peilv->select_list_by_fid_order_peilvdate($fid);

//            wwf_dump($temp);
//            exit(0);
            //获取该比赛下的规则。产生为字符串111或者101
            //规则如果是111.则依次必须大于0. todo:先只查询胜的趋势。
            $current_win = '';
            $current_draw = '';
            $current_fail = '';

            //从第二条记录开始。
            for($i =1;$i<=$data['peilv_change_num'];$i++){
                if($temp[$i]['peilv_trend_win'] > 0){
                    $current_win .= '升';
                }elseif($temp[$i]['peilv_trend_win'] == 0){
                    $current_win .= '平';
                }else{
                    $current_win .= '降';
                }

                if($temp[$i]['peilv_trend_draw'] > 0){
                    $current_draw .= '升';
                }elseif( $temp[$i]['peilv_trend_draw'] ==0){
                    $current_draw .= '平';
                }else{
                    $current_draw .= '降';
                }



                if($temp[$i]['peilv_trend_fail'] > 0){
                    $current_fail .= '升';
                }elseif($temp[$i]['peilv_trend_fail'] == 0){
                    $current_fail.= '平';
                }else{
                    $current_fail .= '降';
                }
            }
//            echo $fid;
//            echo "<br>";
//            echo $current_win;
//            echo "<br>";
//            echo $current_draw;
//            echo "<br>";
//            echo $current_fail;
//            echo "<br>";
//            exit();

            //3个规则。存在则检查是否相等。不存在则不用比较。
            $win_bool = $draw_bool = $fail_bool = true;
            if($data['peilv_win_rule'] && $data['peilv_win_rule'] != ''){
                if ($current_win != $data['peilv_win_rule']){
                    $win_bool = false;

                }
            }
            if($data['peilv_draw_rule'] && $data['peilv_draw_rule'] != ''){
                if ($current_draw != $data['peilv_draw_rule']){
                    $draw_bool = false;
                }
            }
            if($data['peilv_fail_rule'] && $data['peilv_fail_rule'] != ''){
                if ($current_fail != $data['peilv_fail_rule']){

                    $fail_bool = false;
                }
            }
            if($win_bool && $draw_bool && $fail_bool){
                $okfids[] = $fid;
            }
        }

        if(count($okfids) == 0){

            show_error("查询记录为空","200","呃呃呃。。。系统出现错误。");
            return;
        }else{
            //增加当前的规则说明。例如
            $rulestr = "当前查询的条件是:让球数".$data['peilv_type'];
            $rulestr .= ",次数为:".$data['peilv_change_num'];
            $rulestr .= ",胜:".($data['peilv_win_rule']==""?"无":$data['peilv_win_rule']);
            $rulestr .=",平:".($data['peilv_draw_rule']==""?"无":$data['peilv_draw_rule']);
            $rulestr .= ",负:".($data['peilv_fail_rule']==""?"无":$data['peilv_fail_rule']);
            $rulestr .= "。";
            redirect("football/index?querystr=".urlencode(json_encode($okfids))."&rulestr=".urlencode($rulestr));

        }


//        wwf_dump($okfids);
        //查询列表。todo:查询结果分页暂时不处理。
//        $limit =  15;
//        $offset = intval($this->input->get('per_page'));
//        $result = $this->football->select_list_option($limit,$offset,$okfids);
//        $this->load->library('pagination');
//        $config['base_url'] = "http://zxq.cc/admin.php/search/search_form";
//        $config['total_rows'] = $this->football->count();
//        $this->pagination->initialize($config);
//        $data['paginationstr'] = $this->pagination->create_links();
//        $data['footballlist'] = $result;
//        $data['tpl'] = "football_search_index";
//        $data['nav2'] ="查询结果";
//        $this->load->view('common_admin',$data);
    }

//    //搜索的结果展示。
//    public function search_index($searchids){
//
//    }






}
