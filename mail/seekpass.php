<p>尊敬的admin,您好：</p>
<p>您的找回密码链接如下：</p>
<?php
$url = Yii::$app->urlManager->createAbsoluteUrl(['admin/manage/mailchangepass','timestamp'=> $time,'adminuser'=>$adminuser,'token'=>$token]);
?>
<p><a href="<?php echo $url;?>"><?php echo $url;?></a></p>
