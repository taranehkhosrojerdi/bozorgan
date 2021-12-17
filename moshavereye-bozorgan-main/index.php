<?php
$porsesh='سوال خود را بپرس!';
$question = 'این یک پرسش نمونه است';
$msg = 'این یک پاسخ نمونه است';
$en_name = 'hafez';
$fa_name = 'حافظ';
$print='';

$content = file_get_contents('people.json');
$ppl_info = json_decode($content,true);
$mes_content= file_get_contents('messages.txt');
$msgha = explode(PHP_EOL,$mes_content);
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST["question"])){
    $question = $_POST["question"];
    $en_name = $_POST["person"];
    $fa_name = $ppl_info[$en_name];
    $msg=$msgha[(intval(hash('md5', $question.$fa_name),10) % 16)];
	$print='پرسش:';
}
else{
	$en_name = $_POST["person"];
    $fa_name = $ppl_info[$en_name];
	$print='';
	$msg='سوال خود را بپرس!';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>

<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label">
			<?php echo $print ?>
		</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container" >
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                /*
                 * Loop over people data and
                 * enter data inside `option` tag.
                 * E.g., <option value="hafez">حافظ</option>
                 */
                $names = file_get_contents('people.json');
                $ppl_info = json_decode($names);
                foreach($ppl_info as $key => $value){
                       echo'<option value='."$key".'>'."$value".'</option>';
                }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>