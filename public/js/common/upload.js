class UploadAdapter {
    constructor(loader) {
        this.loader = loader;
    }
    upload() {
        return new Promise((resolve, reject) => {
            const data = new FormData();
            data.append('upload', this.loader._reader._data);
            data.append('allowSize', 10);//允许图片上传的大小/兆
            $.ajax({
                url: uploadEditFileUrl,
                type: 'POST',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.url) {
                        resolve({
                            default: data.url
                        });
                    } else {
                        reject(data.msg);
                    }
                }
            });
        });
    }
    abort() {}
}


var myEditor = null;
ClassicEditor
    .create( document.querySelector( '#content' ), {
        language:"zh-cn"
    })
    .then( editor => {
        // 这个地方加载了适配器
        editor.plugins.get('FileRepository').createUploadAdapter = (loader)=>{
            return new UploadAdapter(loader);
        };

        myEditor = editor;
    } )
    .catch( error => {
        console.error( error );
    } );
