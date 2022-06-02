<?php

$sql=" 
    SELECT
        COUNT(*)
        FROM
        (
        SELECT
            visita.fecha_inicio,
            visita.hora_inicio,
            visita.fecha_fin,
            visita.hora_fin
        FROM
            `visita`
        JOIN alumno_detalle_convenio ON visita.id_alumno_detalle_convenio = alumno_detalle_convenio.id_alumno_detalle_convenio
        WHERE
            alumno_detalle_convenio.id_usuario = 'svl'
        ) AS a

WHERE
    (
        #comprobamos que fecha inicio queda entre fecha inicio y fecha fin
        (
            TO_SECONDS('".$fecha_inicio." ".$hora_inicio."') >= TO_SECONDS(a.fecha_inicio) + TO_SECONDS(a.hora_inicio) - TO_SECONDS(CURDATE())
            AND TO_SECONDS('".$fecha_inicio." ".$hora_inicio."') <= TO_SECONDS(a.fecha_fin) + TO_SECONDS(a.hora_fin) - TO_SECONDS(CURDATE())
        ) OR
        #comprobamos que fecha fin queda entre fecha inicio y fecha fin
        (
            TO_SECONDS('".$fecha_fin." ".$hora_fin."') >= TO_SECONDS(a.fecha_inicio) + TO_SECONDS(a.hora_inicio)  - TO_SECONDS(CURDATE())
            AND TO_SECONDS('".$fecha_fin." ".$hora_fin."') <= TO_SECONDS(a.fecha_fin) + TO_SECONDS(a.hora_fin) - TO_SECONDS(CURDATE())
        ) OR
        #comprobamos que las dos quedan entre fecha inicio y fecha fin
        (
            TO_SECONDS('".$fecha_inicio." ".$hora_inicio."') <= TO_SECONDS(a.fecha_inicio) + TO_SECONDS(a.hora_inicio)  - TO_SECONDS(CURDATE())
            AND TO_SECONDS('".$fecha_fin." ".$hora_fin."') >= TO_SECONDS(a.fecha_fin) + TO_SECONDS(a.hora_fin) - TO_SECONDS(CURDATE())
        )
    )";
