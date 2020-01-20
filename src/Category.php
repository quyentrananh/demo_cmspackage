<?php

namespace Quyen\Cmspackage;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;

class Category extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_categories';
    protected $parentField = 'parent_id';
    protected $orderField = 'ordering';
    protected $slugField = ['slug' => 'title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'image',
        'introtext',
        'fulltext',
        'status',
        'ordering',
        'featured',
    ];

    public static function search($filter = [], $orderBy = 'ordering', $orderType = 'ASC', $activeOnly = true)
    {
        $query = self::select('*')
            ->orderBy('parent_id', 'ASC')
            ->orderBy($orderBy, $orderType);

        if (isset($filter['keyword']) && $filter['keyword']) {
            $query->where('title', 'LIKE', "%".$filter['keyword']."%");
        }

        if ($activeOnly) {
            $query->where('status', 4);
        }else{
            $query->where('status', '>=', 1);
        }

        return $query;
    }

    public static function getCategoryTree($level=0, $prefix='', $activeOnly=true, $flatTree = true)
    {
        $query = self::where('parent_id', $level)
            ->orderBy('ordering', 'asc');
        if ($activeOnly) {
            $query->where('status', 4);
        }else{
            $query->where('status', '>=', 1);
        }

        $rows = $query->get();
        $category = array();
        if (count($rows) > 0) {
            foreach ($rows as $row) {
                if ($flatTree) {
                    $row->title = $prefix . $row->title;
                    $category[] = $row;
                    $category = array_merge($category, self::getCategoryTree($row->id, $prefix . '|---', $activeOnly));

                }else{

                    $row->items = self::getCategoryTree($row->id, $prefix . '', $activeOnly, $flatTree);
                    $category[] = $row;
                }
            }
        }

        return $category;
    }

    public function getCategorySelect($level = 0, $prefix = '', $activeOnly = true)
    {
        $selectCat = $this->getCategoryTree($level, $prefix, $activeOnly);
        $parentCat = array();
        foreach ($selectCat as $row){
            $parentCat[$row->id] = $row->title;
        }
        $selectCat = array('0' => '--- Select ---') + $parentCat;

        return $selectCat;
    }

    public function getLinkAttribute()
    {
        return $this->slug.'-nc'.$this->id.'.html';
    }
}
