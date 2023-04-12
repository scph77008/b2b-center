<?php

function load_users_data($user_ids)
{
    $user_ids = explode(',', $user_ids);

    $user_ids = array_unique(
        array_filter(
            // Убираем пробелы для запросов вроде "1, 2, 3"
            array_map('trim', $user_ids),

            // Убираем всё нечисловое
            function ($id) {
                return is_numeric($id);
            })
    );

    if(!$user_ids)
        return [];

    $db = mysqli_connect("localhost", "root", "123123", "database");
    $sql = mysqli_query($db, sprintf('SELECT * FROM users WHERE id IN (%s)', implode(',', $user_ids)));

    while ($obj = $sql->fetch_object()) {
        $data[$obj->id] = $obj->name;
    }

    mysqli_close($db);

    return $data;
}

// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);
foreach ($data as $user_id => $name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
