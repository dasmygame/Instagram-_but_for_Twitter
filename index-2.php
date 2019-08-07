<?php
print "<h1>Instagram, but for twitter</h1>";

print "Search keywords and hastags to display relevant images from twitter";

?>
<?php
	$search = trim(htmlspecialchars($_REQUEST['search']));
if(!$search) $search = "#homefood";
	
	$url = ("https://twitter.com/search?f=tweets&vertical=default&q=".urlencode($search)."&src=typd");
	
	$data = file_get_contents($url);
	
	
	print <<<EOF
<form action=index.php><input name=search value="$search"><input type=submit></form>
EOF;
 
$tweets = explode('<small class="time">', $data);
foreach($tweets as $tweet){
  if(strpos($tweet, 'pbs.twimg') == -1) continue;
  if (preg_match_all('#<a href="(/.*?)".*?AdaptiveMedia.*?(https://pbs.twimg.*?\.(png|jpg))#s',
     $tweet, $matches)) {
      $url = $matches[1][0];
      $pic = $matches[2][0];
      $map[$url] = $pic;
  }
}
 
foreach($map as $url=>$pic){
  $cloudimage = "https://adqqfotden.cloudimg.io/crop/300x300/x/" . $pic;
  print "<a href=http://twitter.com/$url><img width=width src='$cloudimage'></a>";
}


?>