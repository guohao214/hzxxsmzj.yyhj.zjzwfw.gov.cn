<?php
/**
 * Created by PhpStorm.
 * User: GuoHao
 * Date: 2017/4/19
 * Time: 23:26
 */

namespace Home\Api;


class TypeList
{
    public static $cacheTime = 86400;
    public static $cacheName = '_project_type_LIST.php';

    public static function getCacheTypeList()
    {
        $typeList = file_get_contents(self::$cacheName);
        return json_decode($typeList, true);
    }

    public static function setCacheTypeList($typeList)
    {
        $typeList = self::formatTypeList($typeList);
        file_put_contents(self::$cacheName, json_encode($typeList));

        return $typeList;
    }

    public static function formatTypeList($originTypeList)
    {
        $topTypeList = [];
        $typeList = [];
        // 处理数据 parentId=-1为顶级菜单
        foreach ($originTypeList as $key => $item) {
            $id = $item['id'];
            $parentId = $item['parentId'];
            if ($parentId == -1) {
                $topTypeList[$id] = $item;
                unset($originTypeList[$key]);
            }
        }

        // 处理二级菜单
        // 关系隐射
        $menuRelation = [];
        foreach ($originTypeList as $key => $item) {
            $id = $item['id'];
            $parentId = $item['parentId'];
            if ($topTypeList[$parentId]) {
                $typeList[$parentId][$id] = $item;
                $menuRelation[$id] = $parentId;
                unset($originTypeList[$key]);
            }
        }

        // 三级菜单
        foreach ($originTypeList as $key => $item) {
            $parentId = $item['parentId'];
            $topTypeListId = $menuRelation[$parentId];
            if ($topTypeListId) {
                $typeList[$topTypeListId][$parentId]['children'][] = $item;
            }
        }

        $response = [];
        $response['topTypeList'] = $topTypeList;
        $response['typeList'] = $typeList;

        return $response;
    }
}