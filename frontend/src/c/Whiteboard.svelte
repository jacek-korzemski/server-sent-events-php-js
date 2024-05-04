<script lang="ts">
	let canvas: HTMLCanvasElement;

	const randomInt = (min: number, max: number): number => Math.floor(Math.random() * (max - min + 1) + min);

	const randomColor = (): string => `hsl(${randomInt(0, 360)}, 40%, 70%)`;

	const draw = (node: HTMLCanvasElement): { destroy(): void } => {
		const handlePointerDown = ({ clientX, clientY, currentTarget }: PointerEvent) => {
			const ctx = node.getContext("2d");
			if (!ctx) {
				alert("Canvas is not supported in this browser 😥");
				return;
			}

			const color = randomColor();

			const draw = (x: number, y: number): void => {
				const width = 8;
				ctx.beginPath();
				ctx.arc(x, y, width, 0, 2 * Math.PI, false);
				ctx.fillStyle = color;
				ctx.strokeStyle = color;
				ctx.fill();
				ctx.stroke();
			};

			draw(clientX - node.getBoundingClientRect().left, clientY - node.getBoundingClientRect().top);

			const handlePointerMove = ({ clientX, clientY, currentTarget }: PointerEvent) => {
				const target = currentTarget as HTMLCanvasElement;

				draw(clientX - target.getBoundingClientRect().left, clientY - target.getBoundingClientRect().top);
			};

			const handlePointerUp = () => {
				node.removeEventListener("pointermove", handlePointerMove);
				document.removeEventListener("pointerup", handlePointerUp);
			};

			node.addEventListener("pointermove", handlePointerMove);
			document.addEventListener("pointerup", handlePointerUp);
		};

		node.addEventListener("pointerdown", handlePointerDown);
		return {
			destroy() {
				window.removeEventListener("pointerdown", handlePointerDown);
			},
		};
	};

	const testButtonHandler = () => {
		const context = canvas.getContext("2d");
		console.log(canvas.toDataURL());
	};
</script>

<main>
	<canvas bind:this={canvas} use:draw width={1920} height={1080} />
</main>
<button class="btn btn-info" on:click={testButtonHandler}>Console.log(canvas)</button>

<style>
	main {
		max-width: 100%;
		max-height: 600px;
		overflow: scroll;
	}
</style>
