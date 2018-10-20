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
		return 'INSERT INTO d_context(title,categoryId,source,author,editor,description,context,images,videos,weights) VALUES("'.$data->title.'",'.$data->categoryId.',"'.$data->source.'","'.$data->author.'","'.$data->editor.'","'.$data->description.'","'.addslashes($data->context).'","'.$data->cover.'","'.$data->videos.'",'.$data->weights.')';

	}
	private function upd(){
		$data = $this->data;
		return 'update d_context set title="'.$data->title.'",categoryId='.$data->categoryId.',source="'.$data->source.'",author="'.$data->author.'",editor="'.$data->editor.'",description="'.$data->description.'",context="'.addslashes($data->context).'",images="'.$data->cover.'",videos="'.$data->videos.'",weights='.$data->weights.' where id='.$data->id;
	}
	private function del(){
		return 'delete from d_context where id='.$this->data->id;
	}
	private function que(){
		$datas = $this->data;
		if($datas->id){
			return 'select *  from d_context where id='.$datas->id;
		}else{
			if($datas->search){
				return 'select a.*,c.categoryName from d_context as a join d_category as c on a.categoryId=c.id where title like "%'.$datas->search.'%"';
			}else{
				return 'select a.id,a.title,c.categoryName from d_context as a join d_category as c on a.categoryId=c.id limit '.($datas->page-1)*$datas->pageSize.','.$datas->pageSize;
			}
		}
	}
	public function getSql(){
        $methods = $this->data->opt;
        return $this->$methods();
	}
}
?>