var Phaser;
var game;
var gyro;
var contador = 25;
// Define our main state
var main = {
        preload: function () {
            "use strict";
            game.load.image('player', 'assets/player.png');
            game.load.image('platform', 'assets/platform.png');
            game.load.image('floor', 'assets/floor.png');
        },

        create: function () {
            "use strict";
            
            //evita que el centrado de la cámara de un salto al principio
            this.alturaCam = 999999;
            this.alturainic = this.game.height/2+80;
            this.anchoinic = this.game.width/2-50;
            
            //Inicializa motor físicas
            game.physics.startSystem(Phaser.Physics.ARCADE);
            game.physics.arcade.gravity.y=1200;
            
            //Inicializa teclas
            this.cursor = game.input.keyboard.createCursorKeys();
            
            this.plataformas = game.add.group();
            this.plataformas.enableBody = true;
            
            //Crea raqueta
            this.player = game.add.sprite(200, 400, 'player');
            this.player.tint = 0xcd0808;
            
            game.physics.arcade.enable(this.player);
            game.physics.arcade.enable(this.plataformas);
            game.physics.enable(this.player, Phaser.Physics.ARCADE);
            
            this.player.body.collideWorldBounds = true;
            this.player.body.checkCollision.up = false;
            this.player.body.checkCollision.left = false;
            this.player.body.checkCollision.right = false;

            this.game.camera.focusOnXY(0, this.player.position.y);
            //Position and size the world
            this.game.world.setBounds(0, this.windowHeight + this.player.position.y, this.game.width, this.windowHeight);
//Move the tilesprite (fixed to camera) depending on the player's position
            
            this.player.body.velocity.y = -600;
            
            this.suelo = game.add.sprite(0, this.game.height-1, 'floor');
            this.suelo.fixedToCamera = true;
            game.physics.arcade.enable(this.suelo);
            this.suelo.inmovable=true;
            this.suelo.gravity=false;
            
            //Crea plataformas iniciales
            this.createWorld();
            
        },

        update: function () {
            "use strict";

            game.physics.arcade.collide(this.player, this.plataformas, this.jump, null, this);
            game.physics.arcade.collide(this.suelo, this.plataformas, this.creaDestruye, null, this);
            
            this.alturaCam = Math.min(this.alturaCam, this.player.y - this.game.height/2);
            this.camera.y = this.alturaCam; 
            
            if (this.cursor.right.isDown) {
                this.player.body.velocity.x = 350;
            } else if (this.cursor.left.isDown) {
                this.player.body.velocity.x = -350;
            } else {
                this.player.body.velocity.x = 0;
            }
            
            if(this.player.y > this.alturaCam + this.game.height + 40) {
                this.restart();
            }
            

        },
    
        creaDestruye: function (suelo,plat) {
            plat.kill();
            this.randomPlat(this.game.rnd.integerInRange(0, this.game.width-50), this.alturaCam + this.alturainic + this.game.height/2);
        },
    
        createWorld: function () {
            "use strict";

            //Plataformas iniciales
            for(var i=0;i<=10;i++) {             
                this.randomPlat(this.anchoinic, this.alturainic);
                this.anchoinic = this.game.rnd.integerInRange(0, this.game.width-50)
                this.alturainic -= this.game.rnd.integerInRange(50,120);
            }         
        },
    
        randomPlat: function (x, y) {
            game.add.sprite(x, y, 'platform', 0, this.plataformas); 
            this.plataformas.setAll('body.immovable', true);
            this.plataformas.setAll('body.allowGravity', false);
        },
    
        //salto del jugador
        jump: function () {
            this.player.body.velocity.y = -700;
        },
    
        restart: function () {
            game.state.start('main');
        }
    };

// Initialize Phaser, and start our 'main' state 
var game = new Phaser.Game(400, 550, Phaser.AUTO, 'gameDiv');
game.state.add('main', main);
game.state.start('main');