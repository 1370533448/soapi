<?php
// 连接数据库
$servername = "填写数据库IP";
$username = "用户名";
$password = "密码";
$dbname = "数据库名";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 获取搜索关键词
$q = isset($_GET["q"]) ? $_GET["q"] : "";

// 将搜索词转换为小写
$q = strtolower($q);

// 将搜索词拆分为单个字符数组
$q_chars = preg_split("//u", $q, -1, PREG_SPLIT_NO_EMPTY);

// 构建查询条件
$where_clause = "";
$last_char = null;
foreach ($q_chars as $char) {
    if ($last_char !== null) {
        if (!empty($where_clause)) {
            $where_clause .= " OR ";
        }
        $where_clause .= "title LIKE '%" . $conn->real_escape_string($last_char . $char) . "%'";
    }
    $last_char = $char;
}

// 执行查询语句
$sql = "SELECT * FROM so WHERE $where_clause";
$result = $conn->query($sql);

// 输出匹配结果
if ($result->num_rows > 0) {
    $answers = array();
    while ($row = $result->fetch_assoc()) {
        $content = $row["content"];
        $matched_chars = array();
        foreach ($q_chars as $char) {
            if (strpos($content, $char) !== false) {
                $matched_chars[] = $char;
            }
        }
        $answers[] = array(
            "content" => $content,
            "matched_chars" => $matched_chars
        );
    }

    // 根据涉及字数排序
    usort($answers, function($a, $b) {
        return count($b["matched_chars"]) - count($a["matched_chars"]);
    });

    // 输出搜索结果
    if (count($answers) > 0) {
        echo "以下是从知识库检索的信息请自行甄别内容：";
        $combined_answers = array();
        foreach ($answers as $answer) {
            if (!empty($answer["content"])) {
                $combined_answers[] = $answer["content"];
            }
        }
        echo implode("。", $combined_answers) . "。";
    }
} else {
    echo "";
}

// 关闭数据库连接
$conn->close();

?>
