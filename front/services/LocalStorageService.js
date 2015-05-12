var LocalStorageService = {
    hasLocalStorage: typeof window.localStorage !== 'undefined',

    getValue: function(identifier, key) {
        if (this.hasLocalStorage) {
            var storage = this.getItem(identifier);
            return storage[key];
        }
    },

    setValue: function(identifier, key, value) {
        if (this.hasLocalStorage) {
            var storage = this.getItem(identifier);
            storage[key] = value;
            this.setItem(identifier, JSON.stringify(storage));
        }
    },

    removeValue: function(identifier, key) {
        if (this.hasLocalStorage) {
            var storage = this.getItem(identifier);
            storage[key] = undefined;
            this.setItem(identifier, storage);
        }
    },

    getValues: function(identifier) {
        if (this.hasLocalStorage) {
            return this.getItem(identifier);
        }
    },

    setValues: function(identifier, values) {
        if (this.hasLocalStorage) {
            this.setItem(identifier, values)
        }
    },

    clear: function(identifier) {
        if (this.localStorage) {
            var storage = this.setItem(identifier, undefined);
        }
    },

    getItem: function(identifier) {
        return JSON.parse(localStorage.getItem(identifier));;
    },

    setItem: function(identifier, storage) {
        localStorage.setItem(identifier, JSON.stringify(storage));
    },
}

module.exports = LocalStorageService;
