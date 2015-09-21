
function UploadFile(targertUI)
{

    var kk=1000;
    //---------------------------------------------------------------
    //---------------------------------------------------------------
    var url = 'http://ohapka63.ru/ProductAdmin/ServerUpload/',


        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('В процессе...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Отменить')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload'+targertUI).fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {

            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>');
                    //.append($('<span/>').text(file.name));
                var pricen=$("#MyImages").val();
                if (!index) {

                    var mImg=$('input[name=MainImg_'+pricen+']').val();
                    var mStyle='style="background-position: 0 -22px"';
                    console.info(mImg);
                    if(mImg==0)
                    {
                        $('input[name=MainImg_'+pricen+']').val(1);
                        mImg=1;

                    }
                    else
                    {
                        mStyle='';

                    }
                    node
.append('<br>')
.append('<div class="product_delete" onclick="MyImgDelete('+kk+')"></div>')
.append(' <div '+mStyle+' id="c_main_'+pricen+'_'+kk+'" class="mainimg_row_'+pricen+' product_choose_main" onclick="SetMainImg('+pricen+','+kk+')"></div>')

.append(' <input type="hidden" name="mainimg_'+pricen+"_"+kk+'" class="mainimg_'+pricen+"_"+kk+' mainimg_row_'+pricen+' img_'+kk+'"  value="'+mImg+'"> ')

.append('<input type="hidden" name="img_'+pricen+"_"+kk+'" class="img_'+kk+'"  value="'+file.name+'"> '+file.name);
                    kk=kk+1;
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {

                    //скрыте картинок по прайсу
                    var pricen=$("#MyImages").val();
                    var link = $('<div class="img_dop MyImg MyImg_'+pricen+'">');
                    //    .attr('target', '_blank');
                      //  .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                    $('#'+targertUI).val( file.url);

                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
    //---------------------------------------------------------------
    //---------------------------------------------------------------




}


function Images(id)
{

    //картинки
    $("#MyImages").val(id);
    console.info(id);
    $(".MyImages").show();

    $(".MyImg").hide();
    $(".MyImg_"+id).show("slow");

    //Состав
    $(".admin_product_sostav").show();
    $(".sostav_row").hide();
    $(".sostav_"+id).show("slow");


}

function MyImgDelete(id)
{
    $( ".img_"+id).parent().parent().parent().remove();
}


function SetMainImg(price_id,img_id)
{
    //Меняем вид кнопки на серый
    $(".mainimg_row_"+price_id).css('background-position','0 0px');

    $("#c_main_"+price_id+"_"+img_id).css('background-position','0 -22px');
    //product_choose_main


    $('.mainimg_row_'+price_id).val(0);
    $('.mainimg_'+price_id+"_"+img_id).val(1);




    console.info("MainImg="+$( ".img_"+img_id).val());
    var pricen=$("#MyImages").val();

    $( ".MainImg_"+pricen).val( $( ".img_"+img_id).val());

}


function UploadImageFlower(targertUI)
{

    var kk=1;
    //---------------------------------------------------------------
    //---------------------------------------------------------------
    var url = 'http://ohapka63.ru/ProductAdmin/ServerUpload/',


        uploadButton = $('<button/>')
            .addClass('btn btn-primary')
            .prop('disabled', true)
            .text('В процессе...')
            .on('click', function () {
                var $this = $(this),
                    data = $this.data();
                $this
                    .off('click')
                    .text('Отменить')
                    .on('click', function () {
                        $this.remove();
                        data.abort();
                    });
                data.submit().always(function () {
                    $this.remove();
                });
            });
    $('#fileupload'+targertUI).fileupload({
        url: url,
        dataType: 'json',
        autoUpload: true,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploadadd', function (e, data) {

            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>');
                //.append($('<span/>').text(file.name));
                var pricen=$("#MyImages").val();
                if (!index) {
                    node
                        .append('<br>')
                        .append('<div class="product_delete" onclick="MyImgDelete('+kk+')"></div>')
                        .append(' <div class="product_choose_main" onclick="SetMainImg('+kk+')"></div>')

                        .append('<input type="hidden" name="img_'+pricen+"_"+kk+'" class="img_'+kk+'"  value="'+file.name+'"> ');
                    kk=kk+1;
                }
                node.appendTo(data.context);
            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {

                    //скрыте картинок по прайсу
                    var pricen=$("#MyImages").val();
                    var link = $('<div class="img_dop MyImg MyImg_'+pricen+'">');
                    //    .attr('target', '_blank');
                    //  .prop('href', file.url);
                    $(data.context.children()[index])
                        .wrap(link);
                    $('#'+targertUI).val( file.url);

                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
    //---------------------------------------------------------------
    //---------------------------------------------------------------




}

//*********************
//  - Products -

function ChangeBuketList(id)
{

}


function ProductDelete(id)
{
    $('#ModalDeleteProduct').modal('show');
    $(".ProductDeleteCommit").attr('f_id',id);
}

function ProductDeleteCommit(id)
{
    console.info('delete '+id);
    $.post(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"ProductsDelete"
            ,product_id:id

        },
        function (data) {
            $('#ModalDeleteProduct').modal('hide');
            // location.reload();
            console.info(data);
            $( "#product_row_add_"+id ).remove();
            $( "#product_row_"+id ).remove();

        },"html"
    ); //$.post  END
}


function ProductDeleteCommitEdit(id)
{
    console.info('delete '+id);
    $.post(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"ProductsDelete"
            ,product_id:id

        },
        function (data) {
            $('#ModalDeleteProduct').modal('hide');
            // location.reload();
            console.info(data);
            window.location.replace("/ProductAdmin/?action=CategoryShow");

        },"html"
    ); //$.post  END
}

//Sezons
//edit
function SezonUpdate(id)
{
    console.info("update");
   // var f_id=$(this).attr("f_id");
    var title=$("#title_update").val();
    $('#ModalEdit').modal('hide');
    $.post(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"SezonsUpdate"
            ,f_id:id
            ,title:title

        },
        function (data) {

            //   $('.edit_content').html(data);
            console.info(data);
            location.reload();

        },"html"
    ); //$.post  END
}


function GetProductSezonList(product_id)
{
    $.get(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"GetProductSezonList"
            ,product_id:product_id

        },
        function (data) {
            $('.sezon').html(data);

        },"html"
    ); //$.get  END
}


function GetProductStylesList(product_id)
{
    $.get(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"GetProductStylesList"
            ,product_id:product_id

        },
        function (data) {
            $('.b_styles').html(data);

        },"html"
    ); //$.get  END
}


function GetProductGammasList(product_id)
{
    $.get(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"GetProductGammasList"
            ,product_id:product_id

        },
        function (data) {
            $('.b_gammas').html(data);

        },"html"
    ); //$.get  END
}
function GetProductSizesList(product_id)
{
    $.get(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"GetProductSizesList"
            ,product_id:product_id

        },
        function (data) {
            $('.b_sizes').html(data);

        },"html"
    ); //$.get  END
}


//Добавление ссезона в форму ред/изм товара
function ProductSeazonAdd()
{
    $('#ModalAddSeazon').modal('show');
}

function ProductSeazonSave(id)
{
    var title=$("#seazon_modal_title").val();
    console.info(title);

    $.post(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"SezonsSave"
            ,title:title

        },
        function (data) {
            $('#ModalAddSeazon').modal('hide');
            GetProductSezonList(id);

        },"html"
    ); //$.post  END
}



//Добавление гаммы в форму ред/изм товара
function ProductGammaAdd()
{
    $('#ModalAddGamma').modal('show');
}

function ProductGammaSave(id)
{
    var title=$("#gamma_modal_title").val();
    console.info(title);

    $.post(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"GammasSave"
            ,title:title

        },
        function (data) {
            $('#ModalAddGamma').modal('hide');
            GetProductGammasList(id);

        },"html"
    ); //$.post  END
}


//Добавление стиль в форму ред/изм товара
function ProductStyleAdd()
{
    $('#ModalAddStyle').modal('show');
}

function ProductStyleSave(id)
{
    var title=$("#style_modal_title").val();
    console.info(title);

    $.post(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"StylesSave"
            ,title:title

        },
        function (data) {
            $('#ModalAddStyle').modal('hide');
            GetProductStylesList(id);

        },"html"
    ); //$.post  END
}


//Добавление стиль в форму ред/изм товара
function ProductSizesAdd()
{
    $('#ModalAddSizes').modal('show');
}

function ProductSizesSave(id)
{
    var title=$("#Sizes_modal_title").val();
    console.info(title);

    $.post(
        "/ProductAdmin/ajax.php",
        {
            //log1:1,
            action:"SizesSave"
            ,title:title

        },
        function (data) {
            $('#ModalAddSizes').modal('hide');
            GetProductSizesList(id);

        },"html"
    ); //$.post  END
}

