window.onload = function () {

    //crea el juego
    var game = new Phaser.Game(512, 512, Phaser.AUTO, "game", {
        preload: onPreload,
        create: onCreate,
        update: onUpdate
    });
    game.state.add('main', game);

    //variables
    var ball;
    var level = 1;
    var lives = 3;
    var title;
    var matriz;
    var startX;
    var startY;
    var backgroundGroup;
    var wallGroup;
    var spikeGroup;
    var holeGroup;
    var obj;
    var totalLevels=5;

    //funcion que se ejecuta en la precarga
    function onPreload() {
        game.load.image('ball', 'assets/ball-medium.png');
        game.load.text('level1', 'assets/lvl1.txt');
        game.load.text('level2', 'assets/lvl2.txt');
        game.load.text('level3', 'assets/lvl3.txt');
        game.load.text('level4', 'assets/lvl4.txt');
        game.load.text('level5', 'assets/lvl5.txt');
        game.load.image('wall', 'assets/wall.png');
        game.load.image('background', 'assets/bg.png');
        game.load.image('hole', 'assets/hole.png');
        game.load.image('spikesr', 'assets/spikesr.png');
        game.load.image('spikesd', 'assets/spikesd.png');
        game.load.image('spikesl', 'assets/spikesl.png');
        game.load.image('spikesu', 'assets/spikesu.png');
    }

    //escala el juego a pantalla completa
    function goFullScreen() {
        game.scale.pageAlignHorizontally = true;
        game.scale.pageAlignVertically = true;
        game.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
        game.scale.setScreenSize(true);
    }

    //funcion principal del juego
    function onCreate() {
		
		game.stage.backgroundColor = 0xffffff;
        //iniciar sistema de fisicas
        game.physics.startSystem(Phaser.Physics.ARCADE);
        
        goFullScreen(); //pantalla completa
        cursor = game.input.keyboard.createCursorKeys();
        
        //creamos los grupos en orden de renderizado
        backgroundGroup = game.add.group();
        wallGroup = game.add.group();
        spikeGroup = game.add.group();
        holeGroup = game.add.group();
        
        makeLevel(); //crea el nivel a partir de un archivo de texto
        
        makeUI(); //crea el marcador
        
        ball = game.add.sprite(startX,startY,'ball');
        ball.anchor.setTo(0.5, 0.5);
        game.physics.arcade.enable(ball);
        ball.body.bounce.set(0.4);
        
        //controles giroscopio
        gyro.frequency = 10;
        //iniciar detección giroscopio
        gyro.startTracking(function (o) {
            //valocidad de jugador
            ball.body.velocity.x += o.gamma / 4;
            ball.body.velocity.y += o.beta / 4
        });
    }
    
    function makeSprite(coordX,coordY,resource,center,physics,gravity,immovable){
        this.spr = game.add.sprite(coordX,coordY,resource);
        if(center){this.spr.anchor.setTo(0.5,0.5)};
        if(physics){game.physics.arcade.enable(this.spr)};
        if(gravity){this.spr.body.allowGravity = true};
        if(immovable){this.spr.body.immovable = true};
    }

    function onUpdate() {
        
        //arcade.collide(objeto,objeto,funcion,[callback]);
        game.physics.arcade.collide(ball, wallGroup);
        game.physics.arcade.collide(ball, holeGroup, endLevel);
game.physics.arcade.collide(ball, spikeGroup, restart);
        
        //controles cursor
        if (cursor.right.isDown) {
            ball.body.velocity.x += 10;
        } else if (cursor.left.isDown) {
            ball.body.velocity.x -= 10;
        } else if (cursor.up.isDown) {
            ball.body.velocity.y -= 10;
        } else if (cursor.down.isDown) {
            ball.body.velocity.y += 10;
        }
    }
    
    //crea el marcador con los datos obtenidos al cargar nivel
    function makeUI() {
        var style = { font: "20px Arial", fill: "#ff0044", align: "center", fontWeight: "bolder" };
        var t = game.add.text(0, 10, level+" - "+title, style);
    }

    //crea el nivel a partir de los datos cargados (ver format.txt y template.txt)
    function makeLevel() {
        currLevel = game.cache.getText('level'+level);
        currLevel = currLevel.replace(/\s+/g, ' ').trim();
        matriz = currLevel.split(";");
        for(i=4;i<matriz.length;i++){
            var linea = matriz[i];
            var linea2 = linea.split("");
            title = matriz[0];
            for(j=0;j<linea2.length;j++){
                //tiles fondo
                if(linea2[j]==0){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'background',0,backgroundGroup);
                } 
                //tiles muro
                else if (linea2[j]==1){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'wall',0,wallGroup);
                } 
                //tiles pinchos der
                else if (linea2[j]==3){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'background',0,backgroundGroup);
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'spikesl',0,spikeGroup);
                }
                //tiles pinchos abajo
                else if (linea2[j]==4){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'background',0,backgroundGroup);
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32+16),'spikesd',0,spikeGroup);
                }
                //tiles pinchos izq
                else if (linea2[j]==5){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'background',0,backgroundGroup);
                    obj = game.add.sprite(0+(j*32)+16,32+((i-4)*32),'spikesr',0,spikeGroup);
                }
                //tiles pinchos arriba
                else if (linea2[j]==6){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'background',0,backgroundGroup);
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'spikesu',0,spikeGroup);
                }
                //tile posicion inicial
                else if (linea2[j]==8){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'background',0,backgroundGroup);
                    startX = 0+(j*32)+16;
                    startY = 0+((i-4)*32)+48;
                }
                //tile meta
                else if (linea2[j]==9){
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'background',0,backgroundGroup);
                    obj = game.add.sprite(0+(j*32),32+((i-4)*32),'hole',0,holeGroup);
                    game.physics.arcade.enable(holeGroup);
                    holeGroup.setAll('body.immovable', true);
                }
            }
        }
        
        //activa colisiones para los muros
        game.physics.arcade.enable(wallGroup);
        wallGroup.setAll('body.immovable', true);
        wallGroup.setAll('body.mass', 100);
        
        //activa colisiones para los pinchos
        game.physics.arcade.enable(spikeGroup);
        spikeGroup.setAll('body.immovable', true);
    }
    
    //reinicia el juego
    function restart() {
		lives--;
        game.world.removeAll(); //elimina todos los objetos del mundo
        onCreate(); //ejecuta de nuevo el método principal
    }

    function endLevel() {
        if(level<totalLevels){
            level++; //sube de nivel
            game.world.removeAll(); //elimina todos los objetos del mundo
            onCreate(); //vuelve a ejecutar el juego
        } else {
			level=1;
            //game.world.removeAll();
            if(alert("FIN DEL JUEGO")){
				game.state.start('main');
            }
            
        }

    }
}