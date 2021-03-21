$(function ($) {
  "use strict";

  /* ***************************************************************
  ==========disabling default behave of form submits start==========
  *****************************************************************/
  $("#ajaxEditForm").attr('onsubmit', 'return false');
  $("#ajaxForm").attr('onsubmit', 'return false');
  /* *************************************************************
  ==========disabling default behave of form submits end==========
  ***************************************************************/



  /* ***************************************************
  ==========bootstrap datepicker start==========
  ******************************************************/
  $('.datepicker').datepicker({
    autoclose: true
  });
  /* ***************************************************
  ==========bootstrap datepicker end==========
  ******************************************************/



  /* ***************************************************
  ==========dm uploader single file upload start==========
  ******************************************************/

  function ui_single_update_active(element, active) {
    element.find('div.progress').toggleClass('d-none', !active);
    element.find('.progressbar').toggleClass('d-none', active);

    element.find('input[type="file"]').prop('disabled', active);
    element.find('.btn').toggleClass('disabled', active);

    element.find('.btn i').toggleClass('fa-circle-o-notch fa-spin', active);
    element.find('.btn i').toggleClass('fa-folder-o', !active);
  }

  function ui_single_update_progress(element, percent, active) {
    active = (typeof active === 'undefined' ? true : active);

    var bar = element.find('div.progress-bar');

    bar.width(percent + '%').attr('aria-valuenow', percent);
    bar.toggleClass('progress-bar-striped progress-bar-animated', active);

    if (percent === 0) {
      bar.html('');
    } else {
      bar.html(percent + '%');
    }
  }

  function ui_single_update_status(element, message, color) {
    color = (typeof color === 'undefined' ? 'muted' : color);

    element.find('small.status').prop('class', 'status text-' + color).html(message);
  }



    $('.drag-and-drop-zone').each(function(i) {
      let $this = $(this);
      $this.dmUploader({ //
          url: $this.attr('action'),
          multiple: false,
          allowedTypes: 'image/*',
          extFilter: ['jpg', 'jpeg', 'png'],
          onDragEnter: function() {
              // Happens when dragging something over the DnD area
              this.addClass('active');
          },
          onDragLeave: function() {
              // Happens when dragging something OUT of the DnD area
              this.removeClass('active');
          },
          onInit: function() {
              // Plugin is ready to use

              this.find('.progressbar').val('');
          },
          onComplete: function() {
              // All files in the queue are processed (success or error)
          },
          onNewFile: function(id, file) {
              // When a new file is added using the file selector or the DnD area

              if (typeof FileReader !== "undefined") {
                  var reader = new FileReader();
                  var img = this.find('img');

                  reader.onload = function(e) {
                      img.attr('src', e.target.result);
                  }
                  reader.readAsDataURL(file);
              }
          },
          onBeforeUpload: function(id) {
              // about tho start uploading a file
              ui_single_update_progress(this, 0, true);
              ui_single_update_active(this, true);

              ui_single_update_status(this, 'Uploading...');
          },
          onUploadProgress: function(id, percent) {
              // Updating file progress
              ui_single_update_progress(this, percent);
          },
          onUploadSuccess: function(id, data) {
              var response = JSON.stringify(data);

              let ems = document.getElementsByClassName('em');
              for (let i = 0; i < ems.length; i++) {
                ems[i].innerHTML = '';
              }

              // A file was successfully uploaded
              // console.log(data);


              // if only the image is being stored
              if (data.status == "success") {
                // console.log(data.method);
                
                bootnotify(data.image + " added successfully!", 'Success!', 'success');
                ui_single_update_active(this, false);
                // You should probably do something with the response data, we just show it
                this.find('.progressbar').val("Uploaded successfully");
                this.find('.form-control[readonly]').attr('style', 'background-color: #28a745 !important; text-alignment: center !important; opacity: 1 !important;border: none !important;');
                ui_single_update_status(this, 'Upload completed.', 'success');
              }


              // if the image is being stored along with other form fields
              else if (data.status == "session_put") {
                
                $("#image").attr('name', data.image);
                $("#image").val(data.filename);
                ui_single_update_active(this, false);
                
                // You should probably do something with the response data, we just show it
                this.find('.progressbar').val("Uploaded successfully");
                this.find('.form-control[readonly]').attr('style', 'background-color: #28a745 !important; text-alignment: center !important; opacity: 1 !important;border: none !important;');
                ui_single_update_status(this, 'Upload completed.', 'success');
              }

              // if you need a reload after image store
              else if (data.status == "reload") {
                ui_single_update_active(this, false);
                // You should probably do something with the response data, we just show it
                this.find('.progressbar').val("Uploaded successfully");
                this.find('.form-control[readonly]').attr('style', 'background-color: #28a745 !important; text-alignment: center !important; opacity: 1 !important;border: none !important;');
                ui_single_update_status(this, 'Upload completed.', 'success');
                location.reload();
              }

              // if error is returned while storing image
              else if(typeof data.errors.error != 'undefined') {
                if (typeof data.errors.file != 'undefined') {
                  document.getElementById('err'+data.id).innerHTML = data.errors.file[0];
                }
              }
          },
          onUploadError: function(id, xhr, status, message) {
              // Happens when an upload error happens
              ui_single_update_active(this, false);
              ui_single_update_status(this, 'Error: ' + message, 'danger');
          },
          onFallbackMode: function() {
              // When the browser doesn't support this plugin :(
          },
          onFileSizeError: function(file) {
              ui_single_update_status(this, 'File excess the size limit', 'danger');

          },
          onFileTypeError: function(file) {
              ui_single_update_status(this, 'File type is not an image', 'danger');

          },
          onFileExtError: function(file) {
              ui_single_update_status(this, 'File extension not allowed', 'danger');

          }
      });
    })

    /* ***************************************************
    ==========dm uploader single file upload end==========
    ******************************************************/


    /* ***************************************************
    ==========fontawesome icon picker start==========
    ******************************************************/
    $('.icp-dd').iconpicker();
    /* ***************************************************
    ==========fontawesome icon picker upload end==========
    ******************************************************/


    /* ***************************************************
    ==========Summernote initialization start==========
    ******************************************************/
   $(".summernote").each(function(i) {
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


    
  $(document).on('click',".note-video-btn", function() {
    console.log('clicked');
    
    let i = $(this).index();

    if ($(".summernote").eq(i).parents(".modal").length > 0) {
      console.log("in modal");
      
      setTimeout(() => {
        $("body").addClass('modal-open');
      }, 500);
    }
  });


  /* ***************************************************
  ==========Summernote initialization end==========
  ******************************************************/


  /* ***************************************************
  ==========Bootstrap Notify start==========
  ******************************************************/
  function bootnotify(message, title, type) {
    var content = {};

    content.message = message;
    content.title = title;
    content.icon = 'fa fa-bell';

    $.notify(content, {
      type: type,
      placement: {
        from: 'top',
        align: 'right'
      },
      showProgressbar: true,
      time: 1000,
      allow_dismiss: true,
      delay: 4000,
    });
  }
  /* ***************************************************
  ==========Bootstrap Notify end==========
  ******************************************************/



  /* ***************************************************
  ==========Form Submit with AJAX Request Start==========
  ******************************************************/
  $("#submitBtn").on('click', function (e) {
    $(e.target).attr('disabled', true);

    $(".request-loader").addClass("show");

    let ajaxForm = document.getElementById('ajaxForm');
    let fd = new FormData(ajaxForm);
    let url = $("#ajaxForm").attr('action');
    let method = $("#ajaxForm").attr('method');
    // console.log(url);
    // console.log(method);

    if ($("#ajaxForm .summernote").length > 0) {
      $("#ajaxForm .summernote").each(function (i) {
        let content = $(this).summernote('code');

        fd.delete($(this).attr('name'));
        fd.append($(this).attr('name'), content);
      });
    }

    $.ajax({
      url: url,
      method: method,
      data: fd,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);

        $(e.target).attr('disabled', false);
        $(".request-loader").removeClass("show");

        $(".em").each(function () {
          $(this).html('');
        })

        if (data == "success") {
          location.reload();
        }

        // if error occurs
        else if (typeof data.error != 'undefined') {
          for (let x in data) {
            // console.log(x);
            if (x == 'error') {
              continue;
            }
            document.getElementById('err' + x).innerHTML = data[x][0];
          }
        }
      }
    });
  });
  /* ***************************************************
  ==========Form Submit with AJAX Request End==========
  ******************************************************/




  /* ***************************************************
  ==========Form Prepopulate After Clicking Edit Button Start==========
  ******************************************************/
  $(".editbtn").on('click', function () {

    let datas = $(this).data();
    delete datas['toggle'];

    for (let x in datas) {
      if ($("#in" + x).hasClass('summernote')) {
        $("#in" + x).summernote('code', datas[x]);
      } else if ($("#in" + x).data('role') == 'tagsinput') {
        if (datas[x].length > 0) {
          let arr = datas[x].split(" ");
          for (let i = 0; i < arr.length; i++) {
            $("#in" + x).tagsinput('add', arr[i]);
          }
        } else {
          $("#in" + x).tagsinput('removeAll');
        }
      }
      else if ($("input[name='" + x + "']").attr('type') == 'radio') {
        $("input[name='" + x + "']").each(function (i) {
          if ($(this).val() == datas[x]) {
            $(this).prop('checked', true);
          }
        });
      }
      else {
        $("#in" + x).val(datas[x]);
      }
    }


      // focus & blur colorpicker inputs
      setTimeout(() => {
        $(".jscolor").each(function() {
          $(this).focus();
          $(this).blur();
        });        
      }, 300);

    });


  /* ***************************************************
  ==========Form Prepopulate After Clicking Edit Button End==========
  ******************************************************/




  /* ***************************************************
  ==========Form Update with AJAX Request Start==========
  ******************************************************/
  $("#updateBtn").on('click', function (e) {

    $(".request-loader").addClass("show");

    let ajaxEditForm = document.getElementById('ajaxEditForm');
    let fd = new FormData(ajaxEditForm);
    let url = $("#ajaxEditForm").attr('action');
    let method = $("#ajaxEditForm").attr('method');
    // console.log(url);
    // console.log(method);

    if ($("#ajaxEditForm .summernote").length > 0) {
      $("#ajaxEditForm .summernote").each(function (i) {
        let content = $(this).summernote('code');
        fd.delete($(this).attr('name'));
        fd.append($(this).attr('name'), content);
      })
    }

    $.ajax({
      url: url,
      method: method,
      data: fd,
      contentType: false,
      processData: false,
      success: function (data) {
        // console.log(data);

        $(".request-loader").removeClass("show");

        $(".em").each(function () {
          $(this).html('');
        })

        if (data == "success") {
          location.reload();
        }

        // if error occurs
        else if (typeof data.error != 'undefined') {
          for (let x in data) {
            console.log(x);
            if (x == 'error') {
              continue;
            }
            document.getElementById('eerr' + x).innerHTML = data[x][0];
          }
        }
      }
    });
  });
  /* ***************************************************
  ==========Form Update with AJAX Request End==========
  ******************************************************/



  /* ***************************************************
  ==========Delete Using AJAX Request Start==========
  ******************************************************/
  $('.deletebtn').on('click', function (e) {
    e.preventDefault();

    $(".request-loader").addClass("show");

    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      buttons: {
        confirm: {
          text: 'Yes, delete it!',
          className: 'btn btn-success'
        },
        cancel: {
          visible: true,
          className: 'btn btn-danger'
        }
      }
    }).then((Delete) => {
      if (Delete) {
        $(this).parent(".deleteform").submit();
      } else {
        swal.close();
        $(".request-loader").removeClass("show");
      }
    });
  });
  /* ***************************************************
  ==========Delete Using AJAX Request End==========
  ******************************************************/


  /* ***************************************************
  ==========Close Ticket Using AJAX Request Start==========
  ******************************************************/
  $('.close-ticket').on('click', function (e) {
    e.preventDefault();

    $(".request-loader").addClass("show");

    swal({
      title: 'Are you sure?',
      text: "You want to close this ticket!",
      type: 'warning',
      buttons: {
        confirm: {
          text: 'Yes, close it!',
          className: 'btn btn-success'
        },
        cancel: {
          visible: true,
          className: 'btn btn-danger'
        }
      }
    }).then((Delete) => {
      if (Delete) {
        swal.close();
        $(".request-loader").removeClass("show");
      } else {
        swal.close();
        $(".request-loader").removeClass("show");
      }
    });
  });
  /* ***************************************************
  ==========Delete Using AJAX Request End==========
  ******************************************************/


  /* ***************************************************
  ==========Delete Using AJAX Request Start==========
  ******************************************************/
  $(".bulk-check").on('change', function () {
    let val = $(this).data('val');
    let checked = $(this).prop('checked');

    // if selected checkbox is 'all' then check all the checkboxes
    if (val == 'all') {
      if (checked) {
        $(".bulk-check").each(function () {
          $(this).prop('checked', true);
        });
      } else {
        $(".bulk-check").each(function () {
          $(this).prop('checked', false);
        });
      }
    }


    // if any checkbox is checked then flag = 1, otherwise flag = 0
    let flag = 0;
    $(".bulk-check").each(function () {
      let status = $(this).prop('checked');

      if (status) {
        flag = 1;
      }
    });

    // if any checkbox is checked then show the delete button
    if (flag == 1) {
      $(".bulk-delete").addClass('d-inline-block');
      $(".bulk-delete").removeClass('d-none');
    }
    // if no checkbox is checked then hide the delete button
    else {
      $(".bulk-delete").removeClass('d-inline-block');
      $(".bulk-delete").addClass('d-none');
    }
  });

  $('.bulk-delete').on('click', function () {

    swal({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      buttons: {
        confirm: {
          text: 'Yes, delete it!',
          className: 'btn btn-success'
        },
        cancel: {
          visible: true,
          className: 'btn btn-danger'
        }
      }
    }).then((Delete) => {
      if (Delete) {
        $(".request-loader").addClass('show');
        let href = $(this).data('href');
        let ids = [];

        // take ids of checked one's
        $(".bulk-check:checked").each(function () {
          if ($(this).data('val') != 'all') {
            ids.push($(this).data('val'));
          }
        });

        let fd = new FormData();
        for (let i = 0; i < ids.length; i++) {
          fd.append('ids[]', ids[i]);
        }

        $.ajax({
          url: href,
          method: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function (data) {
            // console.log(data);

            $(".request-loader").removeClass('show');
            if (data == "success") {
              location.reload();
            }
          }
        });
      } else {
        swal.close();
      }
    });

  });
  /* ***************************************************
  ==========Delete Using AJAX Request End==========
  ******************************************************/
});
