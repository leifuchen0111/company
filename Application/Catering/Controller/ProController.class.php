<?php
namespace Catering\Controller;

class ProController extends BaseController{

    public function pro()
    {
        $Pro = M('pro');

        $map = array();
        $map['webid'] = I('get.webid',0);

        $count = $Pro->where($map)->count();
        $Page = new \Think\Page($count,10);//分页
        $show = $Page->show();

        $list = $Pro->where($map)
                    ->limit($Page->firstRow,$Page->listRows)
                    ->select();

        $this->page = $show;
        $this->list = $list;
        $this->display();
    }

    public function add()
    {
        $Cate = M('category');

        $map = array(
            'type' => 'menu'
        );
        $cates = $Cate->where($map)->select();

        $this->cates = $cates;
        $this->display();
    }


    public function save()
    {
        $Pro = D('Pro');

        if(!$data = $Pro->create()){
            $this->error($Pro->getError());
        }

        if($Pro->id){
            //修改
            if(!$Pro->image){
                unset($Pro->image);
            }

            if($Pro->save()){
                updateApi($data['webid'],'editProduct',$data['id']);
                $this->success('修改成功');
            }else{

                $this->error('修改失败');
            }
        }else{
            //添加
            if($Pro->add()){
                if(!$Pro->image){
                    $this->error('请上传图片');
                }
                updateApi($data['webid'],'getProducts',$Pro->getLastSql());
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }

    }

    public function edit()
    {
        $Cate = M('category');
        $Pro = M('Pro');
        $id = I('get.id',0);
        $pro = $Pro->find($id);

        $map = array(
            'type' => 'menu'
        );
        $cates = $Cate->where($map)->select();

        $this->cates = $cates;
        $this->pro = $pro;
        $this->display('add');
    }




}
?>
