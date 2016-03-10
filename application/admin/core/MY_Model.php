<?php
/**
 * Created by JetBrains PhpStorm.
 * User: 吴文付 hi_php@163.com
 * Date: 2016/2/26
 * Time: 13:02
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
class MY_Model extends CI_Model
{
    //主键
    protected $primary = 'id';
    //表名
    protected $table = NULL;
    //对象数据
    protected $data = array();

    //链操作
    private $methods = array('from', 'select', 'select_max', 'select_min', 'select_avg', 'select_sum', 'join', 'where', 'or_where', 'where_in', 'or_where_in', 'where_not_in', 'or_where_not_in', 'like', 'or_like', 'not_like', 'or_not_like', 'group_by', 'distinct', 'having', 'or_having', 'order_by', 'limit');


    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        if (get_class($this) != 'MY_Model') {
            if (empty($this->table)) {
                $this->table = strtolower(substr(get_class($this), 0, -6));
            }
            //设置字段和主键
            $this->fields = $this->get_fields();
            $this->primary = $this->db->primary($this->table);
        }
    }

    //查询指定条件的数据。这里限定是主键id。 例如1,2,3,4 或者1
    //todo :这里需要改进。支持其他查询条件。
    public function find($options = array()){
        if (is_string($options) || is_numeric($options)) {
            if (strpos($options, ',')) {
                $this->db->where_in($this->primary, explode(',', $options));
            } else {
                $this->db->where(array(($this->table.'.'.$this->primary) => $options));
            }
        } else {
            $this->_parse_options($options);
        }
        return $this->db->get($this->table)->row_array();
    }

    public function find_all($options = array())
    {
        $this->_parse_options($options);
        return $this->db->get($this->table)->result_array();
    }


    #插入数据。返回的是bool
    public function add($data = array()){

        #数据预处理。例如过滤 todo
        $facade_data = $data;
        #添加数据时间
        $facade_data['add_time'] = time();
        $facade_data['update_time'] = time();

        $result = $this->db->insert($this->table, $facade_data);
        return $result;
    }

    #插入数据。返回的是插入后的id。
    public function add_id($data = array()){

        #数据预处理。例如过滤 todo
        $facade_data = $data;
        #添加数据时间
        $facade_data['add_time'] = time();
        $facade_data['update_time'] = time();

        $this->db->insert($this->table, $facade_data);
        return $this->db->insert_id();
    }

    #插入多条数据。
    public function adds($datas = array()){
        #数据预处理。例如过滤 todo
        $facade_datas = $datas;
        #添加数据时间
        foreach($facade_datas as &$item){

            $item['add_time'] = time();
            $item['update_time'] = time();
        }

        $result = $this->db->insert_batch($this->table, $facade_datas);
        return $result;

    }




    /**
     * 删除数据.暂时只能处理1,2,3,4, 或者1
     */
    public function delete($options = array())
    {
        if(is_numeric($options)  || is_string($options)) {
            $primary = $this->primary;
            if(strpos($options, ',')) {
                $this->db->where_in($primary, explode(',', $options));
            }else{
                $this->db->where(array($primary => $options));
            }
        }else{
            return false;
        }

        $result = $this->db->delete($this->table);
        return $result;
    }

    //根据id进行编辑。
    public function editor($options = array(),$data = array()){
        if (! is_numeric($options)){
            return false;
        }
        $this->db->where(array($this->primary => $options));

        $data['update_time'] = time();
        $result = $this->db->update($this->table, $data);
        return $result;
    }

    /**
     * 统计行数
     */
    public function count($options = array())
    {
        $this->_parse_options($options);
        return $this->db->from($this->table)->count_all_results();
    }

    protected function _parse_options($options)
    {
        if (!empty($options)) {
            foreach ($options as $key => $val) {
                    $this->db->$key($val);
            }
        }
    }

    /**
     * 获取主键
     */
    public function get_primary()
    {
        return $this->primary;
    }

    /**
     * 获取表字段
     */
    public function get_fields($table = '')
    {
        return $this->db->list_fields($table ? $table : $this->table);
    }


}
