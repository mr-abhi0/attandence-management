@extends('layouts/app')

@section('content')
<div class="profile-header" @if($user->profile_banner_url != '') style="background-image: url('{{ route('profile/banner', ['profile_banner_url' => $user->profile_banner_url]) }}');" @endif>
    <div class="profile-header-wrapper">
        <div class="container">
            @if($user->profile_image_url != '')
            <img class="img-thumbnail img-responsive center-block" width="180" src="{{ route('profile/image', ['profile_image_url' => $user->profile_image_url]) }}">
            @endif
            <h1>{{ $user->name }}</h1>
            <h2>@ {{ $user->username }}</h2>
        </div>
    </div>
</div>
@endsection