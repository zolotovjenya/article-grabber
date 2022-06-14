<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Article extends Model
{
    use Sortable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    protected $primaryKey = 'article_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['article_title', 'article_date', 'article_url', 'article_author', 'article_tags'];

    public $sortable = ['article_title', 'article_date'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['dateFormat'];

    /**
     * Get date format 'd.m.Y' for article_date field
     *
     * @return bool
     */
    public function getDateFormatAttribute()
    {
        return date('d.m.Y', $this->attributes['article_date']);
    }
}
