<!--userのうち、ある一人のマイページ。-->
@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-xs-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $user->name }}</h3>
                </div>
                <div class="panel-body">
                <img class="media-object img-rounded img-responsive" 
                src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
            <!--フォローアンフォローボタンを設置した -->
            @include('user_follow.follow_button', ['user' => $user])
        </aside>
        <div class="col-xs-8">
            <ul class="nav nav-tabs nav-justified">
                <!--Timeline一覧-->
                <li role="presentation" class="{{ Request::is('users/' . $user->id) ? 'active' : '' }}">
                    <!--users/show.blade.php（つまりこのページに）に飛んでrouterを実行する。-->
                    <!--users.showはrouternameである。
                    resourceで定義されていて、routernameも勝手に定義されるようになってる！-->
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
            @if (Auth::id() == $user->id)
                  {!! Form::open(['route' => 'microposts.store']) !!}
                      <div class="form-group">
                          {!! Form::textarea('content', old('content'), ['class' => 'form-control', 'rows' => '2']) !!}
                          {!! Form::submit('Post', ['class' => 'btn btn-primary btn-block']) !!}
                      </div>
                  {!! Form::close() !!}
            @endif
            @if (count($microposts) > 0)
                @include('microposts.microposts', ['microposts' => $microposts])
            @endif
        </div>
    </div>
@endsection