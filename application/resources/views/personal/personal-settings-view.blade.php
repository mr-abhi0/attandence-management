@extends('layouts.personal')

@section('meta')
<title>My Settings | Workday Time Clock</title>
<meta name="description" content="Workday my settings">
@endsection

@section('styles')
<script>
    var admin = false;
</script>
@endsection

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2 class="page-title">{{ __("General Settings") }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="box box-success">
                <div class="box-body">
                    <div class="ui secondary blue pointing tabular menu">
                        <a class="item active" data-tab="about">{{ __("About") }}</a>
                        <a class="item" data-tab="attribution">{{ __("Attributions") }}</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $('.menu .item').tab();
</script>
@endsection