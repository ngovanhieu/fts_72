<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Kyslik\ColumnSortable\Sortable;

class Question extends Model
{
    use SoftDeletes;
    use Searchable;
    use Sortable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public $sortable = ['id', 'status'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the system answers for the question.
     */
    public function systemAnswers()
    {
        return $this->hasMany(SystemAnswer::class);
    }

    /**
     * Get the results for the question.
     */
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    /**
     * Get the user that owns the question.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject that owns the question.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function toSearchableArray()
    {
      return [
           'question_ID' => $this->id,
           'content' => $this->content,
           'status' => $this->status
        ];
    }
}
