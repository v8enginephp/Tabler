<?php

function tabler_column($slug, $title, $data = COLUMN_PROPERTY, $priority = null, $permission = null)
{
    return array(
        'slug' => $slug,
        'title' => $title,
        'data' => $data,
        'priority' => $priority,
        'permission' => $permission,
    );
}