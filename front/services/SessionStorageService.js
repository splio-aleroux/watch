var SessionStorageService = {
    hasSessionStorage: typeof window.sessionStorage !== 'undefined',

    getValue: function(identifier, key) {
        if (this.hasSessionStorage) {
            var storage = this.getItem(identifier);
            return storage[key];
        }
    },

    setValue: function(identifier, key, value) {
        if (this.hasSessionStorage) {
            var storage = this.getItem(identifier);
            storage[key] = value;
            this.setItem(identifier, JSON.stringify(storage));
        }
    },

    removeValue: function(identifier, key) {
        if (this.hasSessionStorage) {
            var storage = this.getItem(identifier);
            storage[key] = undefined;
            this.setItem(identifier, storage);
        }
    },

    getValues: function(identifier) {
        if (this.hasSessionStorage) {
            return this.getItem(identifier);
        }
    },

    setValues: function(identifier, values) {
        if (this.hasSessionStorage) {
            this.setItem(identifier, values)
        }
    },

    clear: function(identifier) {
        if (this.hasSessionStorage) {
            var storage = this.setItem(identifier, undefined);
        }
    },

    getItem: function(identifier) {
        return JSON.parse(sessionStorage.getItem(identifier));;
    },

    setItem: function(identifier, storage) {
        sessionStorage.setItem(identifier, JSON.stringify(storage));
    },
}

module.exports = SessionStorageService;
