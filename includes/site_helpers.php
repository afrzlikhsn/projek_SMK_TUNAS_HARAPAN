<?php
if (!function_exists('site_setting')) {
    function site_setting(mysqli $db, string $key, string $default = ''): string {
        $stmt = mysqli_prepare($db, "SELECT setting_value FROM site_settings WHERE setting_key=? LIMIT 1");
        if (!$stmt) return $default;
        mysqli_stmt_bind_param($stmt, 's', $key);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $value);
        $found = mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        return $found ? (string)$value : $default;
    }
    function site_section(mysqli $db, string $key): array {
        $stmt = mysqli_prepare($db, "SELECT * FROM site_sections WHERE section_key=? LIMIT 1");
        if (!$stmt) return [];
        mysqli_stmt_bind_param($stmt, 's', $key); mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); $row = $result ? mysqli_fetch_assoc($result) : []; mysqli_stmt_close($stmt);
        return $row ?: [];
    }
    function site_features(mysqli $db): array {
        $rows=[]; $q=mysqli_query($db,"SELECT * FROM site_features WHERE status='Aktif' ORDER BY sort_order ASC,id ASC");
        while($q && ($r=mysqli_fetch_assoc($q))) $rows[]=$r; return $rows;
    }
    function site_stats(mysqli $db): array {
        $rows=[]; $q=mysqli_query($db,"SELECT * FROM site_stats WHERE status='Aktif' ORDER BY sort_order ASC,id ASC");
        while($q && ($r=mysqli_fetch_assoc($q))) $rows[]=$r; return $rows;
    }
    function site_gallery(mysqli $db): array {
        $rows=[]; $q=mysqli_query($db,"SELECT * FROM site_gallery WHERE status='Aktif' ORDER BY event_date DESC, id DESC");
        while($q && ($r=mysqli_fetch_assoc($q))) $rows[]=$r; return $rows;
    }
    function site_e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
}
