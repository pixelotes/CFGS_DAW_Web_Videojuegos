var Phaser;
var game;
var contador = 25;
var puntos = 0;
var nivel = 1;
var vidas = 3;
var velocidadPaleta = 350;
var velocidadBola = 200;
var colores = ['0x00217a','0x09ad7e','0xff0000','0xf89d54','0xcddcd5'];
// Define our main state
var main = {
        preload: function () {
            "use strict";
            game.load.image('paddle', 'assets/paddle.png');
            game.load.image('brick', 'assets/brick.png');
            game.load.image('ball', 'assets/ballrnd.png');
            game.load.image('background', 'assets/tile.png');
        },

        create: function () {
            
            //Resetea velocidad bola
            //velocidadBola = 200 + (nivel * 20);
            this.background = game.add.tileSprite(0, 0, 500, 500, "background");
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
            
            this.ball.body.velocity.x = velocidadBola;
            this.ball.body.velocity.y = velocidadBola;
            
            //Rebotes
            this.ball.body.collideWorldBounds = true;
            this.ball.body.bounce.x = 1;
            this.ball.body.bounce.y = 1;
            
            //Crea ladrillos
            this.createWorld();
            
            this.paddle.body.immovable = true;
            var tmp = puntos.toString();
            this.marcador = game.add.text(0,0,"Puntos: "+tmp,{ font: "30px Arial", fill: "#ffffff", align: "center" });
            this.vidas = game.add.text(game.width-130,0,"Vidas x "+vidas,{ font: "30px Arial", fill: "#ffffff", align: "center" });
        },

        update: function () {
            "use strict";
            
            game.physics.arcade.collide(this.paddle, this.ball, null, null, this);
            
            game.physics.arcade.collide(this.ball, this.bricks, this.hit, null, this);
            
            if (this.cursor.right.isDown) {
                this.paddle.body.velocity.x = velocidadPaleta;
            } else if (this.cursor.left.isDown) {
                this.paddle.body.velocity.x = -velocidadPaleta;
            } else {
                this.paddle.body.velocity.x = 0;
            }
            
            if (contador === 0) {
                contador = 25;
                nivel++;
                //game.state.start('main');
                this.createWorld();
            }
            
            if (this.ball.y >= (this.paddle.y+25)) {
				vidas--;
				if(vidas<0) {
					this.guardaPuntuacion();
					puntos = 0;
					vidas=3;
					game.state.start('main');
				} else {
					var texto = "Vidas x "+vidas;
					this.vidas.text = texto;
					this.ball.position.x = 200;
					this.ball.position.y = 300;
					//this.ball.velocity.y = velocidadBola;
				}
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
                    var spritetmp = 
                    game.add.sprite(55+i*60, 55+j*35, 'brick', 0, this.bricks).tint = colores[j];
                }
            }
              
            // Make sure that the bricks won't move
            this.bricks.setAll('body.immovable', true);
        },
    
        hit: function (ball, brick) {
            "use strict";
            brick.kill();
            //Aumenta la velocidad de la bola con cada ladrillo destruido
            //this.velocidad();
            contador--;
            puntos += 10;
            var textotmp = puntos.toString();
            var texto = "Puntos: "+textotmp;
            this.marcador.text = texto;
        },
    
        velocidad: function () {
            velocidadBola += 10;
            this.ball.body.velocity.x = velocidadBola;
            this.ball.body.velocity.y = velocidadBola;
        },
        
        
    guardaPuntuacion: function () {

        $.ajax({
            data: {
                "userid": parent.document.getElementById('userid').value,
                "idjuego": 4,
                "puntuacion": puntos,
                "dificultad": 1,
                "guardar": "ok"
            },
            url: '//localhost/prj/puntuaciones.php',
            type: 'post',
            beforeSend: function () {
                //alert("antes");
            },
            success: function (response) {
                parent.refreshRanking();
            }
        });

    },
        
    };

// Initialize Phaser, and start our 'main' state 
var game = new Phaser.Game(400, 450, Phaser.AUTO, 'gameDiv');
game.state.add('main', main);
game.state.start('main');