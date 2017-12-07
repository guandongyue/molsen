<?php

namespace App;

use App\Events\MasterSaved;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use App\Lua;

class Master extends Model
{
    const CREATED_AT = 'intime';
    const UPDATED_AT = 'uptime';

    protected $guarded = ['id'];

    /**
     * 模型的事件映射。
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => MasterSaved::class,
    ];

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

    public function updateRedisTags()
    {
        $luaScrpit = Lua::TAGS_UPDATE;
        // $hashKey = sha1($luaScrpit);
        // $rs = Redis::evalsha($luaScrpit, 0);
        // $rs = Redis::script('load', $luaScrpit, 0);
        $rs = Redis::eval($luaScrpit, 0);
        // $rs = Redis::script('exists', $hashKey);
        // if (!$rs) {
        //     Redis::eval($luaScrpit, 0);
        // }
    }

    public function setCache()
    {
        $tagsName = $this->select()->get()->mapWithKeys(function ($item) {
            return [$item['id'] => $item['name']];
        })->toArray();
        Cache::forever('masterDict', $tagsName);
    }

    // private static function treeChildView($tree)
    // {
    //     $treeHTML = '<ul class="treeview-menu">';
    //     foreach ($tree as $k => $item) {
    //         if (empty($item->children)) {
    //             $treeHTML .= '<li><a href="#"><i class="fa fa-circle-o"></i> '.$item->name.'</a></li>';
    //         } else {
    //             $treeHTML .= '<li class="treeview">
    //             <a href="#"><i class="fa fa-circle-o"></i> '.$item->name.'
    //             <span class="pull-right-container">
    //                 <i class="fa fa-angle-left pull-right"></i>
    //             </span>
    //             </a>';
    //             $treeHTML .= self::treeChildView($item['children']);
    //             $treeHTML .= '</li>';
    //         }
    //         $treeHTML .= self::treeChildView($item['children']);
    //         $treeHTML .= '</li>';
    //     }
    //     $treeHTML .= '</ul>';
    //     return $treeHTML;
    // }

    /**
     * Data for Bootstrap-treeview.js
     */
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
