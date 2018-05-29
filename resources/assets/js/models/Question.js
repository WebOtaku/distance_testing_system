class Question {
    static fetchAll(testId, then) {
        return axios.get(`/questions/${testId}`)
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
