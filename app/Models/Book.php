<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_id',
        'category_name',
        'title',
        'file',
        'image',
        'desc',
        'price',
    ];

    protected $hidden = ['category_id','category_name'];
    protected $casts = ['file' => 'array'];

    public function toArray()
    {
        return collect(parent::toArray())->merge([
            'price' => $this->price ?: 'free',
            'image' => request()->root().'/storage/'.$this->image,
            'file' => collect($this->file)->map(function($data){
                return request()->root().'/storage/'.$data;
            }),
            'category' => $this->category,
        ]);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
