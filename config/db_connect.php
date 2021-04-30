
<?php
    function get_link(){
        $host = 'localhost'; 
        $user = 'root'; //имя пользователя, по умолчанию это root
        $password = ''; //пароль, по умолчанию пустой
        $db_name = 'table_29m'; 
    
        //Соединяемся с базой данных используя наши доступы:
        $link = mysqli_connect($host, $user, $password, $db_name)
            or die(mysgli_error($link));
    
        mysqli_query($link, "SET NAMES 'utf8'");
        return $link;
    }

?>