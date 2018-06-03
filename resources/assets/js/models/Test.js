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

    static update(data, testId, action, then) {
        return axios.put(`/tests/${testId}`, { data: data, action: action })
            .then(response => then(response.data));
    };

    static destroy(testId) {
        return axios.delete(`/tests/${testId}`);
    };
}

export default Test;
