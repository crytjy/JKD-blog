@extends('admin.layouts.default')
@section('headcss')
    <meta name="csrf-token" content="{{ csrf_token() }}" pageType="add">
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap/css/bootstrap-tagsinput.css")}}">
@stop
@section('content')
    <div class="col-md-9 container-fluid">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="page-form-body" class="form-horizontal">
                <div class="card-body">
                    <input type="hidden" class="ipt" id="id" name="id" value="">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 col-form-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control ipt" id="title" name="title" value="" placeholder="名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="title" class="col-sm-2 col-form-label">关键词</label>
                        <div class="col-sm-10" id="keywordsBox"></div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-2 col-form-label">简介</label>
                        <div class="col-sm-10">
                            <textarea id="description" class="form-control ipt" rows="3" name="description" placeholder="简介"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="radio" class="col-sm-2 col-form-label">状态</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label>
                                    <input id='status' data-toggle="topjui-radiobutton" name='status' type="radio" value="0" class="ipt" >
                                    否
                                </label>
                                <label>
                                    <input id='status' data-toggle="topjui-radiobutton" name='status' type="radio" value="1" class="ipt" checked>
                                    是
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="button" class="btn btn-default" id='form-back'>返回</button>
                    <button type="submit" class="btn btn-info float-right" id='form-submit'>提交</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
@stop

@section('bodyjs')
    <script>
        detail = eval({!! $detail !!});
        thisId = detail ? detail['id'] : 0;

        indexUrl = "{{ route('category')}}";
        updateUrl = "{{ route('category.update')}}";
        storeUrl = "{{ route('category.store')}}";

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>

    <script type="text/javascript" src="{{ asset("/bower_components/admin-lte/plugins/bootstrap/js/bootstrap-tagsinput.js")}}"></script>
    <script src="{{ asset("/js/admin/category.js") }}"></script>
@stop
