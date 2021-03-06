<?php
/* Dixie - Free and Simple CMS
 * Created by Luthfie a.k.a. 9r3i
 * luthfie@y7mail.com
 */

/* starter time */
$time_start = microtime(true);

/* Global options and posts */
global $options,$posts;

/* Get site options */
if(!get_options()){
  header('content-type: text/plain;');
  exit('cannot get options information');
}

/* Get all published public posts */
if(!get_posts('url','status=publish&access=public')){
  header('content-type: text/plain;');
  exit('cannot get posts information');
}

/* Get contents */
$content = '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="'.WWW.PUBDIR.'admin/css/rss.css" media="print, screen" ?>
<rss version="2.0"
  	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
  >
  <channel>
    <title><![CDATA['.$options['site_name'].']]></title>
    <link>'.WWW.'feed.xml</link>
    <description><![CDATA['.$options['site_description'].']]></description>
    <language>ID-id</language>
    <pubDate>'.date("r").'</pubDate>
    <atom:link href="'.WWW.'feed.xml" rel="self" type="application/rss+xml" />
	<generator>http://dixie-cms.herokuapp.com/?v='.VERSION.'</generator>
    ';
$next = (isset($_GET['next']))?$_GET['next']:0;
$counter=0; $stop=$next+10;
$types = array('page');

foreach(array_reverse($posts) as $id=>$post){if(!in_array($post['type'],$types)){ // filtered by non-page type
  $counter++;
  if($counter>$next){
    $next++;
    $content .= '<item>';
    $content .= '<title><![CDATA['.utf8_decode($post['title']).']]></title>';
    $content .= '<link>'.WWW.$post['url'].'.html</link>';
    $pcontent = strip_tags($post['content'],'<p>');
    $content .= '<description><![CDATA['.utf8_decode(substr($pcontent,0,200))
      .((strlen($pcontent)>200)?'...':'')
	  .((strlen($pcontent)>200)?' <a href="'.WWW.$post['url'].'.html" rel="detail" title="Read More...">[Read More]</a>':'')
	  .']]></description>';
    $content .= '<pubDate>'.date('r',$post['time']).'</pubDate>';
    $content .= '<guid>'.WWW.$post['url'].'.html</guid>';
    $content .= '</item>';
	if($next==$stop){break;}
  }
}}
$content .= '
  </channel>
</rss>';
$time_end = microtime(true);
$content .= '

<!-- Generated in '.number_format($time_end-$time_start,3).' seconds, by Dixie on '.date('Y-m-d H:i:s').' -->';

/* Set header content */
header('content-type: application/rss+xml;');
echo $content;