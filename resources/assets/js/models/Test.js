class Test {
    static fetchAll(then) {
        return axios.get('/tests')
            .then(response => then(response.data));
    };

    static store(data, then) {
        return axios.post('/tests', data)
            .then(response => then(response.data));
    };

    static update(test, value, action) {
        return axios.put('/tests', {
            test: test,
            value: value,
            action: action
        });
    };

    static destroy(test) {
        return axios.delete('/tests', { params: { test: test } });
    };
}

export default Test;
