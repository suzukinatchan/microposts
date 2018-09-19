<!--if文によって表示する画面を変えていた！！！ここ重要！！！
ログイン認証済みの場合
'/'にアクセスした後に表示されるwelcomeviewはログイン認証されているので、ログインユーザーの名前・画像・投稿が一つ以上ある
場合は投稿を表示する、というif文になっている

ログイン認証されていない人の場合
welcomeToTheMicropostsの画面を表示する。
-->
@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <aside class="col-xs-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $user->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <img class="media-object img-rounded img-responsive" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                    </div>
                </div>
            </aside>
            <div class="col-xs-8">
                <ul class="nav nav-tabs nav-justified">
                <!--Timeline一覧-->
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}">
                    <!--users/show.blade.php（つまりこのページに）に飛んでrouterを実行する。-->
                    <!--users.showってrouternameのはず？-->
                    <a href="{{ route('users.show', ['id' => $user->id]) }}">
                        TimeLine <span class="badge">{{ $count_microposts }}</span>
                　　</a>
                </li>
                <!-- followings一覧 -->
                <li role="presentation" class="{{ Request::is('users/*/followings') ? 'active' : '' }}">
                   <a href="{{ route('users.followings', ['id' => $user->id]) }}">
                       Followings <span class="badge">{{ $count_followings }}</span></a>
                </li>
                <!--followers一覧-->
                <li role="presentation" class="{{ Request::is('users/*/followers') ? 'active' : '' }}">
                    <a href="{{ route('users.followers', ['id' => $user->id]) }}">
                        Followers <span class="badge">{{ $count_followers }}</span></a>
                </li>
                 <!--favoriteタグ-->
                <li role="presentation" class="{{ Request::is('users/*/user_favorite') ? 'active' : '' }}">
                    <!--route()の中は,viewページの場所ではなくrouternameを指定している-->
                    <a href="{{ route('user_favorite', ['id' => $user->id]) }}">
                        Favorite <span class="badge">{{ $count_user_favorite }}</span></a>
                </li>
            </ul>
            </div>
        </div>
    @else
       <div class="center jumbotron">
        <div class="text-center">
            <h1>Welcome to the Microposts</h1>
             {!! link_to_route('signup.get', 'Sign up now!', null, 
             ['class' => 'btn btn-lg btn-primary']) !!}
        </div>
   　　 </div>
    @endif
@endsection