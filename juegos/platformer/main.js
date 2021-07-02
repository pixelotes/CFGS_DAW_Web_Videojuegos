var game;
var Phaser;
var isLookingleft=false;

// We create our only state, called 'mainState'
var mainState = {
    
    // We define the 3 default Phaser functions

    preload: function () {
        "use strict";
        // This function will be executed at the beginning
           // That's where we load the game's assets
        game.load.image('player', 'assets/player.png');
        game.load.image('wallV', 'assets/wallVertical.png');
        game.load.image('wallH', 'assets/wallHorizontal.png');
    },

    create: function () {
        "use strict";
        // This function is called after the preload function
        // Here we set up the game, display sprites, etc.
        game.stage.backgroundColor = '#3498db';
        game.physics.startSystem(Phaser.Physics.ARCADE);
        
        //Añadimos al jugador
        this.player = game.add.sprite(game.world.centerX, game.world.centerY, 'player');
        this.player.anchor.setTo(0.5, 0.5);
        
        //Decimos a Phaser que el jugador use físicas Arcade
        game.physics.arcade.enable(this.player);
        
        //Añadimos gravedad
        this.player.body.gravity.y = 500;
        
        //Definimos controles
        this.cursor = game.input.keyboard.createCursorKeys();
        
        //Creamos el mundo
        this.createWorld();
    },

    update: function () {
        "use strict";
        // This function is called 60 times per second 
        // It contains the game's logic
        //Decimos a Phaser que el jugador y los muros deben colisionar
        game.physics.arcade.collide(this.player, this.walls);
        
        this.movePlayer();
        
        this.checkHeight();
    
    },
    
    movePlayer: function () {
        "use strict";
        //si la flecha izquierda está pulsada
        if (this.cursor.left.isDown) {
            this.player.body.velocity.x = -200;
        //si la flecha derecha está pulsada
        } else if (this.cursor.right.isDown) {
            this.player.body.velocity.x = 200;
        //si no hay ninguna flecha pulsada
        } else {
            this.player.body.velocity.x = 0;
        }
        
        //salto
        if (this.cursor.up.isDown && this.player.body.touching.down) {
            this.player.body.velocity.y = -320;
        }
    },
    
    createWorld: function () {
        "use strict";
        // Create our wall group with Arcade physics
        this.walls = game.add.group();
        this.walls.enableBody = true;

        // Create the 10 walls 
        game.add.sprite(0, 0, 'wallV', 0, this.walls); // Left
        game.add.sprite(480, 0, 'wallV', 0, this.walls); // Right

        game.add.sprite(0, 0, 'wallH', 0, this.walls); // Top left
        game.add.sprite(300, 0, 'wallH', 0, this.walls); // Top right
        game.add.sprite(0, 320, 'wallH', 0, this.walls); // Bottom left
        game.add.sprite(300, 320, 'wallH', 0, this.walls); // Bottom right

        game.add.sprite(-100, 160, 'wallH', 0, this.walls); // Middle left
        game.add.sprite(400, 160, 'wallH', 0, this.walls); // Middle right

        var middleTop = game.add.sprite(100, 80, 'wallH', 0, this.walls);
        middleTop.scale.setTo(1.5, 1);
        var middleBottom = game.add.sprite(100, 240, 'wallH', 0, this.walls);
        middleBottom.scale.setTo(1.5, 1);

        // Set all the walls to be immovable
        this.walls.setAll('body.immovable', true);
    },
    
    checkHeight: function () {
        "use strict";
        if (this.player.position.y === 0) {
            this.player.position.y = game.world.centerY;
        }
        
        if (this.player.position.x === 0) {
            this.player.position.x = game.world.centerX;
        }
    }
};