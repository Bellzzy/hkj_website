<?php
class Article{
	private $data;

	 /**
     * 构造函数
     * @param array $data  配置项
     * @param bool $opt  需要执行的操作
     */
    public function __construct($data){
        $this->data = json_decode($data);
    }
	private function add(){
		$data = $this->data;
		return 'INSERT INTO d_article(title,c_id,source,author,editor,summary,content,cover,video,weight) VALUES("'.$data->title.'",'.$data->c_id.',"'.$data->source.'","'.$data->author.'","'.$data->editor.'","'.$data->summary.'","'.addslashes($data->content).'","'.$data->cover.'","'.$data->video.'",'.$data->weight.')';

	}
	private function upd(){
		$data = $this->data;
		return 'update d_article set title="'.$data->title.'",c_id='.$data->c_id.',source="'.$data->source.'",author="'.$data->author.'",editor="'.$data->editor.'",summary="'.$data->summary.'",content="'.addslashes($data->content).'",cover="'.$data->cover.'",video="'.$data->video.'",weight='.$data->weight.' where id='.$data->id;
	}
	private function del(){
		return 'delete from d_article where id='.$this->data->id;
	}
	private function que(){
		$datas = $this->data;
		if($datas->id){
			return 'select * from d_article where id='.$datas->id;
		}else{
			if($datas->search){
				return 'select a.*,c.c_name from d_article as a join d_category as c on a.c_id=c.c_id where title like "%'.$datas->search.'%"';
			}else{
				return 'select a.id,a.title,c.c_name from d_article as a join d_category as c on a.c_id=c.c_id limit '.($datas->page-1)*$datas->pageSize.','.$datas->pageSize;
			}
		}
	}
	public function getSql(){
        $methods = $this->data->opt;
        return $this->$methods();
	}
}
?>