class Question {
    static fetchAll(test, then) {
        return axios.get('/questions', { params: { test: test } })
            .then(response => then(response.data));
    };

    static store(data, then) {
        return axios.post('/questions', data)
            .then(response => then(response.data));
    };

    static destroy(question) {
        return axios.delete('/questions', { params: { question: question } });
    };
}

export default Question;
