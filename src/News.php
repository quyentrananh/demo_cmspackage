<?php

namespace Quyen\Cmspackage;

use Illuminate\Database\Eloquent\Model;
use App\Models\BaseModel;
use Carbon\Carbon;

use Quyen\Cmspackage\Category;

class News extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cms_news';
    protected $slugField = ['slug' => 'title'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'image',
        'image2',
        'introtext',
        'fulltext',
        'featured',
        'refer_link',
        'refer_date',
        'status',
    ];

    public static function search($filter = [], $orderBy = 'ID', $orderType = 'DESC', $activeOnly = true)
    {
        $query = self::select('*')->orderBy($orderBy, $orderType);

        if (isset($filter['keyword']) && $filter['keyword']) {
            $query->where('title', 'LIKE', "%".$filter['keyword']."%");
        }

        if (isset($filter['featured']) && $filter['featured']) {
            $query->where('featured', $filter['featured']);
        }

        if ($activeOnly) {
            $query->where('status', 4);
        }else{
            $query->where('status', '>=', 1);
        }

        return $query;
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id')->withDefault(
            function ($item) {
                $item->title = 'N/A';
                $item->id = 0;
            }
        );
    }

    public function getLinkAttribute()
    {
        return $this->slug.'-n'.$this->id.'.html';
    }

    public function getReferDateHumanAttribute()
    {
        $referDate = $this->refer_date;

        return Carbon::create($referDate)->diffForHumans();
    }
}
