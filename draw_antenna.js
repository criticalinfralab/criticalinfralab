// https://developer.mozilla.org/en-US/docs/Web/SVG/Attribute/stroke
// 100 < x < 100
// 0 < y < 400

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

var color = "#fff";
var strokew = 15;

function getRandomArbitrary(min, max) {
  return Math.floor(Math.random() * (max - min) + min);
}

function generate_antenna_coordinates() {
    var size = 5;
    var max_x = 250; // half of image width
    var max_y = 600; // image height. could also be 100 and then using additive minima

    // construct the base
    // define starting point
    var antenna = [{x: "0", y: "0"}];
    // make sure we start straight and with a short first arm
    let p2_y = getRandomArbitrary(50, 100);
    antenna.push({x: "0", y: p2_y});

    // construct the rest
    for(var j=0; j < size; j++) {
        let x_new = getRandomArbitrary(-max_x, max_x);
        let y_new = getRandomArbitrary(p2_y, max_y); // ensure we stay above the antenna base
        antenna.push({x: x_new, y: y_new});
    }

    console.log(JSON.stringify(antenna));
    return antenna;
}

function generate_svg() {
    var antenna = generate_antenna_coordinates();

    var svg = '';
    svg += '<svg id="antenna" width="500px" height="600px" version="1.1" xmlns="http://www.w3.org/2000/svg">\n';
    svg += '<g transform="translate(250,600) scale(1,-1)">'; // flip the coord system upside down and move halfway

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
