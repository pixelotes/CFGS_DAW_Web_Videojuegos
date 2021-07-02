var game;

// We create our only state, called 'mainState'
var mainState = {
    
    // We define the 3 default Phaser functions

    preload: function () {
        "use strict";
        // This function will be executed at the beginning
           // That's where we load the game's assets
    },

    create: function () {
        "use strict";
        // This function is called after the preload function
        // Here we set up the game, display sprites, etc.;
    },

    update: function () {
        "use strict";
        // This function is called 60 times per second 
        // It contains the game's logic
    }

    // And here we will later add some of our own functions
};