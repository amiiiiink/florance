<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بازی کلیک روی توپ</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
        }
        canvas {
            display: block;
        }
    </style>
</head>
<body>
<canvas id="gameCanvas"></canvas>
<script>
    const canvas = document.getElementById("gameCanvas");
    const ctx = canvas.getContext("2d");
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    let score = 0;
    let ball = {
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        radius: 30,
        dx: (Math.random() - 0.5) * 6,
        dy: (Math.random() - 0.5) * 6
    };

    function drawBall() {
        ctx.beginPath();
        ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
        ctx.fillStyle = "red";
        ctx.fill();
        ctx.closePath();
    }

    function moveBall() {
        ball.x += ball.dx;
        ball.y += ball.dy;

        if (ball.x - ball.radius < 0 || ball.x + ball.radius > canvas.width) {
            ball.dx *= -1;
        }
        if (ball.y - ball.radius < 0 || ball.y + ball.radius > canvas.height) {
            ball.dy *= -1;
        }
    }

    function gameLoop() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        drawBall();
        moveBall();
        requestAnimationFrame(gameLoop);
    }

    canvas.addEventListener("click", function (event) {
        const distance = Math.sqrt((event.clientX - ball.x) ** 2 + (event.clientY - ball.y) ** 2);
        if (distance < ball.radius) {
            score++;
            ball.x = Math.random() * canvas.width;
            ball.y = Math.random() * canvas.height;
            ball.dx = (Math.random() - 0.5) * 6;
            ball.dy = (Math.random() - 0.5) * 6;
            alert("امتیاز: " + score);
        }
    });

    gameLoop();
</script>
</body>
</html>
