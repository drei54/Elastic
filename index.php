<?
	#require once
	require_once("lib/fanspage_analityc.php");

	#call class
	$class = new Fanspage_analityc();
	$data = $class->main($var);
?>

<table border="1">
<tr><td rowspan="2">NO</td><td rowspan="2">ID</td><td rowspan="2">created_time</td><td rowspan="2">user_ID</td><td rowspan="2">user_NAME</td><td rowspan="2">message</td><td rowspan="2">comments_count</td><td colspan="2">detail_comment</td></tr>
<tr><td>username</td><td>comment_count</td></tr>
<?
$i=1;
foreach($data['hits']['hits'] as $d){
	if($d['fields']['meta']['date'] >= $var['sd'] AND $d['fields']['meta']['date'] <= $var['ed']){
		
		$commentuser = "";
		
		#most post
		$userid[$d['fields']['from']['id']] 			= (isset($userid[$d['fields']['from']['id']]) == 0) ? 1 : ($userid[$d['fields']['from']['id']]+1);
		$username[$d['fields']['from']['id']] 	= $d['fields']['from']['name'];
		$comment_count 							= (isset($d['fields']['comments']['data'])==1) ? sizeof($d['fields']['comments']['data']) : 0;
		$message										= (isset($d['fields']['message']) ==1) ? $d['fields']['message']: "";
		if($comment_count > 0){
			foreach($d['fields']['comments']['data'] as $cd){
				$commentuser[$cd['from']['id']] 			= (isset($commentuser[$cd['from']['id']]) == 0) ? 1 : ($commentuser[$cd['from']['id']]+1);
				$commentusername[$cd['from']['id']] 	= $cd['from']['name'];
			}
			$row = sizeof($commentuser);
		}
		if($comment_count > 0){
			$r = 1;
			foreach($commentuser as $k => $v){?>
			<tr>
			<?if($r == 1){?>
				<td rowspan="<?=$row?>"><?=$i?></td>
				<td rowspan="<?=$row?>"><?=$d['fields']['id']?></td>
				<td rowspan="<?=$row?>"><?=$class->set_date_fb($d['fields']['created_time'])?></td>
				<td rowspan="<?=$row?>">"<?=$d['fields']['from']['id']?>"</td>
				<td rowspan="<?=$row?>"><?=$d['fields']['from']['name']?></td>
				<td rowspan="<?=$row?>"><?=$message?></td>
				<td rowspan="<?=$row?>"><?=$comment_count?></td>
			<?}?>
				<td><?=$commentusername[$k]?></td>
				<td><?=$v?></td>
			</tr>
<?
			$r++;
			}
		}else{?>
			<tr>
			<td><?=$i?></td>
			<td><?=$d['fields']['id']?></td>
			<td><?=$class->set_date_fb($d['fields']['created_time'])?></td>
			<td>"<?=$d['fields']['from']['id']?>"</td>
			<td><?=$d['fields']['from']['name']?></td>
			<td><?=$message?></td>
			<td><?=$comment_count?></td>
			<td> </td>
			<td> </td>
			</tr>
		<?
		}
		$i++;
	}
	#break;
}
?>
</table>
