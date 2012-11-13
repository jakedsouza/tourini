<style type="text/css" media="screen">
	#search_results_options_container {
		background-color: transparent;
		margin-top: -8%;
		margin-bottom: 10%;
		float: right;
		display: block;
		border-style: solid;
		border-radius: 4px;
		border-width: 2px;
		padding-left: 4px;
		list-style-type: none;
	}
	
	#search_for li ,ul{
		
	padding-left:5px;
	margin: 0;
	list-style-type: none;
	}
</style>
<div id="search_results_options_container">
	<center>
		<h2>Refine Search Results</h2>
	</center>
	<center>
		<h3>
		Search For
		</h3>
	</center>
	<hr/>
	<div id="search_for">
		<ul>
			<li>
				<label for="people">People</label>
			</li>
			<li>
				<input type="checkbox" name="people" value="people"/>
			</li>
			<li>
				<label for="messages">Messages</label>
			</li>
			<li>
				<input type="checkbox" name="messages" value="messages"/>
			</li>
			<li>
				<label for="photos">Photos</label>
			</li>
			<li>
				<input type="checkbox" name="photos" value="photos"/>
			</li>
			<hr/>
			<li>
				<label for="datefrom">Dates From</label>
			</li>
		
			<li>
				<input type="date" name="fromdate" id="fromdate"/>
			</li>
			<li>
				<label for="dateto">Dates To</label>
			</li>
			<li>
				<input type="date" name="todate" id="todate"/>
			</li>
			<li>
				<label for="location">Location</label>
			</li>
			<li>
				<input type="text" name="location" id="location"/>
			</li>
			<li>
				<label for="radius">Radius (miles)</label>
			</li>
			<li>
                            <input type="number" name="radius" style="width: 50px"/>
				
			</li>
		</ul>
	</div>
</div>
<script type="text/javascript">
$("#fromdate").dateinput();
$("#todate").dateinput();

</script>
