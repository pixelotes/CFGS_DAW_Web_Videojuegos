var Game = {
    display: null,
    map: {},
    freeCells: {},

    init: function () {

        //inicializa consola ROT
        this.display = new ROT.Display();
        document.body.appendChild(this.display.getContainer());

        this._generateMap();
    },

    _generateMap: function () {
        var digger = new ROT.Map.Rogue();
        freeCells = [];

        var digCallback = function (x, y, value) {
            if (value) {
                return;
            }

            var key = x + "," + y;
            this.map[key] = ".";
            freeCells.push(key);
        }

        digger.create(digCallback.bind(this));

        this._generateBoxes(freeCells);

        this._drawWholeMap();
    },

    _drawWholeMap: function () {
        for (var key in this.map) {
            var parts = key.split(",");
            var x = parseInt(parts[0]);
            var y = parseInt(parts[1]);
            this.display.draw(x, y, this.map[key]);
        }
    },
    
    _generateBoxes: function(freeCells) {
        for (var i = 0; i < 20; i++) {
            var index = Math.floor(ROT.RNG.getUniform() * freeCells.length);
            var key = freeCells.splice(index, 1)[0];
            this.map[key] = "*";
        }
    }
};