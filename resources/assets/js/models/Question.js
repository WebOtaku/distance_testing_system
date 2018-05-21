class Question {
    static store(data, then) {
        return axios.post('/questions', data)
            .then(response => then(response.data));
    };
}

export default Question;
