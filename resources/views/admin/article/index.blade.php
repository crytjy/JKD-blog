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
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_id">分类</label>
                                <input class="easyui-combotree form-control ipts" id="category_id" name="category_id"
                                       data-options="valueField:'id',textField:'title',multiple:false,cls:'form-control',tipPosition:'bottom'"
                                       style="width:100%;">
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
                                    <th data-options="field:'title',width:150">名称</th>
                                    <th data-options="field:'author',width:100">作者</th>
                                    <th data-options="field:'category',formatter:make_category,width:100">分类</th>
                                    <th data-options="field:'tag',width:100,formatter:make_tag">标签</th>
                                    <th data-options="field:'keywords',formatter:make_keywords,width:200">关键词</th>
                                    <th data-options="field:'description',width:300">描述</th>
                                    <th data-options="field:'click',width:50">点击数</th>
                                    <th data-options="field:'is_top',width:50,formatter:make_top,sortable:true">置顶</th>
                                    <th data-options="field:'is_original',width:50,formatter:make_original,sortable:true">原创</th>
                                    <th data-options="field:'status',width:50,formatter:make_status,sortable:true">状态</th>
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
        categoryData = eval({!! $categoryData !!});

        pageQueryUrl = "{{ route('article.pageQuery')}}";
        destroyUrl = "{{ route('article.destroy')}}";
        editUrl = "{{ route('article.edit')}}";

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>

    <script src="{{ asset("/js/admin/article.js") }}"></script>
@stop
