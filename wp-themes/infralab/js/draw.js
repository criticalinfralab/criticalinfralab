/*
@licstart
Copyright (C) 2023 Ulrike Uhlig

    The JavaScript code in this page is free software: you can
    redistribute it and/or modify it under the terms of the GNU
    General Public License (GNU GPL) as published by the Free Software
    Foundation, either version 3 of the License, or (at your option)
    any later version.  The code is distributed WITHOUT ANY WARRANTY;
    without even the implied warranty of MERCHANTABILITY or FITNESS
    FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.

    As additional permission under GNU GPL version 3 section 7, you
    may distribute non-source (e.g., minimized or compacted) forms of
    that code without the copy of the GNU GPL normally required by
    section 4, provided you include this license notice and a URL
    through which recipients can access the Corresponding Source.
@licend
*/

const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");
const width = window.innerWidth;
const height = window.innerHeight;

canvas.width = width;
canvas.height = height;
context.lineCap = "butt";
context.lineJoin = "bevel";
context.lineWidth = 30;
context.strokeStyle = 'white';
let drawing = false;

function getMousePos(canvas, e) {
    var rect = canvas.getBoundingClientRect(),
    scaleX = canvas.width / rect.width,
    scaleY = canvas.height / rect.height;

    // mobile
    if(e.type == 'touchstart' || e.type == 'touchmove' || e.type == 'touchend' || e.type == 'touchcancel'){
        var evt = (typeof e.originalEvent === 'undefined') ? e : e.originalEvent;
        var touch = evt.touches[0] || evt.changedTouches[0];
        return {
            x: (touch.pageX - rect.left) * scaleX,
            y: (touch.pageY - rect.top) * scaleY
        }
    }

    // desktop
    return {
        x: (e.clientX - rect.left) * scaleX,
        y: (e.clientY - rect.top) * scaleY
    }
}

function startDrawing(e) {
    drawing = true;
    context.beginPath();
    draw(e);
}

function endDrawing(e) {
    drawing = false;
}

function draw(e) {
    if (!drawing) return;
    let { x, y } = getMousePos(canvas, e);
    context.lineTo(x, y);
    context.stroke();
}

window.addEventListener("load", startDrawing);
window.addEventListener("touchstart", startDrawing);
window.addEventListener("mousemove", draw);
window.addEventListener("touchmove", draw);
window.addEventListener("pointerdown", endDrawing);

let start = {}
