class Question {
    static fetchAll(testId, then) {
        return axios.get(`/questions`, { params: { testId: testId } })
            .then(response => then(response.data));
    };

    static fetch(questionId, then) {
        return axios.get(`/questions/${questionId}`)
            .then(response => then(response.data))
    }

    static update(data, questionId, then) {
        return axios.put(`/questions/${questionId}`, data)
            .then(response => then(response.data));
    };

    static store(data, then) {
        return axios.post('/questions', data)
            .then(response => then(response.data));
    };

    static destroy(questionId, then) {
        return axios.delete(`/questions/${questionId}`)
            .then(response => then(response.data));
    };
}

export default Question;
