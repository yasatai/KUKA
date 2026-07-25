<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <title>KUKA 管理画面</title>
    @vite('resources/js/admin.tsx')
</head>
<body>
    <div id="admin-app"></div>
    <noscript>管理画面を利用するにはJavaScriptを有効にしてください。</noscript>
</body>
</html>
