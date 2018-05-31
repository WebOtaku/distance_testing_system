class Test {
    static fetchAll(pInfo, then) {
        return axios.get('/tests', {
            params: {
                pageNumber: pInfo.pageNumber,
                pageSize: pInfo.pageSize
            }
        }).then(response => then(response.data));
    };

    static fetch(testId, then) {
        return axios.get(`/tests/${testId}`)
            .then(response => then(response.data))
    }

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

    static destroy(testId) {
        return axios.delete(`/tests/${testId}`);
    };
}

export default Test;
