var jScript = (function(){
    var modules = {};

    var walk = function(nodeList, callback) {
        for (var i = 0, j = nodeList.length; i < j; i++) {
            callback(nodeList[i]);
        }
    };


    return {
        walk: walk,

        add: function(name, module) {
            modules[name] = module;
        },

        exec: function(moduleNames) {
            walk(moduleNames, function(name) {
                modules[name]();
            });

        }
    };
})();

window.onload = function() {
    var modules = [];

    jScript.walk(document.getElementById('js-included-modules').value.split(','), function(moduleName) {
        moduleName = moduleName.trim();
        if (moduleName.length) modules.push(moduleName);
    });

    jScript.exec(modules)
};
