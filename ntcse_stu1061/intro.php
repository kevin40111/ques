<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-TW" lang="zh-TW">
<html xml:lang="zh-TW" lang="zh-TW">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title><?=$doc->title?></title>

<!--[if lt IE 9]><script src="js/html5shiv.js"></script><![endif]-->
<script src="/js/jquery-1.11.2.min.js"></script>

<link rel="stylesheet" href="/css/Semantic-UI/2.2.4/semantic.min.css" />

</head>

<body>
    <?=$child_head?> 
    <div class="ui text container">
        <form action="https://sso.ntpc.edu.tw/login.aspx" method="get">
            <input type="hidden" name="ReturnUrl" value="http://ntcse.ntpc.edu.tw/ques?type=stu__<?=csrf_token()?>__ntcse_stu1061">
            <?=$child_body?>
        </form>
        <?=$child_footer?>
    </div>
</body>
</html>