function GetSostavBuketa(id)
{
    console.info(id);

    $.get(
        "mainL.php",
        {
            //log1:1,
            action:"product_photo",
            id:id

        },
        function (data) {
            $(".product_photo").html(data);
        },"html"
    ); //$.get  END

    $.get(
        "mainL.php",
        {
            //log1:1,
            action:"sostav_info",
            id:id
        },
        function (data) {
            $(".sostav_info").html(data);
        },"html"
    ); //$.get  END


}



//добавление в корзину
function AddToCard(product_id,product_count)
{
    console.info("AddToCard="+product_id);
    $.get(
        "mainL.php",
        {
            //log1:1,
            action:"AddToCard",
            product_id:product_id,
            product_count:product_count
        },
        function (data) {
           console.info(data);
            if(data.status=="1")
            {

                $(".product_"+product_id).css("background-position","100% -22px");
            }
            else
            {
                $(".product_"+product_id).css("background-position","");

            }

            var card='';

            //<img src="\\img\\card.jpg" class="img-responsive" style="float:left">

            if(parseInt(data.count)>0)
            {
              //  $(".top2_cart").html("<span>"+String(data.count)+"</span>");
              //  $('.modalThx').modal('show');
              //  card = card +'<p><b>Корзина</b> <br>'+String(data.count)+' '+ String(data.text1)+' <br>'+ String(data.summa)+' рублей</p></div>';
              //  setTimeout(function() { $('.modalThx').modal('hide'); }, 1000);
                 card='<div class="card-img">' +
                    ' <div class="card-label">'+String(data.count)+'</div>' +
                    '</div>' +
                    '<div class="card-info">' +
                    '<div class="card-text-1"><a class="card-link" href="/usercard.html">Моя корзина</a></div>' +
                     '<div class="card-info-2">'+String(data.count)+' '+ String(data.text1)+'</div>' +
                    '<div class="card-info-2">' + String(data.summa)+' рублей</div>' +
                    '</div>';
            }
            else
            {
                card='<div class="card-img">' +
                    ' <div class="card-label"></div>' +
                    '</div>' +
                    '<div class="card-info">' +
                    '<div class="card-text-1"><a class="card-link" href="/usercard.html">Моя корзина</a></div>' +
                    '<div class="card-info-2">'+ String(data.text1)+'</div>' +
                    '<div class="card-info-2">'+ String(data.text1)+' <br>'+ String(data.summa)+' рублей</div>' +
                    '</div>'
                   ;
            }
            $(".card-top").html(card)

        },"json"
    ); //$.get  END

}

//Удаление продукта из корзины
function CardProductDelete(product_id)
{
    console.info("AddToCard="+product_id);
    $.get(
        "mainL.php",
        {
            //log1:1,
            action:"CardProductDelete",
            product_id:product_id

        },
        function (data) {
            console.info(data);
            if(data.status=="1")
            {
                location.reload();
            }

        },"json"
    ); //$.get  END

}




function CardProductChangeCount(product_id)
{
    console.info($("#product_count_"+product_id).val());
    setTimeout( $.get(
        "mainL.php",
        {
            //log1:1,
            action:"CardProductChangeCount",
            product_id:product_id,
            product_count:$("#product_count_"+product_id).val()

        },
        function (data) {
            console.info(data);
            if(data.status=="1")
            {
                location.reload();
            }
            else $("#product_count_"+product_id).val(1);

        },"json"
    ), 3000);


}


function CardCouponChange()
{
    var coupon_code=$(".coupon_code").val();
    $.get(
        "mainL.php",
        {
            //log1:1,
            action:"CardCouponChange",
            coupon_code:coupon_code


        },
        function (data) {
            console.info(data);
            if(data.status=="1")
            {
                location.reload();
            }
            else $(".coupon_code").val('');

        },"json"
    );
}


//Проверяем капчу и создаем заказ
function OrderSubmit()
{
    $(".OrderCommitBtn").prop("disabled",true);

    var ca=$("input[name=ca]").val();
    var user_fio=$("input[name=user_fio]").val();
    var user_phone=$("input[name=user_phone]").val();
    var user_email=$("input[name=user_email]").val();

    var receiver_photo=$("input[name=receiver_photo]").prop("checked");
    var receiver_free_photo=$("input[name=receiver_free_photo]").prop("checked");


    var dopinfo=$("textarea[name=dopinfo]").val();
    var receiver_domofon_code=$("input[name=receiver_domofon_code]").val();
    var receiver_kvartira=$("input[name=receiver_kvartira]").val();
    var receiver_etaj=$("input[name=receiver_etaj]").val();
    var receiver_podezd=$("input[name=receiver_podezd]").val();
    var receiver_corpus=$("input[name=receiver_corpus]").val();
    var receiver_house=$("input[name=receiver_house]").val();
    var receiver_street=$("input[name=receiver_street]").val();
    var receiver_sity=$("input[name=receiver_sity]").val();
    var receiver_phone=$("input[name=receiver_phone]").val();

    var receiver_call=$("input[name=receiver_call]").prop("checked");
    var user_remind_flag=$("input[name=user_remind_flag]").prop("checked");


    var delivery_date=$("input[name=delivery_date]").val();



    $.get(
        "mainL.php",
        {
            //log1:1,
            action:"IsCa",
            ca:ca,
            user_fio:user_fio,
            user_phone:user_phone,
            user_email:user_email,
            receiver_photo:receiver_photo,
            receiver_free_photo:receiver_free_photo,
            dopinfo:dopinfo,
            receiver_domofon_code:receiver_domofon_code,
            receiver_kvartira:receiver_kvartira,
            receiver_etaj:receiver_etaj,
            receiver_podezd:receiver_podezd,
            receiver_corpus:receiver_corpus,
            receiver_house:receiver_house,
            receiver_street:receiver_street,
            receiver_sity:receiver_sity,
            receiver_phone:receiver_phone,
            receiver_call:receiver_call,
            user_remind_flag:user_remind_flag,
            delivery_date:delivery_date




        },
        function (data) {
            console.info(data);
            if(data.status=="1")
            {
                //$("#OrderForm").submit();
                ///ordercommit.html?qq=' . $url
                window.location.replace("ordercommit.html?qq="+data.url);

            }
            else
            {
                alert(data.status_text);
                $(".OrderCommitBtn").prop("disabled",false);
            }


        },"json"
    );

}

function GetReceiver(id)
{
    $.get(
        "mainL.php",
        {
            //log1:1,
            action:"GetReceiver",
            receiver_id:id

        },
        function (data) {
           $("#receiver_data").html(data);

        },"html"
    );
}


$(document).ready(function(){
    $('.buket').hover(
  function() {
      $(this).children().addClass("hoverGreen");
    
  }, function() {
     $(this).children().removeClass("hoverGreen");
    
  }
);
    setInterval(function()
{

    $('#vk_comments').css('width','100%');
    $( "#vk_comments" ).parent().css( 'width','100%');
    $('#vk_comments').css('width','100%');
    $('iframe').css('width','100%');


    
}, 3000);

    setTimeout(function()
    {
        $('.fb-tab').hide();
     

    }, 3000);
  
});