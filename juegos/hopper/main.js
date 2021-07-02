var Phaser;
var game;
// Define our main state
var main = {
    preload: function () {
        "use strict";
        game.load.image('player', 'assets/player.png');
        game.load.image('wall', 'assets/hopper.png');
        game.load.image('wall2', 'assets/hopper2.png');
    },

    create: function () {
        "use strict";

        //Inicializa motor físicas
        game.physics.startSystem(Phaser.Physics.P2);

        //Inicializa teclas
        this.cursor = game.input.keyboard.createCursorKeys();
        
        this.obstacles = game.add.group();
        //Crea raqueta
        this.player = game.add.sprite(200, 400, 'player');

        this.player.body.collideWorldBounds = true;

        //Crea ladrillos
        this.wall = game.add.tileSprite(0, 350, 800, 10, 'wall');
        this.wall.autoScroll(-50, 0);
        this.obstacles.add(this.wall);

        this.wall2 = game.add.tileSprite(0, 270, 800, 10, 'wall2');
        this.wall2.autoScroll(50, 0);
        this.obstacles.add(this.wall2);

        this.wall3 = game.add.tileSprite(0, 200, 800, 10, 'wall');
        this.wall3.autoScroll(-60, 0);
        this.obstacles.add(this.wall3);

        this.wall4 = game.add.tileSprite(0, 130, 800, 10, 'wall2');
        this.wall4.autoScroll(80, 0);
        this.obstacles.add(this.wall4);

    },

    update: function () {
        "use strict";

        game.physics.ninja.collide(this.player, this.obstacles);
        if (this.cursor.right.isDown) {
            this.player.body.moveRight(10);
        } else if (this.cursor.left.isDown) {
            this.player.body.moveLeft(10);
        } else if (this.cursor.up.isDown) {
            this.player.body.moveUp(50);
        } else if (this.cursor.down.isDown) {
            this.player.body.moveDown(10);
        } else {
            this.player.body.velocity.x = 0;
            this.player.body.velocity.y = 0;
        }
        //game.world.warp(this.obstacles, 0, true);

    },

    createWorld: function () {
        "use strict";


    },

    hit: function () {
        alert("hit");
    }
};

// Initialize Phaser, and start our 'main' state 
var game = new Phaser.Game(400, 450, Phaser.AUTO, 'gameDiv');
game.state.add('main', main);
game.state.start('main');