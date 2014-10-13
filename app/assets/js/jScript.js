var jScript = (function(){
    var modules = {};
    var executed = {};

    var walk = function(nodeList, callback) {
        for (var i = 0, j = nodeList.length; i < j; i++) {
            callback(nodeList[i]);
        }
    };

    var executeModule = function(moduleName) {
        if (typeof modules[moduleName] == 'undefined') {
            console.error('Failed to execute "' + moduleName + '" module. It appears to be undefined.');
            return;
        }

        // Resolve Dependencies.
        walk(modules[moduleName].requirements, function(requiredModule) {
            executeModule(requiredModule);
        });

        if (typeof executed[moduleName] != 'undefined') {
            // prevent double execution of modules.
            return;
        }

        modules[moduleName].module();
    };

    return {
        walk: walk,

        add: function(name, module, requirements) {

            // force requirements to be an array.
            if (typeof requirements == 'undefined' || !requirements instanceof Array) {
                requirements = [];
            }

            modules[name] = {module: module, requirements: requirements};
        },

        exec: function(moduleNames) {
            walk(moduleNames, executeModule);

        }
    };
})();

window.onload = function() {
    var modules = [];

    jScript.walk(document.getElementById('js-included-modules').value.split(' '), function(moduleName) {
        moduleName = moduleName.trim();
        if (moduleName.length) modules.push(moduleName);
    });

    jScript.exec(modules)
};
