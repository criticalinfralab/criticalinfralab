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
/*
 *  expected format for drawing the antenna
 *
var antenna = [
    {"x":  0, "y":  0},
    {"x":  0, "y":  100},
    {"x":  25, "y":  100},
    {"x":  -45, "y": 130},
    {"x": 75, "y": 210},
    {"x": -35, "y": 80},
    {"x": 50, "y": 350},
];
*/

var color = "#000";
var strokew = 6;

function getRandomArbitrary(min, max) {
    return Math.floor(Math.random() * (max - min) + min);
}

function generate_antenna_coordinates() {
    var size = 5;
    var max_x = 100; // half of image width minus some space for the rounded corners
    var max_y = 195; // image height minus space for corners

    // construct the base
    // define starting point
    var antenna = [{x: "0", y: "0"}];
    // make sure we start straight and with a short first arm
    let p2_y = getRandomArbitrary(20, 60);
    antenna.push({x: "0", y: p2_y});

    // construct the rest
    for(var j=0; j < size; j++) {
        let x_new = getRandomArbitrary(-max_x, max_x);
        let y_new = getRandomArbitrary(p2_y, max_y); // ensure we stay above the antenna base
        antenna.push({x: x_new, y: y_new});
    }

    // console.log(JSON.stringify(antenna));
    return antenna;
}

function generate_svg() {
    var antenna = generate_antenna_coordinates();

    var svg = '';
    svg += '<svg id="antenna" width="200px" height="200px" version="1.1" xmlns="http://www.w3.org/2000/svg">\n';
    svg += '<g transform="translate(100,200) scale(1,-1)">'; // flip the coord system upside down and move halfway

    for(var i in antenna) {
        var path = '';
        if (i == 0) {
            pos = 0;
        } else {
            pos = i-1;
        }
        path += ' M ' + antenna[pos]["x"] + ' ' + antenna[pos]["y"]; // moveTo (draws starting point)
        path += ' L ' + antenna[i]["x"] + ' ' + antenna[i]["y"];     // lineTo (draws a line from the current position to the new position)
        path += ' Z';                                                // closePath
        svg += '<path d="' + path + '"stroke="' + color + '" stroke-width="' + strokew + '" stroke-opacity="1" stroke-linecap="round" fill="transparent" />\n';
    }

    svg += '</svg>\n';
    return svg;
}
