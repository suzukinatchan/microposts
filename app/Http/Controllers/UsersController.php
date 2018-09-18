<?php
//フォルダの場所を指定、下へと下がっていっている
namespace App\Http\Controllers;
//データベースを指定していたような気がする
//Illuminateは、Laravelプロジェクトの初めにつくもの。
use Illuminate\Http\Request;
//使うモデルのクラス名を指定
use App\User;

class UsersController extends Controller
{
     public function index()
    {
        //$usersはモデルのインスタンス
        $users = User::paginate(10);

        return view('users.index', [
            'users' => $users,
        ]);
    }
    
     public function show($id)
    {
        
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        
         $data += $this->counts($user);
         
        return view('users.show', $data);
    } 
    
     public function followings($id)
    {
        $user = User::find($id);
         $followings = $user->followings()->paginate(10);
        
       $data = [
                'user' => $user,
                'users' => $followings,
                //'microposts' => $microposts,
            ];
        $data += $this->counts($user);

        return view('users.followings', $data);
    }
    
     public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
    
    public function user_favorite($id)
    {
        $user = User::find($id);
         $user_favorite = $user->user_favorite()->paginate(10);
        
       $data = [
                'user' => $user,
                'microposts' => $user_favorite,
                
            ];
        $data += $this->counts($user);

        return view('users.favorite', $data);    
    }
}