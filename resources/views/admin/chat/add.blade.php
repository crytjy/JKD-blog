@extends('admin.layouts.default')
@section('headcss')
    <meta name="csrf-token" content="{{ csrf_token() }}" pageType="add">
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
                        <label for="content" class="col-sm-2 col-form-label">内容</label>
                        <div class="col-sm-10">
                            <textarea id="content" class="form-control ipt" rows="3" name="content" placeholder="内容"></textarea>
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

        indexUrl = "{{ route('chat')}}";
        updateUrl = "{{ route('chat.update')}}";
        storeUrl = "{{ route('chat.store')}}";

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>

    <script src="{{ asset("/js/admin/chat.js") }}"></script>
@stop
