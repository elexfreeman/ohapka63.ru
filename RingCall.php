<?php
if(isset($_GET))
{
    if($_GET['action']=='CallBack')
    {
        //$adminEmail="mati-irina@yandex.ru";
        $adminEmail="elextraza@gmail.com";
        $message = '
        <h3>Сообщение с обратной связи</h3>
        <h4>Имя: '.mysql_escape_string($_GET['c_name']).'</h4>
        <h4>Номер: '.mysql_escape_string($_GET['c_phone']).'</h4>
        
        
        ';
        
        $from ='shop@ohapka63.ru'; // от кого
        $mailheaders = "Content-type:text/html;charset=utf8;From:".$from;
        
        /* Для отправки HTML-почты вы можете установить шапку Content-type. */
        $mailheaders= "MIME-Version: 1.0\r\n";
        $mailheaders .= "Content-type: text/html; charset=utf8\r\n";
        
        /* дополнительные шапки */
        $mailheaders .= "From: ohapka63.ru <".$from.">\r\n";
        
        
        $subject="ohapka63.ru заказ звонка на номер ".mysql_escape_string($_GET['c_phone'])." (".mysql_escape_string($_GET['c_name']).")";
        
        mail($user_email, $subject, $message, $mailheaders);
    }
}