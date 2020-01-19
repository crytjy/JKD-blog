@extends('admin.layouts.default')
@section('headcss')
    <meta name="csrf-token" content="{{ csrf_token() }}" pageType="add">
    <link rel="stylesheet"
          href="{{ asset("/bower_components/admin-lte/plugins/bootstrap/css/bootstrap-tagsinput.css")}}">
    <link rel="stylesheet"
          href="{{ asset("/bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">

{{--    <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>--}}

@stop
@section('content')

    <form id="page-form-body" class="form-horizontal table">
        <div class="row">
            <div class="col-md-9">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">文章内容</h3>
                    </div>
                    <!-- /.card-header content-->
                    <div class="card-body pad">
                        <div class="mb-12">
                            <textarea name="content" id="content"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">基本信息</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <input type="hidden" class="ipt" id="id" name="id" value="">
                        <div class="form-group">
                            <label for="category_id" class="col-sm-4 col-form-label">分类</label>
                            <div class="col-sm-12">
                                <input class="easyui-combotree form-control ipts" id="category_id" name="category_id"
                                       data-options="valueField:'id',textField:'title',multiple:false,cls:'form-control',tipPosition:'bottom'"
                                       style="width:100%;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-4 col-form-label">名称</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control ipt" id="title" name="title" value=""
                                       placeholder="名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tag" class="col-sm-4 col-form-label">标签</label>
                            <div class="col-sm-12" id="LiTag"></div>
                        </div>
                        <div class="form-group">
                            <label for="keywords" class="col-sm-4 col-form-label">关键词</label>
                            <div class="col-sm-12">
                                <div class=" ipt" id="keywordsBox"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-4 col-form-label">简述</label>
                            <div class="col-sm-12">
                                <textarea id="description" class="form-control ipt" rows="5" name="description"
                                          placeholder="简述"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pic" class="col-sm-4 col-form-label">封面</label>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="btn btn-default btn-file">
                                        <i class="fas fa-paperclip"></i> 选择图片
                                        <input type="file" name="attachment">
                                    </div>
                                    <a href="" target="_blank" class="btn btn-info" id="LiPic" style="display: none;">
                                        <i class="fa fa-file-picture-o"></i> 查看图片
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_top" class="col-sm-4 col-form-label">置顶</label>
                            <div class="col-sm-12">
                                <div class="icheck-success d-inline">
                                    <input type="radio" value="0" name="is_top" id="is_top1" checked>
                                    <label for="is_top1">否</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="icheck-success d-inline">
                                    <input type="radio" value="1" name="is_top" id="is_top2">
                                    <label for="is_top2">是</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_original" class="col-sm-4 col-form-label">原创</label>
                            <div class="col-sm-12">
                                <div class="icheck-success d-inline">
                                    <input type="radio" value="0" name="is_original" id="is_original1" checked>
                                    <label for="is_original1">否</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="icheck-success d-inline">
                                    <input type="radio" value="1" name="is_original" id="is_original2">
                                    <label for="is_original2">是</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-4 col-form-label">状态</label>
                            <div class="col-sm-12">
                                <div class="icheck-success d-inline">
                                    <input type="radio" value="0" name="status" id="status1">
                                    <label for="status1">否</label>
                                </div>&nbsp;&nbsp;&nbsp;
                                <div class="icheck-success d-inline">
                                    <input type="radio" value="1" name="status" id="status2" checked>
                                    <label for="status2">是</label>
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
                </div>
            </div>
            <!-- /.col-->
        </div>
    </form>
@stop

@section('bodyjs')
    <script>
        categoryData = eval({!! $categoryData !!});
        tagData = eval({!! $tagData !!});
        tagValueData = eval({!! $tagValueData !!});
        detail = eval({!! $detail !!});
        thisId = detail ? detail['id'] : 0;

        indexUrl = "{{ route('article')}}";
        updateUrl = "{{ route('article.update')}}";
        storeUrl = "{{ route('article.store')}}";
        uploadEditFileUrl = "{{ route('uploadEditFile')}}";

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    </script>
    <script type="text/javascript" src="{{ asset("/bower_components/admin-lte/plugins/bootstrap/js/bootstrap-tagsinput.js")}}"></script>
    <script type="text/javascript" src="{{ asset("/bower_components/admin-lte/plugins/ckeditor/ckeditor.js")}}"></script>
    <script type="text/javascript" src="{{ asset("/js/common/upload.js")}}"></script>
    <script src="{{ asset("/js/admin/article.js") }}"></script>
@stop
