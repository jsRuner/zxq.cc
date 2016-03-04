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



        //查询条件。todo:
        $limit =  15;
        $offset = intval($this->input->get('per_page'));
        $result = $this->football->select_list($limit,$offset);
        $this->load->library('pagination');
        $config['base_url'] = "http://zxq.cc/admin.php/football/index";
        $config['total_rows'] = $this->football->count();
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
            show_error("编辑比赛出错","2000","呃呃呃。。。系统出现错误。");
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
            show_error("添加比赛出错","2000","呃呃呃。。。系统出现错误。");
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
        $peilvlist = $this->football_peilv->select_list_by_fid($fid);






        $data['peilvlist'] = $peilvlist;

        $data['tpl'] = "football_peilv";
        $data['nav2'] ="赔率列表";
        $this->load->view('common_admin',$data);

//        $this->load->view('football_peilv',$data);
    }

    public function peilv_delete(){

        $id = $this->input->post('id');
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

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('football_peilv_add');
            return;
        }

        $data = $this->input->post();

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
            show_error("添加比赛出错","2000","呃呃呃。。。系统出现错误。");
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

        $this->form_validation->set_message('required', '{field} 必须不为空.');
        $this->form_validation->set_rules('peilv_type', '让球数', 'required');

        //表单验证
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('football_peilv_editor');
            return;
        }

        $data = $this->input->post();

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
            show_error("编辑比赛赔率出错","2000","呃呃呃。。。系统出现错误。");
        }

    }




}
