<div class="contentWrapper">

<?php
	/**
	 * Elgg Poll plugin
	 * @package Elggpoll
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @Original author John Mellberg
	 * website http://www.syslogicinc.com
	 * @Modified By Team Webgalli to work with ElggV1.5
	 * www.webgalli.com or www.m4medicine.com
	 */
	 

	if (isset($vars['entity'])) {
		
		//set img src
		$img_src = $vars['url'] . "mod/polls/graphics/poll.gif";
		
		$question = $vars['entity']->question;
		
		//get the array of possible responses
		$responses = polls_get_choice_array($vars['entity']);
		
		//get the array of user responses to the poll
		$user_responses = $vars['entity']->getAnnotations('vote',9999,0,'desc');
		
		//get the count of responses
		$user_responses_count = $vars['entity']->countAnnotations('vote');
		
		//create new array to store response and count
		//$response_count = array();
		

		//populate array
		foreach($responses as $response)
		{
			//get count per response
			$response_count = getResponseCount($response, $user_responses);
			
			//calculate %
			if ($response_count && $user_responses_count) {
				$response_percentage = round(100 / ($user_responses_count / $response_count));
			} else {
				$response_percentage = 0;
			}
			
			//html
			?>
			<div id="progress_indicator" >
				<label><?php echo $response . " (" . $response_count . ")"; ?></label><br>
				<div id="progressBarContainer" align="left">	
					<img src="<?php echo $img_src; ?>" width="<?php echo $response_percentage; ?>%" height="12px">
				</div>	
			</div>
			<br>
		<?php
		}
		?>
		
		<p>
			<?php echo elgg_echo('polls:totalvotes') . $user_responses_count; ?>
		</p>
		
	<?php
		
	}
	else
	{
		register_error(elgg_echo("polls:blank"));
		forward("mod/polls/all");
	}
	
	function getResponseCount($valueToCount, $fromArray)
	{
		$count = 0;
		
		if(is_array($fromArray))
		{
			foreach($fromArray as $item)
			{
				if(in_array($valueToCount, unserialize($item->value)))
				{
					$count += 1;
				}
			}	
		}
		
		return $count;
	}
?>
</div>