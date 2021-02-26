class Func {
    static RandomNumber() {
        return Math.floor(100000000 + Math.random() * 900000000);
    }

    static OpenLink(url) {
        if (url) window.open(url);
    }
}

export default Func;
