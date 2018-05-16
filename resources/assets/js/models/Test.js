class Test {
    static fetchAll(then) {
        return axios.get('/tests')
            .then(response => then(response.data));
    }
}

export default Test;