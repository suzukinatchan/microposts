<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Micropost extends Model
{
    protected $fillable = ['content','user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function user_favorite()
    {
        //belingsToMany()内の説明
        //第一因数：得られるモデルクラス
        //第二因数：中間テーブル
        //第三因数：自分のidを示すカラム名
        //第四因数：中間テーブルに保存されている関係先のidを示すカラム名
        return $this->belongsToMany(User::class,'favorite','user_id','favorite_id')->withTimestamps();
    }
}


