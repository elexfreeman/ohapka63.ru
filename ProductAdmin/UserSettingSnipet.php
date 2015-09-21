<?php
$profile = $modx->user->getOne('Profile');
$fields = $profile->get('extended');





if((isset($_GET['action']))and($_GET['action']=='UserSettingsChange'))
{
    $profile->set('fullname', mysql_escape_string($_GET['fullname']));
    $profile->set('phone', mysql_escape_string($_GET['phone']));
    $profile->set('email', mysql_escape_string($_GET['email']));
    $profile->set('city', mysql_escape_string($_GET['city']));
    $profile->set('city', mysql_escape_string($_GET['city']));
    $profile->set('dob', mysql_escape_string($_GET['dob']));

    $fields['cardN'] =  mysql_escape_string($_GET['cardN']);


    if(isset($_GET['sms_ofrm']))
    {
        $fields['sms_ofrm'] =  1;
    }
    else
    {
        $fields['sms_ofrm'] =  0;
    }

    if(isset($_GET['sms_status']))
    {
        $fields['sms_status'] =  1;
    }
    else
    {
        $fields['sms_status'] =  0;
    }

    if(isset($_GET['sms_akc']))
    {
        $fields['sms_akc'] =  1;
    }
    else
    {
        $fields['sms_akc'] =  0;
    }

    if(isset($_GET['email_ofrm']))
    {
        $fields['email_ofrm'] =  1;
    }
    else
    {
        $fields['email_ofrm'] =  0;
    }

    if(isset($_GET['email_status']))
    {
        $fields['email_status'] =  1;
    }
    else
    {
        $fields['email_status'] =  0;
    }

    if(isset($_GET['email_akc']))
    {
        $fields['email_akc'] =  1;
    }
    else
    {
        $fields['email_akc'] =  0;
    }



    $profile->set('extended',$fields);
    $profile->save();
    $modx->user->save();
}
?>


<h1>Личные данные: <?php echo $modx->user->get('username');?></h1>
<form class="form-inline" id="form">
    <input type="hidden" name="action" value="UserSettingsChange">

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="fullname" class="col-sm-3 control-label">ФИО*</label>

                <div class="col-sm-9">
                    <input data-required="true"
                           type="text" class="form-control" id="fullname" name="fullname"
                           placeholder="Jane Doe" value="<?php echo $profile->get('fullname');?>">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group input-append">
                <label for="phone" class="col-sm-3 control-label">Контактный телефон*</label>
                <input data-required="true" type="text" class="form-control col-sm-9" id="phone"  name="phone"
                       placeholder="+7 xxx xxx xx xx" value="<?php echo $profile->get('phone');?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="cardN" class="col-sm-3 control-label">№ карты</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="cardN" name="cardN" value="<?php echo $fields['cardN'] ;?>"
                                             placeholder="0000 0000 0000 0000"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">e-mail*</label>

                <div class="col-sm-9">
                    <input data-required="true" type="text" class="form-control" id="email"  name="email"
                                             placeholder="janeDoe@mybox.com"
                                             value="<?php echo $profile->get('email');?>">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="city" class="col-sm-3 control-label">Нас. пункт</label>

                <div class="col-sm-9">
                    <input data-required="true" type="text" class="form-control" id="city" name="city"
                                             placeholder="Samara" value="<?php echo $profile->get('city');?>">
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="birthday" class="col-sm-3 control-label">День рожденья</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="birthday"  name="dob" name="dob"
                           placeholder="20.12.1978" value="<?php echo $profile->get('dob');?>">
                </div>
            </div>
        </div>
    </div>

    <h1>Настройка напоминаний о событиях</h1>

    <div class="row">
        <div class="col-md-6">

                <div class="form-group">
                    <div class="col-sm-2">СМС</div>
                    <div class=" col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="sms_ofrm" <?php if((isset($fields['sms_ofrm']))and($fields['sms_ofrm']==1)) echo " checked "; ?>>При оформлении заказа</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="sms_status" <?php if((isset($fields['sms_status']))and($fields['sms_ofrm']==1)) echo " checked "; ?>>при обновлении статуса заказа</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="sms_akc" <?php if((isset($fields['sms_akc']))and($fields['sms_akc']==1)) echo " checked "; ?>>информация о новых акциях и распродажах</label>
                        </div>
                    </div>
                </div>

        </div>
        <div class="col-md-6">

            <div class="form-group">
                <div class="col-sm-2">E-MAIL</div>
                <div class=" col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="email_ofrm"  <?php if((isset($fields['email_ofrm']))and($fields['email_ofrm']==1)) echo " checked "; ?>>при оформлении заказа</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="email_status"  <?php if((isset($fields['email_status']))and($fields['email_status']==1)) echo " checked "; ?>>при обновлении статуса заказа</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="email_akc" <?php if((isset($fields['email_akc']))and($fields['email_akc']==1)) echo " checked "; ?>>информация о новых акциях и распродажах</label>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="btn-group">
        <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
</form>
<?php