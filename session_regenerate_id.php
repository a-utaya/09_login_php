<?php
session_start();

//現在のセッションIDを取得
$old_session_id = session_id();
session_regenerate_id(true);
$new_session_id = session_id();

echo '<p>旧id' . $old_session_id . '</p>';
 echo '<p>新id' . $new_session_id . '</p>';
 ?>