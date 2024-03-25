<!DOCTYPE html>

<html lang='zh-cn'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>短链生成</title>
</head>
<body>
    <?php
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method === 'GET') {
        echo "
<form action='' method='post'>
    <div>
        键：<br />
        <input type='text' name='key'>
    </div>
    <div>
        值：<br />
        <textarea type='text' name='data' rows='6'></textarea>
    </div>
    <div>
        类型：
        <input type='radio' name='type' value='1' checked>链接
        <input type='radio' name='type' value='2'>文本
    </div>
    <div>
        <input type='submit' value='生成'>
    </div>
</form>";
    } else {
        $key = htmlspecialchars(stripslashes(trim($_POST["key"])));
        if ($key === NULL || $key === "") return;
        $type = htmlspecialchars(stripslashes(trim($_POST["type"])));
        if ($type === NULL || $type === "") return;
        $data = htmlspecialchars(stripslashes(trim($_POST["data"])));
        if ($data === NULL || $data === "") return;

        //数据
        if ($type === "1") {
            $data = '<script>window.location.href="' . $data . '"</script>';
        }

        //创建文件夹
        $filePath = $key . "/index.php";
        if (file_exists($filePath)) {
            echo "此键已被占用！";
            return;
        }
        mkdir($key, 0777, true);

        //创建文件
        $file = fopen($filePath, "a+") or exit("Unable to open file!");
        //写入文件
        fwrite($file, $data. "\r\n");
        //关闭文件流
        fclose($file);

        echo "<a href='" . $key . "'>" . $key . "</a>";
    }
    ?>
</body>
</html>
