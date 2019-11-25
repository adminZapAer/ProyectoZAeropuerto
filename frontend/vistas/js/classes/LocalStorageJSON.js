class LocalStorageJSON{

    static getItems(key){
        return JSON.parse(
            localStorage.getItem(key)
        );
    }

}