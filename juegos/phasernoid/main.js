var Phaser;
var game;
var contador = 25;
// Define our main state
var main = {
        preload: function () {
            "use strict";
            game.load.image('paddle', 'assets/paddle.png');
            game.load.image('brick', 'assets/brick.png');
            game.load.image('ball', 'assets/ball.png');
        },

        create: function () {
            "use strict";
            
            //Inicializa motor físicas
            game.physics.startSystem(Phaser.Physics.ARCADE);
            
            //Inicializa teclas
            this.cursor = game.input.keyboard.createCursorKeys();
            
            //Crea raqueta
            this.paddle = game.add.sprite(200, 400, 'paddle');
            
            game.physics.arcade.enable(this.paddle);
            
            
            
            this.paddle.body.collideWorldBounds = true;
            
            //Crea pelota
            this.ball = game.add.sprite(200, 300, 'ball');
            
            game.physics.arcade.enable(this.ball);
            
            this.ball.body.velocity.x = 200;
            this.ball.body.velocity.y = 200;
            
            //Rebotes
            this.ball.body.collideWorldBounds = true;
            this.ball.body.bounce.x = 1;
            this.ball.body.bounce.y = 1;
            
            //Crea ladrillos
            this.createWorld();
            
            this.paddle.body.immovable = true;
        },

        update: function () {
            "use strict";
            
            game.physics.arcade.collide(this.paddle, this.ball, this.velocidad, null, this);
            
            game.physics.arcade.collide(this.ball, this.bricks, this.hit, null, this);
            
            if (this.cursor.right.isDown) {
                this.paddle.body.velocity.x = 350;
            } else if (this.cursor.left.isDown) {
                this.paddle.body.velocity.x = -350;
            } else {
                this.paddle.body.velocity.x = 0;
            }
            
            if (contador === 0) {
                contador = 25;
                game.state.start('main');
            }
        },
    
        createWorld: function () {
            "use strict";
            // Create a group that will contain all the bricks
            this.bricks = game.add.group();
            this.bricks.enableBody = true;

            // Create the 16 bricks
            for (var i = 0; i < 5; i++) {
                for (var j = 0; j < 5; j++) {
                    game.add.sprite(55+i*60, 55+j*35, 'brick', 0, this.bricks);
                }
            }
              
            // Make sure that the bricks won't move
            this.bricks.setAll('body.immovable', true);
        },
    
        hit: function (ball, brick) {
            "use strict";
            brick.kill();
            this.velocidad();
            contador--;
        },
    
        velocidad: function () {
            this.ball.body.velocity.x = this.ball.body.velocity.x + 20;
            this.ball.body.velocity.y = this.ball.body.velocity.y + 20;
        }
    };

// Initialize Phaser, and start our 'main' state 
var game = new Phaser.Game(400, 450, Phaser.AUTO, 'gameDiv');
game.state.add('main', main);
game.state.start('main');