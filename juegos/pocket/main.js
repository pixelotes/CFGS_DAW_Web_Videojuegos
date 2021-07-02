var Phaser;
var mainmenu;
var maingame;
var victoryscreen;
var gameloader;
var boot;
var result;
var lives = 3;
var projType = 1;
var nextProjType = 1;
var numProjectiles = 14;

// *****************
// * THE MAIN MENU *
// *****************

var mainmenu = {

    preload: function () {
        "use strict";



    },

    create: function () {
        "use strict";

        //set background color
        game.stage.backgroundColor = 0x337799;

        this.titlemusic = this.game.add.audio('titlemusic');
        //SCROLLING BACKGROUND
        this.scrollingbg = this.game.add.tileSprite(0, 0, 400, 300, 'colorblocks');
        this.scrollingbg.autoScroll(-10, -10);
        this.scrollingbg.alpha = 0.8;


        //MAIN PANEL
        this.titlepanel = this.game.add.sprite(0, 0, 'titlepanel');

        this.startButton = this.game.add.button(game.width / 2, game.height / 2 + 70, 'buttonPlay', this.startGame, this);
        this.creditsButton = this.game.add.button(game.width / 2 - 100, game.height / 2 + 70, 'buttonCredits', this.showCreditsPanel, this);
        this.helpButton = this.game.add.button(game.width / 2 + 100, game.height / 2 + 70, 'buttonHelp', this.showHelpPanel, this);

        this.startButton.anchor.setTo(0.5, 0.5);
        this.creditsButton.anchor.setTo(0.5, 0.5);
        this.helpButton.anchor.setTo(0.5, 0.5);

        this.startButton.scale.x = 0.7;
        this.startButton.scale.y = 0.7;
        this.creditsButton.scale.x = 0.5;
        this.creditsButton.scale.y = 0.5;
        this.helpButton.scale.x = 0.5;
        this.helpButton.scale.y = 0.5;

        //HELP PANEL
        this.helpPanel = game.add.group();
        this.helpPanelBg = game.add.sprite(0, 0, 'helpPanel');
        this.helpPanel.add(this.helpPanelBg);
        this.helpBackButton = game.add.button(game.width / 2, game.height / 2 + 80, 'buttonBack', this.closePanels, this);
        this.helpBackButton.anchor.setTo(0.5, 0.5);
        this.helpBackButton.scale.x = 0.5;
        this.helpBackButton.scale.y = 0.5;
        this.helpPanel.add(this.helpBackButton);

        //CREDITS PANEL
        this.creditsPanel = game.add.group();
        this.creditsPanelBg = game.add.sprite(0, 0, 'creditsPanel');
        this.creditsPanel.add(this.creditsPanelBg);
        this.creditsBackButton = game.add.button(game.width / 2, game.height / 2 + 80, 'buttonBack', this.closePanels, this);
        this.creditsBackButton.anchor.setTo(0.5, 0.5);
        this.creditsBackButton.scale.x = 0.5;
        this.creditsBackButton.scale.y = 0.5;
        this.creditsPanel.add(this.creditsBackButton);

        //CLOSE CREDITS AND HELP PANEL BEFORE BEGINNING
        this.closePanels();

        this.titlemusic.play('');
    },

    //closes help & credits panel
    closePanels: function () {
        this.helpPanel.setAll('visible', false);
        this.creditsPanel.setAll('visible', false);
    },

    //shows the help panel
    showHelpPanel: function () {
        this.helpPanel.setAll('visible', true);
    },

    //shows the credits panel
    showCreditsPanel: function () {
        this.creditsPanel.setAll('visible', true);
    },

    update: function () {
        "use strict";


    },

    //starts the main state
    startGame: function () {
        "use strict";
        lives = 3;
        this.titlemusic.stop();
        game.sound.stopAll(); //this should work on Chrome
        this.game.state.start('maingame', true, false);
    }
};

// *****************
// * THE MAIN GAME *
// *****************

var maingame = {
    preload: function () {
        "use strict";

        this.preloadBar = this.add.sprite(0, 0, 'preloaderBar');

        this.load.setPreloadSprite(this.preloadBar);
        //Load the assets

        //Load the assets

    },

    create: function () {
        "use strict";

        this.preloadBar.kill();

        //blue background
        game.stage.backgroundColor = 0x337799;

        //the projectile power bar
        this.powerbar = 0;

        //only 1 projectile at a time
        this.allowShoot = true;

        //Initialize physics engine

        
        this.gamebg2 = this.game.add.tileSprite(0, 0, 512, 432, 'gamebg2');
        this.gamebg = this.game.add.tileSprite(0, 0, 512, 432, 'gamebg');
        this.gamebg0 = this.game.add.tileSprite(0, 0, 512, 432, 'gamebg0');
        
        this.gamebg2.fixedToCamera = true;
        this.gamebg.fixedToCamera = true;
        this.gamebg0.fixedToCamera = true;
        this.game.physics.startSystem(Phaser.Physics.ARCADE);

        //Initialize keys
        this.cursor = this.game.input.keyboard.createCursorKeys();

        //Groups for rendering order
        this.bgGrp = this.game.add.group(); //background
        this.foreGrp = this.game.add.group(); //foreground (tiles with collisions)
        this.charGrp = this.game.add.group(); //player
        this.enemyGrp = this.game.add.group(); //enemy group
        this.enemyGrp2 = this.game.add.group(); //enemy group 2
        this.enemyGrp3 = this.game.add.group(); //enemy group 3
        this.enemyGrp3 = this.game.add.group(); //enemy group 3
        this.miscGrp = this.game.add.group(); //plants, trees, etc (tiles without collisions)
        this.projGrp = this.game.add.group(); //projectiles
        this.triggerGrp = this.game.add.group(); //enemy trigger
        this.flagGrp = this.game.add.group(); //enemy trigger
        this.uiGrp = this.game.add.group(); //the ui, should be on top


        //this.bgGrp.add(this.gamebg);
        //this.bgGrp.add(this.gamebg2);


        this.createWorld(); //this method creates the world from a tiled map in JSON format

        this.spawnEntities(); //this method spawns the player. Should be combined with setEnemies() if I have time

        this.createFloor();

        this.setPhysics(); //this method set the physics properties for all the elements in the game

        this.setEnemies(); //this method sets the enemy behavior

        this.createUI(); //this method creates the power bar

        this.emitter = game.add.emitter(0, 0, 100); //this will be the blood emitter

        //when releasing space it reads the power bar value and toss the projectile
        this.game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR).onUp.add(this.tossProjectile, this);

        this.game.camera.follow(this.player);

        //create sounds
        this.sfxtoss = this.game.add.audio('sfxtoss');
        this.sfxjump = this.game.add.audio('sfxjump');
        this.sfxexplode = this.game.add.audio('sfxexplode');
        this.sfxhit = this.game.add.audio('sfxhit');
        this.sfxhurt = this.game.add.audio('sfxhurt');
        this.ingamemusic = this.game.add.audio('ingamemusic');

        this.ingamemusic.stop();
        game.sound.stopAll();
        this.ingamemusic.play('', null, 10, true);

    },

    update: function () {
        "use strict";

        //audio fix for Chrome
        this.ingamemusic.onStop.addOnce(function () {
            this.ingamemusic.play();
        }, this);

        //parallax
        
        //this.gamebg2.tilePosition.set(-game.camera.x * 0.1, -game.camera.y * 0.1); vert parallax, bg should be taller than screen
        this.gamebg2.tilePosition.set(-game.camera.x * 0.1, 0);
        this.gamebg.tilePosition.set(-game.camera.x * 0.2, 0);
        this.gamebg0.tilePosition.set(-game.camera.x * 0.3, 0);

        if (this.projObj) {
            this.projObj.angle += 5;
        } //rotates the projectile (if exists) 5 degrees per frame
        else {
            this.allowShoot = true;
        }


        if (this.allowShoot) {
            this.allowCircle.loadTexture('ok');
        } else {
            this.allowCircle.loadTexture('notok');
        }

        if (this.powerbar > 50) {
            this.powerbar = 50;
        } //if powerbar variable is higher than 50 then it sets to 50. Otherwise tossing a projectile with unlimited strength is fun

        this.bar.scale.x = this.powerbar; //scales the gui power bar according to the value of the powerbar variable (goes from 0 to 50);

        //Collision checking
        this.game.physics.arcade.collide(this.player, this.layer, function () {
            this.player.isTouchingFloor = true;
        }, null, this); //player vs floor
        this.game.physics.arcade.collide(this.layer, this.player, function () {
            this.player.isTouchingFloor = true;
        }, null, this); //floor vs player
        this.game.physics.arcade.collide(this.projObj, this.layer, this.projHit, null, this); //projectiles vs floors
        this.game.physics.arcade.collide(this.enemyGrp, this.triggerGrp, this.reverseFacing, null, this); //enemies vs invisible walls
        this.game.physics.arcade.collide(this.enemyGrp3, this.triggerGrp, this.reverseFacing, null, this); //enemies vs invisible walls
        this.game.physics.arcade.collide(this.layer, this.enemyGrp, null, null, this); //enemies vs floor
        this.game.physics.arcade.collide(this.layer, this.enemyGrp2, this.enemyJump, null, this); //enemies vs floor
        this.game.physics.arcade.overlap(this.projObj, this.enemyGrp, this.enemyHit, null, this); //projectile vs enemies
        this.game.physics.arcade.overlap(this.projObj, this.enemyGrp2, this.enemyHit, null, this); //projectile vs enemies
        this.game.physics.arcade.overlap(this.projObj, this.enemyGrp3, this.enemyHit, null, this); //projectile vs enemies
        this.game.physics.arcade.overlap(this.emitter, this.layer, null, null, this); //blood particles vs floor
        this.game.physics.arcade.collide(this.player, this.enemyGrp, this.playerHit, null); //player vs enemies
        this.game.physics.arcade.collide(this.player, this.enemyGrp2, this.playerHit, null); //player vs enemies
        this.game.physics.arcade.collide(this.player, this.enemyGrp3, this.playerHit, null); //player vs enemies
        this.game.physics.arcade.collide(this.player, this.floorLine, this.playerHit, null); //player vs out of bounds
        this.game.physics.arcade.collide(this.player, this.flagGrp, this.victory, null); //player vs exit

        //With this we ensure that we won't be able to jump mid-air
        //you can try disabling it for fun :-)
        if (this.player.body.velocity.y != 0) {
            this.player.isTouchingFloor = false;
        };

        //Cursor keys
        //left
        if (this.cursor.right.isDown) {
            this.player.body.velocity.x = 150;
            if (this.player.isLookingLeft) {
                this.player.scale.x *= -1; //change player facing to right
                this.player.isLookingLeft = false;
            }
        }
        //right
        else if (this.cursor.left.isDown) {
            this.player.body.velocity.x = -150;
            if (!this.player.isLookingLeft) {
                this.player.scale.x *= -1; //change player facing to left
                this.player.isLookingLeft = true;
            }
        }
        //idle
        else {
            this.player.body.velocity.x = 0;
        }
        
        //up (jump)
        if (this.cursor.up.isDown && this.player.body.blocked.down) {
            this.player.body.velocity.y = -220;
            this.player.isTouchingFloor = false; //So we can't jump again until we hit floor again. Double jump anyone?
            this.sfxjump.play('');
        }
        

        //power bar fills while space bar is pressed
        if (game.input.keyboard.isDown(Phaser.Keyboard.SPACEBAR)) {
            this.powerbar = this.powerbar + 1;
        } else {
            //empties power bar if space not pressed
            if (this.powerbar > 0) {
                this.powerbar = this.powerbar - 1;
            }
        }

    },

    enemyJump: function (enemy) {
        if (enemy.body.blocked.down) {
            enemy.body.velocity.y = -220;
        }
    },

    //this method creates the world from a json map
    createWorld: function () {
        "use strict";

        //creates the map
        this.map = this.game.add.tilemap('testmap');
        this.map.addTilesetImage('pstiles', 'testtiles');

        //creates the layers (map has 3 layers)
        this.layer = this.map.createLayer(0); //foreground
        this.layer2 = this.map.createLayer(1); //background
        this.layer3 = this.map.createLayer(2); //water
        this.foreGrp.add(this.layer);
        this.bgGrp.add(this.layer2);

        //set tile collisions
        this.map.setCollisionByExclusion([44, 3], true);
        this.layer.enableBody = true;
        this.layer.resizeWorld();

        //this one is tricky. As phaser only allows collision with ONE layer, I set invisible walls and enemy spawns in separate object layers.
        //these methods find tiles with a custom 'type' field inside an object layer, turns them into objects and adds then into a group
        //createItems(customPropertyName, objectLayerName, existingGroupWhereObjectsWillBeAdded, imageForTheCreatedObjects);
        //these methods are taken and modified from the 'Top down games with Phaser' tutorial: http://goo.gl/rAQLaz

        this.createItems('enemytrg', 'triggers', this.triggerGrp, 'trgicon'); //we search for all objects inside "triggers" layer with custom property 'type' set to 'enemytrg'
        this.createItems('enemy', 'enemies', this.enemyGrp, 'testenemy'); //we search for all objects inside "enemies" layer with custom property 'type' set to 'testenemy'
        this.createItems('enemy2', 'enemies', this.enemyGrp2, 'testenemy2');
        this.createItems('enemy3', 'enemies', this.enemyGrp3, 'testenemy3');
        this.createItems('flag', 'flag', this.flagGrp, 'flag');

        this.triggerGrp.setAll('body.immovable', true); //we set the invisible walls to immovable. Otherwise they'll bounce when hit by an enemy.
        this.triggerGrp.setAll('alpha', 0); //of course, we don't want the player to see them, so we make them invisible

        //this.flag = game.add.sprite(2192, 368, 'flag');
        this.game.physics.enable(this.flagGrp, Phaser.Physics.ARCADE);
        this.flagGrp.setAll('body.allowGravity', false);
        this.flagGrp.setAll('body.immovable', true);

        this.createGameOverPanel();
        this.createVictoryPanel();
        this.closePanels();
    },

    tossProjectile: function () {
        "use strict";
        if (this.allowShoot) {
            var temp = Math.floor(Math.random() * numProjectiles + 1);
            if (temp > numProjectiles) {
                temp = numProjectiles
            };
            this.projObj = this.game.add.sprite(this.player.x, this.player.y, 'projectile' + temp);

            this.projObj.anchor.setTo(0.5, 0.5);
            this.projObj.parType = temp;
            this.game.physics.enable(this.projObj, Phaser.Physics.ARCADE);
            this.projObj.body.allowGravity = true;
            if (this.powerbar > 30) {
                this.powerbar = 30;
            }

            if (this.player.isLookingLeft == false) {
                this.projObj.body.velocity.x = this.powerbar * 5 + 50;
            } else {
                this.projObj.body.velocity.x = -(this.powerbar * 5 + 50);
            }

            this.projObj.body.velocity.y = -10 * (this.powerbar / 2) - 100;
            this.projObj.body.gravity.y = 400;

            //check if projectile is out of bounds
            this.projObj.events.onOutOfBounds.add(this.projOOB, this);
            this.projObj.checkWorldBounds = true;

            this.projGrp.add(this.projObj);
            this.powerbar = 0;

            this.allowShoot = false;

            this.sfxtoss.play('');

        }
    },

    //if a projectile is out of bounds, it is destroyed and player is allowed to shoot again
    projOOB: function (proj) {
        proj.kill();
        this.allowShoot = true;
    },

    reverseFacing: function (a, b, vel) {
        if (!a.isFacingLeft) {
            a.body.velocity.x = -20;
            a.scale.x *= -1;
        } else {
            a.body.velocity.x = 20;
            a.scale.x *= -1;
        }
        a.isFacingLeft = !a.isFacingLeft;
    },

    enemyHit: function (a, b, parType) {
        this.createExplosion(a.x, a.y);
        this.createBlood(a.x, b.y, a.parType);
        a.kill();
        b.kill();
        this.allowShoot = true;
    },

    setEnemies: function () {
        this.enemyGrp.setAll('isFacingLeft', false);
        this.enemyGrp.setAll('body.velocity.x', 20);
        this.enemyGrp.setAll('anchor.setTo', (0.5, 0.5));
        this.enemyGrp2.setAll('isFacingLeft', true);
        this.enemyGrp2.setAll('anchor.setTo', (0.5, 0.5));
        this.enemyGrp2.setAll('isTouchingFloor', true);

        this.enemyGrp3.setAll('isFacingLeft', true);
        this.enemyGrp3.setAll('body.velocity.x', -35);
        this.enemyGrp3.setAll('anchor.setTo', (0.5, 0.5));

    },

    //what happens when a projectile hits the floor
    projHit: function (prj, til) {
        "use strict";

        this.createExplosion(prj.x, prj.y);
        prj.kill();
        this.allowShoot = true;
    },

    createExplosion: function (cX, cY) {
        "use strict";

        var expl = game.add.sprite(cX, cY, 'xplosion');
        var anim = expl.animations.add('boom');
        anim.killOnComplete = true;
        anim.onComplete.add(function () {

        }, expl);
        anim.play(11);
        this.sfxexplode.play('');
    },

    createBlood: function (cX, cY, parType) {
        //this.emitter.kill();
        this.emitter = game.add.emitter(0, 0, 100);
        this.emitter.x = cX;
        this.emitter.y = cY;
        this.emitter.makeParticles('particle' + parType);
        this.emitter.gravity = 100;
        this.emitter.start(true, 2000, null, Math.floor(Math.random() * 10 + 5));
    },

    spawnEntities: function () {
        "use strict";

        //Spawns the player
        this.player = this.game.add.sprite(64, 320, 'testchar');
        this.player.anchor.setTo(0.5, 0.5);
        this.player.isLookingLeft = false;
        this.player.isTouchingFloor = false;

        this.charGrp.add(this.player);
    },

    setPhysics: function () {
        "use strict";

        this.game.physics.enable(this.player, Phaser.Physics.ARCADE);
        this.player.body.collideWorldBounds = true;
        this.player.body.allowGravity = true;
        this.game.physics.enable(this.player, Phaser.Physics.ARCADE);
        this.game.physics.enable(this.layer, Phaser.Physics.ARCADE);
        this.game.physics.enable(this.enemyGrp, Phaser.Physics.ARCADE);
        this.game.physics.enable(this.enemyGrp2, Phaser.Physics.ARCADE);
        this.game.physics.enable(this.enemyGrp3, Phaser.Physics.ARCADE);
        this.enemyGrp.enableBody = true;
        this.enemyGrp2.enableBody = true;
        this.enemyGrp3.enableBody = true;
        this.player.body.gravity.y = 400;
        this.enemyGrp.setAll('body.gravity.y', 400);
        this.enemyGrp2.setAll('body.gravity.y', 400);
        this.enemyGrp3.setAll('body.allowGravity', false);
        this.game.physics.enable(this.floorLine, Phaser.Physics.ARCADE);
        this.floorLine.enableBody = true;
        this.floorLine.body.immovable = true;
    },

    createItems: function (type, layer, group, icon) {
        //create items
        this.triggerGrp.enableBody = true;
        var item;
        result = this.findObjectsByType(type, this.map, layer);
        result.forEach(function (element) {
            this.createFromTiledObject(element, group, icon);
        }, this);
    },

    findObjectsByType: function (type, map, layer) {
        var result = new Array();
        map.objects[layer].forEach(function (element) {
            if (element.properties.type === type) {
                //Phaser uses top left, Tiled bottom left so we have to adjust the y position
                //also keep in mind that the cup images are a bit smaller than the tile which is 16x16
                //so they might not be placed in the exact pixel position as in Tiled
                element.y -= map.tileHeight;
                result.push(element);
            }
        });
        return result;
    },

    createFromTiledObject: function (element, group, icon) {
        var sprite = group.create(element.x, element.y, icon);
        sprite.anchor.setTo(0.5, 0.5);
        //copy all properties to the sprite
        Object.keys(element.properties).forEach(function (key) {
            sprite[key] = element.properties[key];
        });
    },

    createUI: function () {
        this.graphics = game.add.graphics(20, 20);
        this.graphics.lineStyle(2, 0xe7481c, 1);
        this.graphics.drawRect(0, 0, 102, 20);

        this.bar = game.add.graphics(21, 21);
        this.bar.lineStyle(1, 0xf0b13c, 1);
        this.bar.drawRect(0, 0, 1, 17);

        this.livesCounter = game.add.sprite(320, 21, 'lives' + lives);
        this.livesCounter.visible = true;

        this.allowCircle = game.add.sprite(126, 22, 'ok');
        this.allowCircle.visible = true;

        this.uiGrp.add(this.graphics);
        this.uiGrp.add(this.allowCircle);
        this.uiGrp.add(this.bar);
        this.uiGrp.add(this.livesCounter);
        this.uiGrp.setAll('fixedToCamera', true);


    },

    playerHit: function () {
        game.sound.stopAll();

        if (lives === 0) {
            //TODO: load a proper game over screen
            this.goPanelBg = game.add.sprite(0, 150, 'gameover');
            this.goBackButton = game.add.button(game.width / 2, game.height / 2 + 180, 'buttonBack', function () {
                game.state.start('mainmenu');
            }, this);
            this.goBackButton.anchor.setTo(0.5, 0.5);
            this.goBackButton.scale.x = 0.5;
            this.goBackButton.scale.y = 0.5;
            //alert("GAME OVER");
            //lives = 3;
            //game.state.start('maingame');

        } else {
            lives--;
            game.state.start('maingame');
        }
    },

    createFloor: function () {
        this.floorLine = game.add.sprite(0, 420, 'floorline');
        this.floorLine.alpha = 0;

    },

    createGameOverPanel: function () {
        //GAME OVER PANEL
        this.goPanel = game.add.group();
        this.goPanelBg = game.add.sprite(0, 150, 'gameover');
        this.goPanel.add(this.goPanelBg);
        this.goBackButton = game.add.button(game.width / 2, game.height / 2 + 180, 'buttonBack', this.closePanels, this);
        this.goBackButton.anchor.setTo(0.5, 0.5);
        this.goBackButton.scale.x = 0.5;
        this.goBackButton.scale.y = 0.5;
        this.goPanel.add(this.goBackButton);
    },

    createVictoryPanel: function () {
        //VICTORY PANEL
        this.vicPanel = game.add.group();
        this.vicPanelBg = game.add.sprite(0, 150, 'victory');
        this.vicPanel.add(this.vicPanelBg);
        this.vicBackButton = game.add.button(game.width / 2, game.height / 2 + 180, 'buttonBack', this.closePanels, this);
        this.vicBackButton.anchor.setTo(0.5, 0.5);
        this.vicBackButton.scale.x = 0.5;
        this.vicBackButton.scale.y = 0.5;
        this.vicPanel.add(this.vicBackButton);
    },

    //Sets both victory and gameover panels to invisible
    closePanels: function () {
        this.goPanel.setAll('visible', false);
        this.vicPanel.setAll('visible', false);
    },

    //shows the game over panel
    openGameOverPanel: function () {
        this.goPanel.setAll('visible', true);
    },

    //shows the victory panel
    openVictoryPanel: function () {
        this.vicPanel.setAll('visible', true);
    },

    //you won! stops.wa
    victory: function () {

        game.sound.stopAll(); //stops all sounds so when we go back to main menu the ingame music stops
        //alert("YOU DID IT!"); //for some reason game crashes when showing panels. I'll look at it later.
        game.state.start("victoryscreen");
    }
};

var victoryscreen = {

    preload: function () {
        
    },

    create: function () {
        game.sound.stopAll();
        game.stage.backgroundColor = 0x000000;
        this.panelBg = game.add.sprite(0, 0, 'victory');
        this.backButton = game.add.button(game.width / 2, game.height / 2 + 50, 'buttonBack', function () {
            game.state.start("mainmenu");
        }, this);
        this.backButton.anchor.setTo(0.5, 0.5);
        this.backButton.scale.x = 0.5;
        this.backButton.scale.y = 0.5;
    },

    update: function () {}
};

var boot = {

    preload: function () {
        game.load.image('preloaderBar', 'assets/gfx/loaderbar.png');
    },

    create: function () {

        game.state.start('gameloader');
    },

    update: function () {}
};

var gameloader = {

    preload: function () {
        this.preloadBar = this.add.sprite(0, 0, 'preloaderBar');
        
        game.load.image('victory', 'assets/gfx/victory.png');
        game.load.image('buttonBack', 'assets/gfx/back.png');
        this.load.setPreloadSprite(this.preloadBar);
        game.load.tilemap('testmap', 'assets/maps/testmap.json', null, Phaser.Tilemap.TILED_JSON);
        game.load.image('testtiles', 'assets/tilemaps/pstiles.png', 16, 16);
        game.load.image('gamebg', 'assets/gfx/bg1.png', 400, 300);
        game.load.image('gamebg2', 'assets/gfx/bg2.png', 400, 300);
        game.load.image('gamebg0', 'assets/gfx/bg0.png', 400, 300);
        game.load.image('testchar', 'assets/gfx/testchar.png');
        game.load.image('testenemy', 'assets/gfx/testenemy.png');
        game.load.image('testenemy2', 'assets/gfx/testenemy2.png');
        game.load.image('testenemy3', 'assets/gfx/testenemy3.png');
        game.load.image('projectile', 'assets/gfx/projectile.png');
        game.load.image('trgicon', 'assets/gfx/trigger.png');
        game.load.image('blood', 'assets/gfx/blood.png');
        game.load.image('floorline', 'assets/gfx/floorline.png');
        game.load.spritesheet('xplosion', 'assets/gfx/explosion.png', 16, 16, 11);
        game.load.image('projectile1', 'assets/gfx/projectile1.png');
        game.load.image('projectile2', 'assets/gfx/projectile2.png');
        game.load.image('projectile3', 'assets/gfx/projectile3.png');
        game.load.image('projectile4', 'assets/gfx/projectile4.png');
        game.load.image('projectile5', 'assets/gfx/projectile5.png');
        game.load.image('projectile6', 'assets/gfx/projectile6.png');
        game.load.image('projectile7', 'assets/gfx/projectile7.png');
        game.load.image('projectile8', 'assets/gfx/projectile8.png');
        game.load.image('projectile9', 'assets/gfx/projectile9.png');
        game.load.image('projectile10', 'assets/gfx/projectile10.png');
        game.load.image('projectile11', 'assets/gfx/projectile11.png');
        game.load.image('projectile12', 'assets/gfx/projectile12.png');
        game.load.image('projectile13', 'assets/gfx/projectile13.png');
        game.load.image('projectile14', 'assets/gfx/projectile14.png');
        game.load.image('particle1', 'assets/gfx/particle1.png');
        game.load.image('particle2', 'assets/gfx/particle2.png');
        game.load.image('particle3', 'assets/gfx/particle3.png');
        game.load.image('particle4', 'assets/gfx/particle4.png');
        game.load.image('particle5', 'assets/gfx/particle5.png');
        game.load.image('particle6', 'assets/gfx/particle6.png');
        game.load.image('particle7', 'assets/gfx/particle7.png');
        game.load.image('particle8', 'assets/gfx/particle8.png');
        game.load.image('particle9', 'assets/gfx/particle9.png');
        game.load.image('particle10', 'assets/gfx/particle10.png');
        game.load.image('particle11', 'assets/gfx/particle11.png');
        game.load.image('particle12', 'assets/gfx/particle12.png');
        game.load.image('particle13', 'assets/gfx/particle13.png');
        game.load.image('particle14', 'assets/gfx/particle14.png');
        game.load.image('lives3', 'assets/gfx/lives3.png');
        game.load.image('lives2', 'assets/gfx/lives2.png');
        game.load.image('lives1', 'assets/gfx/lives1.png');
        game.load.image('lives0', 'assets/gfx/lives0.png');
        game.load.image('flag', 'assets/gfx/flag.png');
        game.load.image('ok', 'assets/gfx/ok.png');
        game.load.image('notok', 'assets/gfx/notok.png');
        game.load.image('gameover', 'assets/gfx/gameover.png');
        game.load.image('victory', 'assets/gfx/victory.png');
        game.load.image('buttonBack', 'assets/gfx/back.png');
        game.load.bitmapFont('thefont', 'assets/font/flappyfont.png', 'assets/font/flappyfont.fnt');
        game.load.audio('sfxtoss', 'assets/sfx/toss.mp3');
        game.load.audio('sfxjump', 'assets/sfx/jump.mp3');
        game.load.audio('sfxexplode', 'assets/sfx/explode.mp3');
        game.load.audio('sfxcharge', 'assets/sfx/charge.mp3');
        game.load.audio('sfxhit', 'assets/sfx/hit.mp3');
        game.load.audio('sfxhurt', 'assets/sfx/hurt.mp3');
        game.load.audio('ingamemusic', 'assets/music/ingame.mp3');
        game.load.image('colorblocks', 'assets/tilemaps/color_blocks.png', 16, 16);
        game.load.image('titlepanel', 'assets/gfx/title.png');
        game.load.image('buttonPlay', 'assets/gfx/buttonPlay.png');
        game.load.image('buttonHelp', 'assets/gfx/buttonHelp.png');
        game.load.image('buttonCredits', 'assets/gfx/buttonCredits.png');
        game.load.image('helpPanel', 'assets/gfx/help.png');
        game.load.image('creditsPanel', 'assets/gfx/credits.png');
        game.load.image('buttonBack', 'assets/gfx/back.png');
        game.load.audio('titlemusic', 'assets/music/title.mp3');

    },

    create: function () {
        this.preloadBar.kill();
        game.state.start('mainmenu');
    },

    update: function () {}
};

// Initialize Phaser, and start our 'main' state 
var game = new Phaser.Game(400, 300, Phaser.AUTO, 'gameDiv');
game.state.add('boot', boot);
game.state.add('mainmenu', mainmenu);
game.state.add('maingame', maingame);
game.state.add('gameloader', gameloader);
game.state.add('victoryscreen', victoryscreen);
game.state.start('boot');