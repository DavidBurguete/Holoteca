<?php
    function depurar($dato_a_depurar){
        //El propósito es sanear el código de cualquier sentencia sql que pueda ser dañina
        $dato_a_depurar = str_ireplace(';','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('\'','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('"','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('TRUNCATE','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('CREATE','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('ALTER','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('DROP','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('GRANT','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('SHUTDOWN','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('REPLICATION','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('SHOW','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('LOCK','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('REFERENCES','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('REPLICATION','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('INSERT','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('UPDATE','',$dato_a_depurar);
        $dato_a_depurar = str_ireplace('DELETE','',$dato_a_depurar);
        return $dato_a_depurar;
    }
?>