<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    const CREATED_AT = 'intime';
    const UPDATED_AT = 'uptime';

    protected $guarded = ['id'];

    public static function tree()
    {
        $data = self::select()->get();
        $tree = self::buildTree($data);
        return $tree;
    }

    public static function buildSelect($tree)
    {
        $list = [];
        if(!is_array($tree) || count($tree)==0) return $list;

        foreach ($tree as $k => $item) {
            $children = $item['children'];
            unset($item['children']);
            $list[] = $item;
            $list = array_merge($list, self::buildSelect($children));
        }
        return $list;
    }

    /**
     * 放弃使用
     */
    public static function ____treeView($tree, $href='/admin/master/list')
    {
        $treeHTML = '<ul class="molsen-tree-menu" data-widget="tree">';

        foreach ($tree as $k => $item) {
            if (empty($item->children)) {
                $treeHTML .= '<li><a href="'.$href.'/'.$item->id.'"><i class="fa fa-list-ul"></i> '.$item->name.'</a></li>';
            } else {
                $treeHTML .= '<li class="treeview">
                <a href="#">
                  <i class="fa fa-list-ul"></i> <span> '.$item->name.'</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>';
            }
            $treeHTML .= self::treeChildView($item['children']);
            $treeHTML .= '</li>';
        }

        $treeHTML .= '<li>
        <a href="/admin/master/edit" class="btn btn-block btn-default">
        <i class="fa fa-plus"></i> <span>创建</span>
        </a>
    </li>
</ul>';
        return $treeHTML;
    }

    private static function treeChildView($tree)
    {
        $treeHTML = '<ul class="treeview-menu">';
        foreach ($tree as $k => $item) {
            if (empty($item->children)) {
                $treeHTML .= '<li><a href="#"><i class="fa fa-circle-o"></i> '.$item->name.'</a></li>';
            } else {
                $treeHTML .= '<li class="treeview">
                <a href="#"><i class="fa fa-circle-o"></i> '.$item->name.'
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>';
                $treeHTML .= self::treeChildView($item['children']);
                $treeHTML .= '</li>';
            }
            $treeHTML .= self::treeChildView($item['children']);
            $treeHTML .= '</li>';
        }
        $treeHTML .= '</ul>';
        return $treeHTML;
    }

    public static function buildTreeView($tree, $selectedID='', $href='/admin/master/list')
    {
        $result = [];
        foreach ($tree as $k => $item) {
            if (empty($item->children)) {
                if ($selectedID == $item->id) {
                    $result[] = ['text'=>$item->name, 'href'=>"{$href}/{$item->id}", 'tags'=>['0'], 'state'=>['selected'=>true, 'expanded'=>true]];
                } else {
                    $result[] = ['text'=>$item->name, 'href'=>"{$href}/{$item->id}", 'tags'=>['0']];
                }
            } else {
                if ($selectedID == $item->id) {
                    $result[] = ['text'=>$item->name, 'href'=>"{$href}/{$item->id}", 'nodes'=>self::buildTreeView($item->children), 'tags'=>[count($item->children)], 'state'=>['selected'=>true, 'expanded'=>true]];
                } else {
                    $result[] = ['text'=>$item->name, 'href'=>"{$href}/{$item->id}", 'nodes'=>self::buildTreeView($item->children), 'tags'=>[count($item->children)]];
                }
            }
        }
        return $result;
    }

    private static function buildTree(&$data, $pid=0, $level=0)
    {
        $tree = [];
        foreach ($data as $k => $item) {
            if ($item['pid'] == $pid) {
                unset($data[$k]);
                $item['level'] = $level;
                $item['children'] = self::buildTree($data, $item['id'], $level+1);
                $tree[] = $item;
            }
        }
        return $tree;
    }
}
