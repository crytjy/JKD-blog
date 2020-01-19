@extends('admin.layouts.default')
@section('headcss')
    <meta name="csrf-token" content="{{ csrf_token() }}" pageType="index">
@stop
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">检索</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- /.检索 -->
                    <form id="search-form">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">名称</label>
                                <input type="text" class="form-control ipts" id="title" name="title" placeholder="内容">
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="reset" class="btn btn-default col-xs-4" id="reset-search">重置</button>
                            <button type="submit" class="btn btn-primary pull-right col-xs-4">搜索</button>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="box-body" id="dgwrap">
                        <table id="dg" style="min-height:200px;" class="easyui-datagrid"
                               data-options="rownumbers:true,singleSelect:true,collapsible:true,pagination: true,pageSize: 20,pageList: [20,30,60],showFooter: true"
                               toolbar="#toolbar">
                            <thead>
                                <tr>
                                    <th data-options="field:'title',width:300">名称</th>
                                    <th data-options="field:'status',width:100,formatter:make_status,sortable:true">状态</th>
                                    <th data-options="field:'created_at',width:200,sortable:true">创建时间</th>
                                </tr>
                            </thead>
                        </table>
                        <div id="toolbar">
                            <div class="btn-group lefttoolbar">
                                <button type="button" class="btn btn-danger btn-sm" id="dgadd"><i class="fa fa-file-o"></i> 添加</button>
                                <button type="button" class="btn btn-danger btn-sm disabled" id="dgedit"><i class="fa fa-edit"></i> 修改</button>
                                <button type="button" class="btn btn-danger btn-sm disabled" id="dgdel"><i class="fa fa-trash-o"></i> 删除</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
@stop

@section('bodyjs')
    <script>
        pageQueryUrl = "{{ route('tag.pageQuery')}}";
        destroyUrl = "{{ route('tag.destroy')}}";
        editUrl = "{{ route('tag.edit')}}";

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>

    <script src="{{ asset("/js/admin/tag.js") }}"></script>
@stop