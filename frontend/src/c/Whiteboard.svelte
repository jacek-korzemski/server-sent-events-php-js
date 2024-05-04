<script lang="ts">
	import { onMount, onDestroy } from "svelte";

	let canvas: HTMLCanvasElement;
	let ctx: CanvasRenderingContext2D;
	let prevX: number;
	let prevY: number;
	let currX: number;
	let currY: number;
	let isDrawing = false;
	let lineWidth = 10;

	const setupCanvas = () => {
		if (canvas) {
			ctx = canvas.getContext("2d") as CanvasRenderingContext2D;
			if (!ctx) {
				alert("Canvas is not supported in this browser 😥");
				return;
			}

			canvas.addEventListener("mousedown", handleMouseDown);
			canvas.addEventListener("mousemove", handleMouseMove);
			canvas.addEventListener("mouseup", handleMouseUp);
			canvas.addEventListener("mouseleave", handleMouseLeave);
			ctx.lineWidth = lineWidth;
		}
	};

	const handleMouseDown = (e: MouseEvent) => {
		isDrawing = true;
		[prevX, prevY] = [e.offsetX, e.offsetY];
	};

	const handleMouseMove = (e: MouseEvent) => {
		if (!isDrawing) return;

		currX = e.offsetX;
		currY = e.offsetY;

		drawSmoothCurve(prevX, prevY, currX, currY);

		[prevX, prevY] = [currX, currY];
	};

	const handleMouseUp = () => {
		isDrawing = false;
	};

	const handleMouseLeave = () => {
		isDrawing = false;
	};

	const drawSmoothCurve = (x0: number, y0: number, x1: number, y1: number) => {
		ctx.beginPath();
		ctx.moveTo(x0, y0);
		ctx.lineTo(x1, y1);
		ctx.fill();
		ctx.stroke();
		ctx.closePath();
	};

	const changeLineWidth = (e: Event) => {
		const target = e.target as HTMLInputElement;
		lineWidth = +target.value;
		if (ctx) {
			ctx.lineWidth = lineWidth;
		}
	};

	onMount(() => {
		setupCanvas();
	});

	onDestroy(() => {
		canvas.removeEventListener("mousedown", handleMouseDown);
		canvas.removeEventListener("mousemove", handleMouseMove);
		canvas.removeEventListener("mouseup", handleMouseUp);
		canvas.removeEventListener("mouseleave", handleMouseLeave);
	});
</script>

<main>
	<canvas bind:this={canvas} width={1920} height={1080} />
</main>
<input type="range" min="1" max="10" bind:value={lineWidth} on:input={changeLineWidth} />

<!-- <button class="btn btn-info" on:click={testButtonHandler}>Console.log(canvas)</button> -->

<style>
	main {
		max-width: 100%;
		max-height: 600px;
		overflow: scroll;
		border: 1px solid rgba(0, 0, 0, 0.4);
	}
</style>
