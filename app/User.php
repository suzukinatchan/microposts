<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
     public function microposts()
{
        return $this->hasMany(Micropost::class);
}
    
    //フォローしている人の表示
     public function followings()
{
        return $this->belongsToMany(User::class, 'user_follow', 'user_id', 'follow_id')->withTimestamps();
}

    //フォローされている人の表示
    public function followers()
{
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id', 'user_id')->withTimestamps();
}
    
    //誰かをフォローするときのメソッド
    public function follow($userId)
{
    // 既にフォローしているかの確認
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist || $its_me) {
        // 既にフォローしていれば何もしない
        return false;
    } else {
        // 未フォローであればフォローする
        $this->followings()->attach($userId);
        return true;
    }
}
    //フォローを外すときのメソッド
    public function unfollow($userId)
{
    // 既にフォローしているかの確認
    $exist = $this->is_following($userId);
    // 自分自身ではないかの確認
    $its_me = $this->id == $userId;

    if ($exist && !$its_me) {
        // 既にフォローしていればフォローを外す
        $this->followings()->detach($userId);
        return true;
    } else {
        // 未フォローであれば何もしない
        return false;
    }
}
    //この行は何をあらわしている？
    public function is_following($userId) 
{
        return $this->followings()->where('follow_id', $userId)->exists();
}

    public function user_favorite()
{
        return $this->belongsToMany(Micropost::class,'favorite','user_id','micropost_id')->withTimestamps();
}
     public function favorite($micropostId)
{
        // 既にお気に入りしているかの確認
        $exist = $this->is_favoriting($micropostId);
    
        
         if ($exist) {
            // すでにお気に入りしていれば何もしない
            return false;
        } else {
            // お気に入り登録していなければ登録する
            $this->user_favorite()->attach($micropostId);
            return true;
        }
    }
    
    public function unfavorite($micropostId)
{
    // 既にお気に入りしているかの確認
    $exist = $this->is_favoriting($micropostId);
  

    if ($exist) {
        // 既にお気に入りしていればお気に入りを外す
        $this->user_favorite()->detach($micropostId);
        return true;
    } else {
        // お気に入り登録していなければば何もしない
        return false;
    }
}

    public function is_favoriting($micropostId)
{
        return $this->user_favorite()->where('micropost_id',$micropostId)
        ->exists();
}

    
    
    
}
