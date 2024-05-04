<script>
	let status = "Ready";
	let data = [];
	let eventSource = null;

	const magic = () => {
		eventSource = new EventSource("http://localhost:8080/stream");
		status = "Reading data...";

		eventSource.onmessage = (event) => {
			data = [...data, event.data];
		};
	};

	const stopMagic = () => {
		try {
			eventSource.close();
			status = "Stopped; Ready.";
		} catch (e) {
			console.log(e);
		}
	};
</script>

<p>
	<button class="btn btn-success" on:click={magic}>Start</button>
	<button class="btn btn-danger" on:click={stopMagic}>Stop</button>
	<b>Status:</b>
	{status}
</p>
<table>
	<thead>
		<tr><td width="120">Number</td><td>Content</td><td width="220">Server time</td></tr>
	</thead>
	<tbody>
		{#each data as record, index}
			<tr>
				<td>{index}</td>
				<td>{record}</td>
				<td>-</td>
			</tr>
		{/each}
	</tbody>
</table>
