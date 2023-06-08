const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const width = 2480;
const height = 1920;

canvas.width = width;
canvas.height = height;
context.lineCap = "butt";
context.lineJoin = "bevel";
context.lineWidth = 30;
context.strokeStyle = 'white';
let drawing = false;

function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect(),
    scaleX = canvas.width / rect.width,
    scaleY = canvas.height / rect.height;
    return {
        x: (evt.clientX - rect.left) * scaleX,
        y: (evt.clientY - rect.top) * scaleY
    }
}

function startDrawing(e) {
    drawing = true;
    context.beginPath();
    draw(e);
}
window.addEventListener("load", startDrawing);

function endDrawing(e) {
    drawing = false;
}
window.addEventListener("click", endDrawing);

function draw(e) {
    if (!drawing) return;
    let { x, y } = getMousePos(canvas, e);
    context.lineTo(x, y);
    context.stroke();
}
window.addEventListener("mousemove", draw);

let start = {}
