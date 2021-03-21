(function ($) {
    "use strict";



    jQuery(document).ready(function ($) {

        /* ***************************************************
        ==========Summernote initialization start==========
        ******************************************************/
        $(".summernote").each(function (i) {
            let theight;
            let $summernote = $(this);
            if ($(this).data('height')) {
                theight = $(this).data('height');
            } else {
                theight = 200;
            }
            $('.summernote').eq(i).summernote({
                height: theight,
                dialogsInBody: true,
                dialogsFade: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['height', ['height']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                },             
                callbacks: {
                  onImageUpload: function(files) {
                    // console.log(files);
                    $(".request-loader").addClass('show');
          
                    let fd = new FormData();
                    fd.append('image', files[0]);
          
                    $.ajax({
                      url: imgupload,
                      method: 'POST',
                      data: fd,
                      contentType: false,
                      processData: false,
                      success: function(data) {
                        // console.log(data);
                        $summernote.summernote('insertImage', data);
                        $(".request-loader").removeClass('show');
                      }
                    });
                    
                  }
                }
            });
        });

    });




}(jQuery));