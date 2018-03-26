function ckeditor(name) {
    var editor = CKEDITOR.replace(name, {
        uiColor: '#9AB8F3',
        language: 'vi',
        //baseURL là đường dẫn gốc -> cần tạo biến này ở trang giao diện chung master.blade.php như sau: var baseURL = "{!! url('/') !!}"; và cần phải chỉnh sửa lại đường dẫn trong ckfinder/config.php thành: $baseUrl = 'http://localhost:8080/framework/project1/resources/upload/';
        //filebrowserBrowseUrl: baseURL+'/public/admin/js/ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: baseURL + '/public/admin/js/ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl: baseURL + '/public/admin/js/ckfinder/ckfinder.html?type=Flash',
        //filebrowserUploadUrl: baseURL+'/public/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl: baseURL + '/public/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl: baseURL + '/public/admin/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
        toolbar: [
            ['Source', '-', 'Save', 'NewPage', 'Preview', '-', 'Templates'],
            ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Print', 'SpellChecker', 'Scayt'],
            ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat'],
            ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
            ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript'],
            ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', 'Blockquote', 'CreateDiv'],
            ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
            ['BidiLtr', 'BidiRtl'],
            ['Link', 'Unlink', 'Anchor'],
            ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe'],
            ['Styles', 'Format', 'Font', 'FontSize'],
            ['TextColor', 'BGColor'],
            ['Maximize', 'ShowBlocks', '-', 'About']
        ]
    });
}